<?php

namespace EvigDev\PrimaryCategory\Meta;

use EvigDev\PrimaryCategory\Meta\Contracts\MetaInterface;

class MetaRegistrar {

	public function registerMeta( MetaInterface $meta ): void {
		foreach ( $meta->getPostTypes() as $postType ) {
			register_post_meta( $postType, $meta->getName(), $meta->getArguments() );
		}
	}

}
