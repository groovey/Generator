<?php

$dir = __DIR__ . '/template';

return [

    'Controller' => [
        'source' => $dir . '/controller.php',
        'destination' => './output/ARG1.php',
        'replace' => [
            'class'    => 'ARG1|ucfirst',
            'comments' => 'Code goes here.'
        ]
    ]
];