<?php

namespace EvigDev\PrimaryCategory\Template;

use EvigDev\PrimaryCategory\Plugin\Contracts\WithFilePathBuilder;
use EvigDev\PrimaryCategory\Template\Contracts\AbstractTemplate;

class TemplateLoader {

	use WithFilePathBuilder;

	public const TEMPLATE_EXT = '.php';

	public function __construct( string $pluginPath, string $folder ) {
		$this->pluginPath = $pluginPath;
		$this->folder     = $folder;
	}

	public function loadPluginTemplate( AbstractTemplate $template ): bool {
		$located = false;

		$templateFile = $this->getFilePath( $template->getName() . self::TEMPLATE_EXT );

		if ( file_exists( $templateFile ) ) {
			load_template( $templateFile, false, $template->getArgs() );
			$located = true;
		}

		return $located;
	}

}
