<?php

namespace EvigDev\PrimaryCategory\Template;

use EvigDev\PrimaryCategory\Container\Contracts\DefinerInterface;
use EvigDev\PrimaryCategory\Container\PluginContainer;
use Psr\Container\ContainerInterface;

class TemplateDefiner implements DefinerInterface {

	public const TEMPLATE_FOLDER = 'template.folder';

	public function define(): array {
		return [
			self::TEMPLATE_FOLDER => 'templates',
			TemplateLoader::class => static fn( ContainerInterface $container ) => new TemplateLoader(
				$container->get( PluginContainer::PLUGIN_PATH ),
				$container->get( self::TEMPLATE_FOLDER ),
			),
		];
	}
}
