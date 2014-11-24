Generator
=========

An agnostic generic template generator that is easy to use. Simplifies your workflow on creating your templates. A highly customizable generator.

## Usage

    $ groovey generator:create Controller User


## Installation

Install using composer. To learn more about composer, visit: https://getcomposer.org/

```json
{
    "require": {
        "groovey/generator": "~1.0"
    }
}
```

Then run `composer.phar` update.

## The Groovey File

```php
#!/usr/bin/env php
<?php

set_time_limit(0);

use Symfony\Component\Console\Application;
use Groovey\Generator\Generator;

include __DIR__ . '/vendor/autoload.php';

$generator = new Generator;
$app       = new Application;

$generator->load('config.php');

$app->addCommands(
        $generator->getCommands()
    );

$status = $app->run();

exit($status);
```
