<?php

namespace EvigDev\PrimaryCategory\Plugin;

use EvigDev\PrimaryCategory\Container\Contracts\AbstractSubscriber;
use EvigDev\PrimaryCategory\Container\PluginContainer;

class PluginSubscriber extends AbstractSubscriber {

	public function register(): void {
		/**
		 * PHP version checker.
		 */
		register_activation_hook(
			$this->container->get( PluginContainer::PLUGIN_PATH ),
			function () {
				if ( version_compare( PHP_VERSION, $this->container->get( PluginDefiner::MIN_PHP_VERSION ), '<' ) ) {
					die(
					/* translators: %s php version */
						sprintf( esc_html__( 'Minimal PHP version required for the plugin is %s', 'evigdev' ), $this->container->get( PluginDefiner::MIN_PHP_VERSION ) )
					);
				}
			}
		);

		/**
		 * Enable translations.
		 */
		$translationFolder = dirname( $this->container->get( PluginContainer::PLUGIN_PATH ) ) . DIRECTORY_SEPARATOR . $this->container->get( PluginDefiner::TRANSLATIONS_FOLDER );
		add_action(
			'init',
			function () use ( $translationFolder ) {
				load_plugin_textdomain( 'evigdev', false, $translationFolder );
			},
			10,
			0
		);
	}

}
