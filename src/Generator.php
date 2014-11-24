<?php namespace Groovey\Generator;

class Generator
{
    public $config;

    public function __construct()
    {
    }

    public function load($config)
    {

        $config = include $config;

        $this->config = $config;
    }

    public function getCommands()
    {
        return [
            new Commands\Create($this->config),
            new Commands\About()
        ];
    }

}
