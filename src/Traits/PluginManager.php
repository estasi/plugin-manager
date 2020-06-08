<?php

declare(strict_types=1);

namespace Estasi\PluginManager\Traits;

use Estasi\PluginManager\Exception\ContainerException;

/**
 * Trait PluginManager
 *
 * @package Estasi\PluginManager\Traits
 */
trait PluginManager
{
    /**
     * @inheritDoc
     */
    public function has($id)
    {
        return $this->getPlugins()
                    ->has($id);
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        return $this->build($id);
    }

    /**
     * @inheritDoc
     */
    public function build($name, iterable $options = null)
    {
        $plugin = $this->getPlugins()
                       ->build($name, $options);

        $instanceOf = $this->getInstanceOf();
        if ($instanceOf && false === is_subclass_of($plugin, $instanceOf)) {
            throw new ContainerException(
                sprintf('The plugin class "%s" is not an instance of "%s"!', $name, $instanceOf)
            );
        }

        return $plugin;
    }
}
