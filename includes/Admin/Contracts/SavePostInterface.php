<?php

namespace EvigDev\PrimaryCategory\Admin\Contracts;

use WP_Post;

interface SavePostInterface {











	public function savePost( int $post_ID, WP_Post $post, bool $update ): void;


}
