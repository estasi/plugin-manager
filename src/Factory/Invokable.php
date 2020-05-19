<?php

declare(strict_types=1);

namespace Estasi\PluginManager\Factory;

use Estasi\PluginManager\{
    Interfaces\Factory,
    ReflectionPlugin
};

/**
 * Class Invokable
 *
 * @package Estasi\PluginManager\Factory
 */
final class Invokable implements Factory
{
    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function __invoke(string $class, iterable $options = null): object
    {
        return (new ReflectionPlugin($class))->newInstanceArgs($options);
    }
}
