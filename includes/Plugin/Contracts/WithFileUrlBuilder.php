<?php

namespace EvigDev\PrimaryCategory\Plugin\Contracts;

trait WithFileUrlBuilder {

	protected string $pluginPath;
	protected string $folder;

	public function getFileUrl( string $file ): string {
		return implode(
			'/',
			[
				plugin_dir_url( $this->pluginPath ),
				$this->folder,
				$file,
			]
		);
	}

}
