<?php namespace Groovey\Generator\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class Create extends Command
{
    public $config;

    public $input;

    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
    }

    protected function configure()
    {
        $this
            ->setName('generator:create')
            ->setDescription('Creates a predefined template.')
            ->addArgument(
                'arg',
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'The required arguments.'
            )
        ;
    }

    public function replaceArguments($text)
    {
        $arg = $this->input->getArgument('arg');

        $cnt = 0;
        foreach ($arg as $value) {
            $text = str_replace("ARG{$cnt}", $arg[$cnt], $text);
            $cnt++;
        }

        return $text;
    }

    public function replaceContent($data)
    {

        $temp = [];
        foreach ($data as $key => $value) {

            if (strpos($value, '|' )) {
                $temp[$key] = $this->processDelimeter($value);
            } else {
                $temp[$key] = $value;
            }
        }

        return $temp;
    }

    public function processDelimeter($data)
    {
        $text = '';
        foreach (explode('|', $data) as $value) {

            if (substr($value, 0 , 3) == 'ARG') {

                $text = $this->replaceArguments($value);

            } else {

                switch ($value) {
                    case 'strtoupper':  $text = strtoupper($text);  break;
                    case 'strtolower':  $text = strtolower($text);  break;
                    case 'ucfirst':     $text = ucfirst($text);     break;
                    default: break;
                }
            }
        }

        return $text;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->input = $input;
        $arg         = $input->getArgument('arg');
        $fs          = new Filesystem();
        $config      = $this->config[$arg[0]];
        $pathinfo    = pathinfo($config['source']);
        $loader      = new \Twig_Loader_Filesystem($pathinfo['dirname']);
        $twig        = new \Twig_Environment($loader);
        $destination = $this->replaceArguments($config['destination'], $input);

        if (!array_key_exists($arg[0], $this->config)) {
            $output->writeln('<error>The key command does not exits. Check your config file.</error>');
            return;
        }

        if (!$fs->exists(dirname($destination))) {
            $output->writeln("<error>The destination folder does not exist already exist ($destination).</error>");
            return;
        }

        if ($fs->exists($destination)) {
            $output->writeln("<error>Unable to create the destination file. File already exist ($destination).</error>");
            return;
        }

        $contents = $twig->render(
            $pathinfo['basename'],
            $this->replaceContent($config['replace'])
        );

        file_put_contents($destination , $contents);

        $output->writeln("<info>Sucessfully created template ($destination).</info>");
    }

}
