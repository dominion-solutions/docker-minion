<?php
namespace DominionSolutions\DockerMinion;

use Docker\Docker;

class DockerMinion {
    private Docker $docker;

    /**
     * Return the underlying Docker instance
     */
    public function getDocker(): Docker
    {
        if (!isset($this->docker)) {
            $this->docker = Docker::create();
        }
        return $this->docker;
    }

    public function listContainers(array $filter = ['all' => true]): array
    {
        return $this->getDocker()->containerList($filter);
    }

    public function listImages(): array
    {
        return $this->docker->imageList();
    }
}
