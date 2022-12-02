<?php

namespace EvigDev\PrimaryCategory\Enqueue;

use EvigDev\PrimaryCategory\Plugin\Contracts\WithFilePathBuilder;
use EvigDev\PrimaryCategory\Plugin\Contracts\WithFileUrlBuilder;

class ScriptEnqueuer {

	use WithFilePathBuilder, WithFileUrlBuilder;

	public const SCRIPT_EXT = '.js';
	public const ASSET_EXT  = '.asset.php';

	public function __construct( string $pluginPath, string $srcFolder ) {
		$this->pluginPath = $pluginPath;
		$this->folder     = $srcFolder;
	}

	/**
	 * @param string $handle
	 * @param string $fileName Without path and file extension.
	 *
	 * @return bool
	 */
	public function enqueueScript( string $handle, string $fileName ): bool {
		$script    = $this->getFileUrl( $fileName . self::SCRIPT_EXT );
		$assetFile = $this->getFilePath( $fileName . self::ASSET_EXT );

		if ( ! file_exists( $assetFile ) ) {
			return false;
		}

		$assets = require_once $assetFile;

		if ( ! wp_register_script(
			$handle,
			$script,
			$assets['dependencies'] ?? [],
			$assets['version'] ?? null,
			true
		) ) {
			return false;
		}

		wp_enqueue_script( $handle );

		return true;
	}

}
