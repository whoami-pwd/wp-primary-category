<?php

namespace EvigDev\PrimaryCategory\Container\Exceptions;

use InvalidArgumentException;
use Psr\Container\NotFoundExceptionInterface;

class ContainerNotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface {

}
