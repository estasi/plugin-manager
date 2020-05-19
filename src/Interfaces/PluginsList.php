<?php

declare(strict_types=1);

namespace Estasi\PluginManager\Interfaces;

/**
 * Interface PluginsList
 *
 * @package Estasi\PluginManager\Interfaces
 */
interface PluginsList extends Build
{
    /**
     * PluginsList constructor.
     *
     * @param \Estasi\PluginManager\Interfaces\Plugin ...$plugins
     */
    public function __construct(Plugin ...$plugins);
}
