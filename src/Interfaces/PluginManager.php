<?php

declare(strict_types=1);

namespace Estasi\PluginManager\Interfaces;

/**
 * Interface PluginManager
 *
 * @package Estasi\PluginManager\Interfaces
 */
interface PluginManager extends Build
{
    /**
     * Returns an object type that the created instance must be instanced of
     *
     * @return string|null
     * @internal
     */
    public function getInstanceOf(): ?string;

    /**
     * Returns a list of plugins
     *
     * @return \Estasi\PluginManager\Interfaces\PluginsList
     * @internal
     */
    public function getPlugins(): PluginsList;
}
