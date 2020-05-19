<?php

declare(strict_types=1);

namespace Estasi\PluginManager;

use Ds\{
    Map,
    Vector
};
use Estasi\PluginManager\{
    Exception\NotFoundException,
    Interfaces\Plugin
};

/**
 * Class PluginsList
 *
 * @package Estasi\PluginManager
 */
final class PluginsList implements Interfaces\PluginsList
{
    /** @var \Ds\Vector|Plugin[] */
    private Vector  $plugins;
    private Map     $storage;

    /**
     * @inheritDoc
     */
    public function __construct(Plugin ...$plugins)
    {
        $this->plugins = new Vector($plugins);
        $this->storage = new Map();
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
    public function has($id)
    {
        foreach ($this->plugins as $key => $plugin) {
            if ($plugin->has($id)) {
                $this->storage->put($id, $key);

                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function build(string $id, iterable $options = null): object
    {
        /** @var Plugin|null $plugin */
        $plugin = null;

        if ($this->storage->hasKey($id)) {
            $plugin = $this->plugins->get($this->storage->get($id));
            goto _return_;
        }

        foreach ($this->plugins as $key => $plugin) {
            if ($plugin->has($id)) {
                $this->storage->put($id, $key);
                goto _return_;
            }
        }
        throw new NotFoundException($id, self::class);

        _return_:

        return $plugin->build($id, $options);
    }
}
