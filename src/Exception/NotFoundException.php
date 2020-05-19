<?php

declare(strict_types=1);

namespace Estasi\PluginManager\Exception;

use InvalidArgumentException;
use Psr\Container\NotFoundExceptionInterface;

use function sprintf;

/**
 * Class NotFoundException
 *
 * @package Estasi\PluginManager\Exception
 */
class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
    /**
     * @inheritDoc
     */
    public function __construct(string $id, string $class)
    {
        $message = sprintf('A plugin by the name "%s" was not found in the PluginManager "%s"!', $id, $class);
        $code    = 0;
        parent::__construct($message, $code);
    }
}
