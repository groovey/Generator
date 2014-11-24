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


## The Config File

```php
<?php

$dir = __DIR__ . '/template';

return [
    'Controller' => [
        'source' => $dir . '/template.php',
        'destination' => './output/ARG1.php',
        'replace' => [
            'class' => 'ARG1|ucfirst',
            'data'  => 'Code goes here.'
        ]
    ]

    // Etc.
];
```

This is where you can customize your templates.

### Things To Remember

    $ groovey generator:create Controller User

`ARG0` - The 0 argument. Value is `Controller`.
`ARG1` - The 1st argument. Value is `User`.
`ARG2` - The 2nd argument. Value is `Empty`.

`ARGN` - The N'th argument.


## Like Us.

Give a `star` to show your support and love for the project.

## Contribution

Fork `Groovey Seeder` and send us some issues.
