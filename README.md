# Estasi PluginManager

PluginManager is a _specialized_ service Manager used for creating uniform objects 
of a certain type, such as Estasi\Validator and Estasi\Filter use specialized corresponding 
PluginManager.

## Installation
To install with a composer:
```
composer require estasi/plugin-manager
```

## Requirements
- PHP 7.4 or newer
- [Data Structures](https://github.com/php-ds/polyfill): 
    `composer require php-ds/php-ds`
    <br><small><i>Polyfill is installed with the estasi/plugin-manager package.</i></small>
- [Container interface](https://github.com/php-fig/container)
    `composer require psr/container`
    <br><small><i>Polyfill is installed with the estasi/plugin-manager package.</i></small>
    
## Usage
### Creating a plugin manager
To create a plugin manager, you first need to create a new class that extends 
`Estasi\PluginManager\Abstracts\PluginManager`:
```php
<?php

declare(strict_types=1);

use Estasi\PluginManager\{Abstracts,Interfaces,Plugin,PluginsList};

class MyPluginManager extends Abstracts\PluginManager {

    public function getInstanceOf(): ?string
    {
        // TODO: Implement getInstanceOf() method.
        return 'MyBasicClass';
    }

    public function getPlugins(): Interfaces\PluginsList
    {
        // TODO: Implement getPlugins() method.
        return new PluginsList(
            new Plugin(MyFirstClass::class, ['first', 'First', /*...  aliases of class*/]),
            new Plugin('MySecondClass', ['second', 'Second', /*... aliases of class */], new MyFactoryForSecondClass()),
        );
    }
}
```
### Using PluginManager
Then you can create a class from PluginManager
```php
<?php

declare(strict_types=1);

$myPluginManager = new MyPluginManager();

// Creating a object without constructor parameters
$myFirstClass = $myPluginManager->get(MyFirstClass::class);
// or
$myFirstClass = $myPluginManager->build('first');

// With the parameters necessary (or optional) to create the object
$myFirstClass = $myPluginManager->build('First', ['foo' => 'bar', 'bar' => 'foo']);
```

### Note

To create objects, the factory used by default uses the modified `\ReflectionClass` class.
Its special feature is that all constructor parameters must be in CamelCase notation.

If the constructor has the `options` parameter, all parameters passed to create the class object, 
but not found in the constructor, fall into this parameter. If there are no `options` in the parameters 
passed to create the class, they are ignored.

Default parameter values are substituted if they are not found in the passed values.

```php
<?php

declare(strict_types=1);

class MyFirstClass {

    public function __construct($foo, $bar = 'foo', iterable $options = null)
    {
        // your code
    }
}
```
```php
<?php

declare(strict_types=1);

$myPluginManager = new MyPluginManager();

// "foo" required parameter. if it is not present, the \OutOfBoundsException exception will be created
// the optional "bar" parameter will get the default value "foo"
// the undeclared "baz" parameter will be included in the "options" parameter: ["baz" = "baz"]
$myFirstClass = $myPluginManager->build(MyFirstClass::class, ['foo' => 'bar', 'baz' => 'baz']);

// the same thing
// if you use this method all undeclared parameters will not be used when creating the object 
// and will not be included in "options"
$myFirstClass = $myPluginManager->build(MyFirstClass::class, ['foo' => 'bar', 'options' => ['baz' => 'baz'], 'param' => 'value']);
```

## License
All contents of this package are licensed under the [BSD-3-Clause license](https://github.com/estasi/plugin-manager/blob/master/LICENSE.md).