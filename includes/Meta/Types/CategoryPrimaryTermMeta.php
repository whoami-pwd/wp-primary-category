<?php

namespace EvigDev\PrimaryCategory\Meta\Types;

use EvigDev\PrimaryCategory\Meta\Contracts\AbstractPrimaryTermMeta;
use EvigDev\PrimaryCategory\Template\Contracts\AbstractTemplate;
use EvigDev\PrimaryCategory\Template\Types\PrimaryCategoryDropdownTemplate;
use WP_Post;

class CategoryPrimaryTermMeta extends AbstractPrimaryTermMeta {

	public const NAME                   = 'evigdev_primary_category';
	protected const POST_TYPES          = [ 'post' ];
	protected const SCRIPT_HANDLE       = 'evigdev-primary-category';
	protected const SCRIPT_FILE         = 'primary-category';
	protected const TEMPLATE_FIELD_NAME = 'evigdev-primary-category-field';
	protected const NONCE_ACTION        = 'evigdev_primary_category_save';
	protected const NONCE               = 'evigdev_primary_category_nonce';

	public function getArguments(): array {
		return [
			'type'              => 'integer',
			'single'            => true,
			'sanitize_callback' => 'absint',
			'show_in_rest'      => true,
		];
	}

	public function savePost( int $post_ID, WP_Post $post, bool $update ): void {
		$primaryCategory = (int) filter_input( INPUT_POST, self::TEMPLATE_FIELD_NAME, FILTER_VALIDATE_INT );

		if ( $primaryCategory <= 0 ) {
			return;
		}

		if ( ! check_admin_referer( self::NONCE_ACTION, self::NONCE ) ) {
			return;
		}

		update_post_meta(
			$post_ID,
			self::NAME,
			$primaryCategory
		);
	}

	protected function getTemplate(): AbstractTemplate {
		return new PrimaryCategoryDropdownTemplate(
			[
				PrimaryCategoryDropdownTemplate::TEMPLATE_FIELD_NAME => self::TEMPLATE_FIELD_NAME,
				PrimaryCategoryDropdownTemplate::TEMPLATE_NONCE      => wp_nonce_field( self::NONCE_ACTION, self::NONCE ),
			]
		);
	}

}
