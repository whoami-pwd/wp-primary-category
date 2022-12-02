<?php

namespace EvigDev\PrimaryCategory\Enqueue;

use EvigDev\PrimaryCategory\Container\Contracts\DefinerInterface;
use EvigDev\PrimaryCategory\Container\PluginContainer;
use EvigDev\PrimaryCategory\Plugin\PluginDefiner;
use Psr\Container\ContainerInterface;

class EnqueueDefiner implements DefinerInterface {

	public function define(): array {
		return [
			ScriptEnqueuer::class => static fn( ContainerInterface $container ) => new ScriptEnqueuer(
				$container->get( PluginContainer::PLUGIN_PATH ),
				$container->get( PluginDefiner::SRC_FOLDER ),
			),
		];
	}
}
