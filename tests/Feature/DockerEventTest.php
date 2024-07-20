<?php

use Docker\Docker;
use Docker\API\Model\ContainersCreatePostBody;
use Illuminate\Support\Str;

it('can spin up a docker container', function () {
    $docker = Docker::create();
    $container = $docker->containerCreate(new ContainersCreatePostBody([
        'image' => 'hello-world:latest',
        'attachStdout' => true,
        'attachStderr' => true,
    ]));
    $docker->containerStart($container->getId());
    $docker->containerAttach($container->getId());
    $docker->containerWait($container->getId());
    $response = $docker->containerLogs($container->getId(),  [
        'stdout' => true,
        'stderr' => true,
    ], Docker::FETCH_RESPONSE);
    $output = $response->getBody()->getContents();
    $docker->containerDelete($container->getId());
    expect($response->getStatusCode())->toBe(200);
    expect($output)->toContain('Hello from Docker!');
});
