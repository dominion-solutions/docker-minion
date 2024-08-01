<?php

use Docker\Stream\EventStream;
use DominionSolutions\DockerMinion\Events\DockerChangedEvent;
use Nyholm\Psr7\Stream;
use Symfony\Component\Serializer\SerializerInterface;
use Illuminate\Support\Facades\Event;

dataset('jsonStreamDataProvider', [
    [
        '{}{"abc":"def"}',
        ['{}', '{"abc":"def"}'],
    ],
    [
        '{"test": "abc\"\""}',
        ['{"test":"abc\"\""}'],
    ],
    [
        '{"test": "abc\"{{-}"}',
        ['{"test":"abc\"{{-}"}'],
    ],
]);

test('it can create an event', function (string $jsonStream, array $jsonParts) {
    Event::fake([
        DockerChangedEvent::class,
    ]);

    $stream = Stream::create($jsonStream);
    $stream->rewind();

    $serializer = Mockery::mock(SerializerInterface::class);
    $serializer->shouldReceive('deserialize')
        ->andReturn($jsonParts);

    $eventStream = new EventStream($stream, $serializer);
    $eventStream->onFrame(function ($frame) {
        event(new DockerChangedEvent($frame));
    });

    $eventStream->wait();

    Event::assertDispatched(DockerChangedEvent::class);
})->with('jsonStreamDataProvider');
