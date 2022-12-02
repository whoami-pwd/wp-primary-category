<?php

namespace EvigDev\PrimaryCategory\Template\Contracts;

use EvigDev\PrimaryCategory\Plugin\Contracts\WithAssociativeArrayChecker;
use UnexpectedValueException;

abstract class AbstractTemplate {

	use WithAssociativeArrayChecker;

	protected array $args;

	public function __construct( array $args = [] ) {
		$this->args = $this->parseArgs( $args );
	}

	abstract public function getName(): string;

	abstract protected function getDefaults(): array;

	abstract protected function getRequired(): array;

	public function getArgs(): array {
		return $this->args;
	}

	/**
	 * TODO: needs testing.
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	protected function parseArgs( array $args ): array {
		$defaults = $this->getDefaults();
		$required = $this->getRequired();

		if ( ! $this->isAssociative( $args, true ) || ! $this->isAssociative( $defaults, true ) ) {
			throw new UnexpectedValueException( esc_html__( 'Template arguments array must be associative', 'evigdev' ) );
		}

		if ( $required ) {
			if ( $this->isAssociative( $required ) ) {
				throw new UnexpectedValueException( esc_html__( 'Required template arguments array must be not associative', 'evigdev' ) );
			}

			if ( array_diff_key( array_flip( $required ), $args ) ) {
				throw new UnexpectedValueException( esc_html__( 'Required template arguments must be provided', 'evigdev' ) );
			}
		}

		return wp_parse_args( $args, $defaults );
	}

}
