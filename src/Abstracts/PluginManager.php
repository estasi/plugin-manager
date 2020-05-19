<?php

declare(strict_types=1);

namespace Estasi\PluginManager\Abstracts;

use Estasi\PluginManager\{
    Exception\ContainerException,
    Interfaces
};

use function is_subclass_of;
use function sprintf;

/**
 * Class PluginManager
 *
 * @package Estasi\PluginManager\Abstracts
 */
abstract class PluginManager implements Interfaces\PluginManager
{
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
    public function has($id)
    {
        return $this->getPlugins()
                    ->has($id);
    }

    /**
     * @inheritDoc
     */
    public function build(string $id, iterable $options = null): object
    {
        $plugin = $this->getPlugins()
                       ->build($id, $options);

        $instanceOf = $this->getInstanceOf();
        if ($instanceOf && false === is_subclass_of($plugin, $instanceOf)) {
            throw new ContainerException(
                sprintf('The plugin class "%s" is not an instance of "%s"!', $id, $instanceOf)
            );
        }

        return $plugin;
    }
}
