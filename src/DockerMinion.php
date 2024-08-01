<?php

namespace DominionSolutions\DockerMinion;

use Docker\Docker;

class DockerMinion
{
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

    public function startContainerByName(string $name): void
    {
        $containers = $this->listContainers(['all' => true, 'filters' => json_encode(['name' => [$name]])]);
        if (empty($containers)) {
            throw new \Exception("Container not found: $name");
        }
        foreach ($containers as $container) {
            // Added the '/' prefix to match the container name with the leading slash, in case it's left off.
            if (in_array($name, $container->getNames()) || in_array("/$name", $container->getNames())) {
                $this->docker->containerStart($container->getId());
            }
        }
    }

    public function stopContainerbyName(string $name): void
    {
        $containers = $this->listContainers(['all' => true, 'filters' => json_encode(['name' => [$name]])]);
        if (empty($containers)) {
            throw new \Exception("Container not found: $name");
        }
        foreach ($containers as $container) {
            // Added the '/' prefix to match the container name with the leading slash, in case it's left off.
            if (in_array($name, $container->getNames()) || in_array("/$name", $container->getNames())) {
                $this->docker->containerStop($container->getId());
            }
        }
    }

    public function restartContainerByName(string $name): void
    {
        $containers = $this->listContainers(['all' => true, 'filters' => json_encode(['name' => [$name]])]);
        if (empty($containers)) {
            throw new \Exception("Container not found: $name");
        }
        foreach ($containers as $container) {
            // Added the '/' prefix to match the container name with the leading slash, in case it's left off.
            if (in_array($name, $container->getNames()) || in_array("/$name", $container->getNames())) {
                $this->docker->containerRestart($container->getId());
            }
        }
    }
}
