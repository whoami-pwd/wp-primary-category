<?php

namespace EvigDev\PrimaryCategory\Admin;

use EvigDev\PrimaryCategory\Container\Contracts\DefinerInterface;

class AdminDefiner implements DefinerInterface {

	public function define(): array {
		return [
			AdminPageAnalizer::class => null,
		];
	}
}
