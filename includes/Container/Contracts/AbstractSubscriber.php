<?php

namespace EvigDev\PrimaryCategory\Container\Contracts;

use Psr\Container\ContainerInterface;

abstract class AbstractSubscriber implements SubscriberInterface {

	/**
	 * @var ContainerInterface
	 */
	protected ContainerInterface $container;

	/**
	 * Abstract_Subscriber constructor.
	 */
	public function __construct( ContainerInterface $container ) {
		$this->container = $container;
	}

}

