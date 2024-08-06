<?php

namespace DominionSolutions\DockerMinion\Commands;

use Illuminate\Console\Command;

class DockerMinionCommand extends Command
{
    public $signature = 'docker-minion';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
