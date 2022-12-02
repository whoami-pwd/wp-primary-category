<?php

namespace EvigDev\PrimaryCategory\Meta;

use EvigDev\PrimaryCategory\Admin\AdminPageAnalizer;
use EvigDev\PrimaryCategory\Container\Contracts\DefinerInterface;
use EvigDev\PrimaryCategory\Enqueue\ScriptEnqueuer;
use EvigDev\PrimaryCategory\Meta\Types\CategoryPrimaryTermMeta;
use EvigDev\PrimaryCategory\Template\TemplateLoader;
use Psr\Container\ContainerInterface;

class MetaDefiner implements DefinerInterface {

	public function define(): array {
		return [
			MetaRegistrar::class           => null,
			CategoryPrimaryTermMeta::class => fn( ContainerInterface $container ) => new CategoryPrimaryTermMeta(
				$container->get( AdminPageAnalizer::class ),
				$container->get( ScriptEnqueuer::class ),
				$container->get( TemplateLoader::class ),
			),
		];
	}

}
