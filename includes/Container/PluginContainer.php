<?php

namespace EvigDev\PrimaryCategory\Container;

use Closure;
use EvigDev\PrimaryCategory\Container\Exceptions\ContainerException;
use EvigDev\PrimaryCategory\Container\Exceptions\ContainerNotFoundException;
use Psr\Container\ContainerInterface;

class PluginContainer implements ContainerInterface {

	public const PLUGIN_PATH = 'plugin.path';

	private array $entries;
	private array $resolvedEntries;

	public function __construct( string $pluginPath, array $entries ) {
		$this->entries = array_merge(
			[
				self::class       => $this,
				self::PLUGIN_PATH => $pluginPath,
			],
			$this->entriesMergeRecursive( $entries ),
		);
	}

	public function get( string $id ) {
		if ( ! isset( $this->resolvedEntries[ $id ] ) ) {
			$this->resolvedEntries[ $id ] = $this->resolve( $id );
		}

		return $this->resolvedEntries[ $id ];
	}

	public function has( string $id ): bool {
		return array_key_exists( $id, $this->entries );
	}

	protected function entriesMergeRecursive( array $entries ): array {
		$mergedEntries = [];
		for ( $i = 0; $i < count( $entries ); $i ++ ) {
			foreach ( $entries[ $i ] as $item => $value ) {
				if ( ! $item || ! is_string( $item ) ) {
					throw new ContainerException(
					/* translators: 1: entity name 2: type of entity name */
						sprintf( esc_html__( 'An entry identifier must be a string: %1$s of type %2$s provided', 'evigdev' ), $item, gettype( $item ) )
					);
				}
				if ( isset( $mergedEntries[ $item ] ) ) {
					throw new ContainerException(
					/* translators: %s entity name. */
						sprintf( esc_html__( 'Container key %s already exists', 'evigdev' ), $item )
					);
				}

				$mergedEntries[ $item ] = $value;
			}
		}

		return $mergedEntries;
	}

	protected function resolve( string $id ) {
		// Value can be null.
		if ( ! $this->has( $id ) ) {
			throw new ContainerNotFoundException(
			/* translators: %s entity name. */
				sprintf( esc_html__( 'Unable to find the definition', 'evigdev' ), $id )
			);
		}

		try {
			$value   = $this->entries[ $id ];
			$isClass = class_exists( $id );

			if ( is_resource( $value ) ) {
				throw new ContainerException(
					esc_html__( 'Container does not support resources', 'evigdev' )
				);
			}

			// Simple value.
			if ( ! $isClass && ! interface_exists( $id ) ) {
				if ( is_object( $value ) ) {
					throw new ContainerException(
						esc_html__( 'Object type can be bound only to an instantiated object ID', 'evigdev' )
					);
				}

				return $value;
			}

			// Simple class.
			if ( $isClass && $value === null ) {
				return $this->resolveSimpleCLass( $id );
			}

			// Class with dependencies or and Interface injection.
			if ( $value instanceof Closure ) {
				return $this->resolveClassWithSpecifiedInstance( $id, $value );
			}

			throw new ContainerException( esc_html__( 'Wrong value for binding %s', 'evigdev' ) );
		} catch ( \Exception $e ) {
			throw new ContainerException(
			/* translators: 1: entity name 2: exception message */
				sprintf( esc_html__( 'Unable to resolve %1$s: %2$s', 'evigdev' ), $id, $e->getMessage() ),
				$e->getCode(),
				$e
			);
		}
	}

	/**
	 * @param string $id
	 *
	 * @return object
	 */
	protected function resolveSimpleClass( string $id ): object {
		return new $id();
	}

	/**
	 * @param string  $id
	 * @param Closure $value
	 *
	 * @return object
	 * @throws ContainerException
	 */
	protected function resolveClassWithSpecifiedInstance( string $id, Closure $value ): object {
		$object = call_user_func( $value, $this );
		if ( $object instanceof $id ) {
			return $object;
		}

		throw new ContainerException(
		/* translators: %s entity name. */
			sprintf( esc_html__( 'The bounded object should be the instance of %s', 'evigdev' ), $id ),
		);
	}

}
