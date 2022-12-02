<?php

namespace EvigDev\PrimaryCategory\Plugin;

use EvigDev\PrimaryCategory\Container\Contracts\DefinerInterface;

class PluginDefiner implements DefinerInterface {

	public const SRC_FOLDER          = 'plugin.src_folder';
	public const MIN_PHP_VERSION     = 'plugin.min_php_version';
	public const TRANSLATIONS_FOLDER = 'plugin.translations_folder';

	public function define(): array {
		return [
			self::SRC_FOLDER          => 'dist',
			self::MIN_PHP_VERSION     => '8.1.0',
			self::TRANSLATIONS_FOLDER => 'languages',
		];
	}

}
