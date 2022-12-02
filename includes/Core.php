<?php declare( strict_types=1 );

namespace EvigDev\PrimaryCategory;

use EvigDev\PrimaryCategory\Enqueue\EnqueueDefiner;
use EvigDev\PrimaryCategory\Plugin\PluginDefiner;
use EvigDev\PrimaryCategory\Plugin\PluginSubscriber;
use EvigDev\PrimaryCategory\Admin\AdminDefiner;
use EvigDev\PrimaryCategory\Admin\AdminSubscriber;
use EvigDev\PrimaryCategory\Container\PluginContainer;
use EvigDev\PrimaryCategory\Meta\MetaDefiner;
use EvigDev\PrimaryCategory\Meta\MetaSubscriber;
use EvigDev\PrimaryCategory\Template\TemplateDefiner;

class Core {

	/**
	 * @var string []
	 */
	private array $definers = [
		AdminDefiner::class,
		EnqueueDefiner::class,
		MetaDefiner::class,
		PluginDefiner::class,
		TemplateDefiner::class,
	];

	/**
	 * @var string[]
	 */
	private array $subscribers = [
		AdminSubscriber::class,
		MetaSubscriber::class,
		PluginSubscriber::class,
	];

	private static self $instance;

	/**
	 * @return self
	 */
	public static function instance(): self {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @throws \Exception
	 */
	public function init( string $plugin_path ): void {
		$this->initContainer( $plugin_path );
	}

	/**
	 * @throws \Exception
	 */
	private function initContainer( string $pluginPath ): void {

		/**
		 * Filter the list of definers that power the plugin
		 *
		 * @param string[] $definers The class names of definers that will be instantiated
		 */
		$definers = apply_filters( 'evigdev/primary_category/definers', $this->definers );

		/**
		 * Filter the list subscribers that power the plugin
		 *
		 * @param string[] $subscribers The class names of subscribers that will be instantiated
		 */
		$subscribers = apply_filters( 'evigdev/primary_category/subscribers', $this->subscribers );

		$container = new PluginContainer(
			$pluginPath,
			array_map( fn( $classname ) => ( new $classname() )->define(), $definers )
		);

		foreach ( $subscribers as $subscriber_class ) {
			( new $subscriber_class( $container ) )->register();
		}
	}

}
