<?php
namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Serve
 * This command serves the application using php 5.4's built in server
 * @package App\Console\Commands
 */
class Serve extends BaseCommand
{
    protected $command = 'serve';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ((float) phpversion() < 5.4) {
            $output->writeln('You must have php version 5.4 or above to run this command');
            return;
        }

        $host = "localhost:8000";

        $output->writeln('Starting php built in server');
        $output->writeln('Available at http://' . $host);

        exec("open http://" . $host);
        exec("php -S " . $host . " -t public/");
    }
}