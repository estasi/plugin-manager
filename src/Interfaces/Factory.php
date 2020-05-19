<?php

declare(strict_types=1);

namespace Estasi\PluginManager\Interfaces;

/**
 * Interface Factory
 *
 * @package Estasi\PluginManager\Interfaces
 */
interface Factory
{
    /**
     * Returns the created object based on the specified schema
     *
     * @param string                       $class
     * @param iterable<string, mixed>|null $options
     *
     * @return object
     */
    public function __invoke(string $class, iterable $options = null): object;
}
