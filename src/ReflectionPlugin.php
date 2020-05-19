<?php

declare(strict_types=1);

namespace Estasi\PluginManager;

use Ds\Map;
use Estasi\Filter\CamelCase;
use Estasi\Utility\ArrayUtils;
use OutOfBoundsException;
use ReflectionClass;

use function array_combine;
use function array_keys;
use function array_map;
use function array_values;
use function is_null;
use function sprintf;

/**
 * Class ReflectionPlugin
 *
 * @package Estasi\PluginManager
 */
final class ReflectionPlugin extends ReflectionClass
{
    /**
     * Creates a new class instance from given arguments.
     *
     * @link  https://php.net/manual/en/reflectionclass.newinstanceargs.php
     *
     * @param iterable<string, mixed> $args [optional] The parameters to be passed to the class constructor as an array.
     *
     * @return object a new instance of the class.
     * @since 5.1.3
     * @throws \ReflectionException
     */
    public function newInstanceArgs(iterable $args = null)
    {
        $options = ArrayUtils::iteratorToArray($args ?? []);
        // convert options key to camelCase
        $options = new Map(array_combine(array_map(new CamelCase(), array_keys($options)), array_values($options)));
        // get required and optional params __constructor
        $requiredAndOptionalConstructorParams = $this->getRequiredAndOptionalConstructorParams();

        // if the constructor is not defined, we create an object without parameters
        if (is_null($requiredAndOptionalConstructorParams)) {
            return parent::newInstanceArgs();
        }

        [$requiredParams, $optionalParams] = $requiredAndOptionalConstructorParams;
        // check whether all the required parameters are received
        $this->assertMissingRequiredParams($requiredParams->diff($options), $requiredParams->count());
        // defining the required __constructor parameters
        $required = $options->intersect($requiredParams);
        // defining optional parameters of the __constructor
        $optional = $optionalParams->merge($options)
                                   ->intersect($optionalParams);
        // all the parameters of the __constructor
        $args = $required->merge($optional);
        // options
        if ($optional->hasKey('options') && false === $options->hasKey('options')) {
            $undeclared = $options->diff($requiredParams->merge($optionalParams));
            if ($undeclared->count()) {
                $args->put('options', $undeclared);
            }
        }

        return parent::newInstanceArgs($args->toArray());
    }

    /**
     * @return Map[]
     * @throws \ReflectionException
     */
    private function getRequiredAndOptionalConstructorParams(): ?array
    {
        $constructor = $this->getConstructor();
        if (is_null($constructor)) {
            return null;
        }

        $requiredArgs = new Map();
        $optionalArgs = new Map();

        foreach ($constructor->getParameters() as $param) {
            $nameArg = $param->getName();

            if (false === $param->isOptional()) {
                $requiredArgs->put($nameArg, true);
                continue;
            }

            $optionalArgs->put($nameArg, $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null);
        }

        return [$requiredArgs, $optionalArgs];
    }

    /**
     * @param \Ds\Map $missingParams
     * @param int     $countRequiredParams
     *
     * @throws \OutOfBoundsException
     */
    private function assertMissingRequiredParams(Map $missingParams, int $countRequiredParams): void
    {
        if (false === $missingParams->isEmpty()) {
            $expected      = $missingParams->count();
            $missingParams = $missingParams->keys()
                                           ->join(', ');
            throw new OutOfBoundsException(
                sprintf(
                    'Too few arguments to function %s::__construct(), %d passed and at least %d expected: %s!',
                    $this->getName(),
                    ($countRequiredParams - $expected),
                    $expected,
                    $missingParams
                )
            );
        }
    }
}
