<?php

use DominionSolutions\DockerMinion\DockerMinion;

dataset('containerConfig', [
    ([
        new Docker\API\Model\ContainerSummary([
            'initialized' => [
                'id' => true,
                'names' => true,
                'image' => true,
                'imageID' => true,
                'command' => true,
                'created' => true,
                'ports' => true,
                'sizeRw' => true,
                'sizeRootFs' => true,
                'labels' => true,
                'state' => true,
                'status' => true,
                'hostConfig' => true,
                'networkSettings' => true,
                'mounts' => true,
            ],
            'id' => 'sha256:3029aa4d72ce2474669a673ae6347762cc901eab8782a11790ab731d7707c7fc',
            'names' => ['/infallible_banach'],
            'image' => 'hello-world:latest',
            'imageID' => 'sha256:d2c94e258dcb3c5ac2798d32e1249e42ef01cba4841c2234249495f87264ac5a',
            'command' => '/hello',
            'created' => 1720660940,
            'ports' => [],
            'sizeRw' => null,
            'sizeRootFs' => null,
            'state' => 'created',
            'status' => 'Created',
            'hostConfig' => new Docker\API\Model\ContainerSummaryHostConfig([
                'networkMode' => 'default',
            ]),
            'networkSettings' => new Docker\API\Model\NetworkSettings([
                'networks' => [
                    'bridge' => new Docker\API\Model\EndpointSettings([
                        'iPAMConfig' => null,
                        'links' => null,
                        'aliases' => null,
                        'networkID' => '',
                        'endpointID' => '',
                        'gateway' => '',
                        'iPAddress' => '',
                        'iPPrefixLen' => 0,
                        'iPv6Gateway' => '',
                        'globalIPv6Address' => '',
                        'globalIPv6PrefixLen' => 0,
                        'macAddress' => '',
                        'driverOpts' => null,
                    ]),
                ],
            ]),
        ], ArrayObject::ARRAY_AS_PROPS),
    ]),
]);

it('can list containers', function ($containerConfig) {
    $minion = Mockery::mock(DockerMinion::class)->makePartial();
    $minion->shouldReceive('listContainers')->andReturn([$containerConfig]);
    $containers = $minion->listContainers();
    expect($containers)->toBeArray()->toHaveCount(1);
    expect($containers[0])->toBeObject();
    expect($containers[0]['id'])->toBe('sha256:3029aa4d72ce2474669a673ae6347762cc901eab8782a11790ab731d7707c7fc');
})->with('containerConfig');

it('can get container statuses', function () {
    $minion = Mockery::mock(DockerMinion::class)->makePartial();
    $minion->shouldReceive('getContainerStatus')->andReturn('running');
    $status = $minion->getContainerStatus('fakeContainerId');
    expect($status)->toBe('running');
})->with('containerConfig');
