<?php

namespace DominionSolutions\DockerMinion\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DominionSolutions\DockerMinion\DockerMinion
 */
class DockerMinion extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \DominionSolutions\DockerMinion\DockerMinion::class;
    }
}
