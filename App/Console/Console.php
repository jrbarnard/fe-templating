<?php
namespace App\Console;

use App\Console\Commands\Serve;
use App\Console\Commands\CacheClear;
use App\Console\Commands\BaseCommand;
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