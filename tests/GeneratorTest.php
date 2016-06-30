<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Groovey\Generator\Commands\About;
use Groovey\Generator\Commands\Create;

class GeneratorTest extends PHPUnit_Framework_TestCase
{
    public function testAbout()
    {
        $app = new Application();
        $app->add(new About());
        $command = $app->find('generate:about');
        $tester = new CommandTester($command);

        $tester->execute([
                'command' => $command->getName(),
            ]);

        $this->assertRegExp('/Groovey/', $tester->getDisplay());
    }

    public function testCreateFolder()
    {
        $fs = new Filesystem();
        try {
            $fs->mkdir('./output', 0775);
        } catch (IOExceptionInterface $e) {
            echo 'An error while creating the folder '.$e->getPath();
        }
    }

    public function testCreate()
    {
        $container['generator.config'] = include 'config.php';

        $app = new Application();
        $app->add(new Create($container));
        $command = $app->find('generate:create');
        $tester = new CommandTester($command);

        $tester->execute([
                'command' => $command->getName(),
                'arg'   => ['Controller', 'Users'],
            ]);

        $this->assertRegExp('/Sucessfully/', $tester->getDisplay());
    }

    public function testDelete()
    {
        $fs = new Filesystem();
        try {
            $fs->remove(['./output/Users.php']);
        } catch (IOExceptionInterface $e) {
            echo 'An error while deleting the file '.$e->getPath();
        }
    }
}
