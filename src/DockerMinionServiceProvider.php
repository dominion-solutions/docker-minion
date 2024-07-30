<?php

namespace DominionSolutions\DockerMinion;

use Docker\Docker;
use DominionSolutions\DockerMinion\Commands\DockerMinionCommand;
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
        if (!$this->app->runningUnitTests()) {
            $this->docker = Docker::create();

            if (config('docker-minion.watch-docker')) {
                $this->eventStream = $this->docker->systemEvents();
                $this->eventStream->onFrame(function ($event) {
                    event(new DockerChangedEvent($event));
                });
            }
        }
    }
}
