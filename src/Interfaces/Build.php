<?php

declare(strict_types=1);

namespace Estasi\PluginManager\Interfaces;

use Psr\Container\ContainerInterface;

/**
 * Interface Build
 *
 * @package Estasi\PluginManager\Interfaces
 */
interface Build extends ContainerInterface
{
    /**
     * Creates and returns an object of the requested class with the passed parameters in the constructor
     *
     * @param string                       $id
     * @param iterable<string, mixed>|null $options
     *
     * @return object
     * @throws \Estasi\PluginManager\Exception\NotFoundException
     * @throws \Estasi\PluginManager\Exception\ContainerException
     * @api
     */
    public function build(string $id, iterable $options = null): object;
}
