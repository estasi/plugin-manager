<?php

declare(strict_types=1);

namespace Estasi\PluginManager\Abstracts;

use Estasi\PluginManager\{
    Interfaces,
    Traits\PluginManager as PluginManagerTrait
};

/**
 * Class PluginManager
 *
 * @package Estasi\PluginManager\Abstracts
 */
abstract class PluginManager implements Interfaces\PluginManager
{
    use PluginManagerTrait;
}
