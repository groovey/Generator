<?php

namespace Groovey\Generator;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Filesystem\Filesystem;

class Generator
{
    public $config;

    public function __construct()
    {
    }

    public function load($config)
    {
        $fs     = new Filesystem();
        $output = new ConsoleOutput();

        if (!$fs->exists($config)) {
            $output->writeln("<error>Can't find config file ($config).</error>");
            exit();
        }

        $config = include $config;

        $this->config = $config;
    }

    public function getCommands()
    {
        return [
            new Commands\Create($this->config),
            new Commands\About(),
        ];
    }
}
