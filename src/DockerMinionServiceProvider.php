<?php

namespace DominionSolutions\DockerMinion;

use Docker\Docker;
use DominionSolutions\DockerMinion\Commands\DockerMinionCommand;
use DominionSolutions\DockerMinion\Events\DockerChangedEvent;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DockerMinionServiceProvider extends PackageServiceProvider
{
    private $docker;

    private $eventStream;

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('docker-minion')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_docker-minion_table')
            ->hasCommand(DockerMinionCommand::class);
    }

    public function boot()
    {
        parent::boot();
        try {

            $this->docker = Docker::create();

            if (boolval(config('docker-minion.watch-docker'))) {
                $this->eventStream = $this->docker->systemEvents();
                $this->eventStream->onFrame(fn ($event) => event(new DockerChangedEvent($event))); //@phpstan-ignore-line
            }
        } catch (\Exception $e) {
            Log::warning(sprintf('Could not connect to Docker Daemon: %s', $e->getMessage()));
        }
    }
}
