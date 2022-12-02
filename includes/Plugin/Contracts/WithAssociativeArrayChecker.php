<?php

namespace EvigDev\PrimaryCategory\Plugin\Contracts;

trait WithAssociativeArrayChecker {

	public function isAssociative( array $arr, bool $allowEmpty = false ): bool {
		if ( ! $arr ) {
			return $allowEmpty;
		}

		return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
	}

}
