# Generator

A generic template generator

## Usage

    $ groovey generator:create Controller User


## Installation

    $ composer require groovey/generator

## Setup

On your project root folder, create a file `groovey`.

```php
#!/usr/bin/env php
<?php

set_time_limit(0);

use Symfony\Component\Console\Application;

include __DIR__.'/vendor/autoload.php';

$app = new Application();

$container['generator.config'] = include 'config.php';

$app->addCommands([
        new Groovey\Generator\Commands\About(),
        new Groovey\Generator\Commands\Create($container),
    ]);

$status = $app->run();

exit($status);

```

## Config File

Create `config.php` in your root folder.


```php
<?php

$dir = __DIR__.'/templates';

return [

    'Controller' => [
        'source' => $dir.'/controller.php',
        'destination' => './output/ARG1.php',
        'replace' => [
            'class'    => 'ARG1|ucfirst',
            'comments' => 'Code goes here.',
        ],
    ],
];

```

`Controller` is the key argument.

`Source` is your template.

`Destination` is your destination file output.

`Replace` is where you replace the templates with your contents.

Argument constants such as `ARG1`, `ARG2`, etc will be replace depending on your arguments.

## Templates

Create the template file as defined on your `config.php` file.

Anything that are enclosed by `{{variable}}` will be replaced.

```php
<?php

class {{class}} extends Controller
{

    function __construct()
    {
        // {{comments}}
    }

}
```
## Step 5 - Run

    $ groovey generate:create Controller Sample


## Notes

    $ groovey generate:create Controller User

* `ARG0` - The 0 argument. Value is `Controller`.
* `ARG1` - The 1st argument. Value is `User`.
* `ARG2` - The 2nd argument. Value is `Empty`.
* `ARGN` - The N'th argument.