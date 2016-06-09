<?php
namespace Proto\Console;

use Proto\Console\Commands\Serve;
use Proto\Console\Commands\CacheClear;
use Proto\Console\Commands\BaseCommand;
use Symfony\Component\Console\Application;

class Console
{
    public function register()
    {
        return array(
            Serve::class,
            CacheClear::class
        );
    }

    /**
     * @param Application $application
     * @param BaseCommand $command
     * @return bool
     */
    public function registerCommand(Application $application, BaseCommand $command)
    {
        if (!$command->isValid()) {
            return false;
        }

        $application->add($command);
        return $application;
    }
}