<?php
/**
 *
 * @package    Action
 * @author     Quentin
 * @since      2016/8/16 16:56
 */

namespace Acme\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DemoCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:demo')
            ->setDescription('this is a command demo')
            ->setHelp("this is a command demo")
            ->addOption('option1', '-o', InputOption::VALUE_OPTIONAL, 'option1 description', 'option1-value');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $i     = 1;
        $total = 1000;
        while ($i++ < $total) {
            echo "\r$i/$total";
            usleep(50000);
        }
    }
}