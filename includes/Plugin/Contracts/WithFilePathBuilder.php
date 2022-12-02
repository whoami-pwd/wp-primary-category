<?php

namespace EvigDev\PrimaryCategory\Plugin\Contracts;

trait WithFilePathBuilder {

	protected string $pluginPath;
	protected string $folder;

	public function getFilePath( string $file ): string {
		return implode(
			DIRECTORY_SEPARATOR,
			[
				dirname( $this->pluginPath ),
				$this->folder,
				$file,
			]
		);
	}

}
