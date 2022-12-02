<?php

namespace EvigDev\PrimaryCategory\Meta\Contracts;

interface MetaInterface {











	public function getName(): string;

	/**
	 * @return string[]
	 */
	public function getPostTypes(): array;

	public function getArguments(): array;


}
