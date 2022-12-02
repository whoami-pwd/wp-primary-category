<?php

namespace EvigDev\PrimaryCategory\Admin;

use EvigDev\PrimaryCategory\Container\Contracts\AbstractSubscriber;
use EvigDev\PrimaryCategory\Meta\Contracts\AbstractPrimaryTermMeta;
use EvigDev\PrimaryCategory\Meta\Types\CategoryPrimaryTermMeta;
use WP_Post;

class AdminSubscriber extends AbstractSubscriber {

	public function register(): void {

		/**
		 * @var $metas AbstractPrimaryTermMeta[]
		 */
		$metas = [
			$this->container->get( CategoryPrimaryTermMeta::class ),
		];

		add_action(
			'admin_enqueue_scripts',
			function ( string $hook_suffix ) use ( $metas ) {
				foreach ( $metas as $meta ) {
					$meta->enqueueScript( $hook_suffix );
				}
			},
			10,
			1
		);

		add_action(
			'admin_footer',
			function () use ( $metas ) {
				foreach ( $metas as $meta ) {
					$meta->loadTemplate();
				}
			},
			10,
			0
		);

		add_action(
			'save_post',
			function( int $post_ID, WP_Post $post, bool $update ) use ( $metas ) {
				foreach ( $metas as $meta ) {
					$meta->savePost( $post_ID, $post, $update );
				}
			},
			10,
			3
		);
	}


}
