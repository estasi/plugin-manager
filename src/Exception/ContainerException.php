<?php

declare(strict_types=1);

namespace Estasi\PluginManager\Exception;

use Psr\Container\ContainerExceptionInterface;
use RuntimeException;

/**
 * Class ContainerException
 *
 * @package Estasi\PluginManager\Exception
 */
class ContainerException extends RuntimeException implements ContainerExceptionInterface
{

}
