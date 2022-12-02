<?php

namespace EvigDev\PrimaryCategory\Template\Types;

use EvigDev\PrimaryCategory\Template\Contracts\AbstractTemplate;

class PrimaryCategoryDropdownTemplate extends AbstractTemplate {

	public const TEMPLATE_NAME = 'primary-category-dropdown';

	public const TEMPLATE_TITLE          = 'template_title';
	public const TEMPLATE_FIELD_NAME     = 'template_field_name';
	public const TEMPLATE_DEFAULT_OPTION = 'template_default_option';
	public const TEMPLATE_NONCE          = 'template_nonce';

	public function getName(): string {
		return self::TEMPLATE_NAME;
	}

	protected function getDefaults(): array {
		return [
			self::TEMPLATE_TITLE          => esc_html__( 'Primary Category', 'evigdev' ),
			self::TEMPLATE_DEFAULT_OPTION => esc_html__( '- Select Primary Category -', 'evigdev' ),
		];
	}

	protected function getRequired(): array {
		return [
			self::TEMPLATE_FIELD_NAME,
			self::TEMPLATE_NONCE,
		];
	}

}
