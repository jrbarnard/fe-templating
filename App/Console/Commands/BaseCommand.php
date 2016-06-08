<?php
namespace App\Console\Commands;
use Symfony\Component\Console\Command\Command;

/**
 * Class BaseCommand
 * @package App\Console\Commands
 */
abstract class BaseCommand extends Command
{
    /**
     * The command string that the console will expect
     * @var null
     */
    protected $command = null;

    /**
     * Register the individual command
     */
    protected function configure()
    {
        $this->setName($this->getCommand());
    }

    /**
     * Getter for command string
     * @return null
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Check if the command string is a string
     * @return bool
     */
    public function isValid()
    {
        if (!is_string($this->getCommand())) {
            return false;
        }

        return true;
    }
}