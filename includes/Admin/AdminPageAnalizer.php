<?php

namespace EvigDev\PrimaryCategory\Admin;

use WP_Screen;

class AdminPageAnalizer {

	/**
	 * @param string[] $targetPosts Allowed screen post types.
	 *
	 * @return bool
	 */
	public function isTargetAdminPage( array $targetPosts ): bool {
		$currentScreen = get_current_screen();
		if ( ! $currentScreen instanceof WP_Screen ) {
			return false;
		}

		return $currentScreen->base === 'post' && in_array( $currentScreen->post_type, $targetPosts );
	}

}
