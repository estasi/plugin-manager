<?php

declare(strict_types=1);

namespace Estasi\PluginManager;

use Ds\Vector;
use Estasi\PluginManager\{
    Exception\ContainerException,
    Exception\NotFoundException,
    Factory\Invokable,
    Interfaces\Factory
};

use function class_exists;
use function sprintf;

/**
 * Class Plugin
 *
 * @package Estasi\PluginManager
 */
final class Plugin implements Interfaces\Plugin
{
    private Vector   $container;
    private Factory  $factory;

    /**
     * @inheritDoc
     */
    public function __construct(
        string $name,
        iterable $aliases = self::WITHOUT_ALIASES,
        ?Factory $factory = self::DEFAULT_FACTORY
    ) {
        $this->factory   = $factory ?? new Invokable();
        $this->container = new Vector($aliases);
        $this->container->push($name);
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
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
        return $this->container->contains($id);
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function build(string $id, iterable $options = null): object
    {
        if (false === $this->has($id)) {
            throw new NotFoundException($id, self::class);
        }

        $class = $this->container->last();
        if (false === class_exists($class)) {
            throw new ContainerException(
                sprintf('Plugin named "%s" cannot be created, because class "%s" not found!', $id, $class)
            );
        }

        return ($this->factory)($class, $options);
    }
}
