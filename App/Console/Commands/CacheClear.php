<?php
namespace App\Console\Commands;

use App\Helpers\File;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CacheClear extends BaseCommand
{
    protected $command = "cache:clear";

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Emptying application caches');

        $cacheDirsToClear = array(
            'twig'
        );

        foreach($cacheDirsToClear as $cacheDir) {
            File::rmdir(cachePath($cacheDir), true);
        }
    }
}