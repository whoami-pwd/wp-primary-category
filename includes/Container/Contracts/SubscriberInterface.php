<?php

namespace EvigDev\PrimaryCategory\Container\Contracts;

interface SubscriberInterface {

	/**
	 * Register action/filter listeners to hook into WordPress
	 *
	 * @return void
	 */
	public function register(): void;
}
