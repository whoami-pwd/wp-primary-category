<?php

namespace EvigDev\PrimaryCategory\Meta;

use EvigDev\PrimaryCategory\Container\Contracts\AbstractSubscriber;
use EvigDev\PrimaryCategory\Meta\Types\CategoryPrimaryTermMeta;

class MetaSubscriber extends AbstractSubscriber {

	public function register(): void {
		add_action(
			'init',
			function() {
				$this->container->get( MetaRegistrar::class )->registerMeta(
					$this->container->get( CategoryPrimaryTermMeta::class )
				);
			},
			10,
			0
		);
	}

}
