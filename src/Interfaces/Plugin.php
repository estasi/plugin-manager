<?php

declare(strict_types=1);

namespace Estasi\PluginManager\Interfaces;

/**
 * Interface Plugin
 *
 * @package Estasi\PluginManager\Interfaces
 */
interface Plugin extends Build
{
    public const WITHOUT_ALIASES = null;
    public const DEFAULT_FACTORY = null;

    /**
     * Plugin constructor.
     *
     * @param string                                        $name    plugin name (full class name, for example,
     *                                                               SampleClass::class)
     * @param string[]|null                                 $aliases names of plugin synonyms
     * @param \Estasi\PluginManager\Interfaces\Factory|null $factory name of the factory to create the plugin
     */
    public function __construct(
        string $name,
        iterable $aliases = self::WITHOUT_ALIASES,
        ?Factory $factory = self::DEFAULT_FACTORY
    );
}
