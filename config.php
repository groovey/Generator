<?php

$dir = __DIR__ . '/template';

return [

    'Controller' => [
        'source' => $dir . '/template.php',
        'destination' => './output/ARG1.php',
        'replace' => [
            'class' => 'ARG1|ucfirst',
            'data'  => 'Your data contents'
        ]
    ]
];