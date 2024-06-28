<?php
use Nyholm\Psr7\Stream;
use Docker\Stream\EventStream;
use Symfony\Component\Serializer\SerializerInterface;
use DominionSolutions\DockerMinion\Events\DockerChangedEvent;

test('it can create an event', function () {
    Event::fake([
        DockerChangedEvent::class
    ]);

    $jsonStream = <<<JSON
    [
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
    ]
    JSON;

    $stream = Stream::create($jsonStream);
    $stream->rewind();

    $serializer = Mockery::mock(SerializerInterface::class);
    $serializer->shouldReceive('deserialize')->andReturn($jsonStream);

    $eventStream = new EventStream($stream, $serializer);
    $eventStream->onFrame(function ($event) {
        event(new DockerChangedEvent($event));
    });

    $eventStream->wait();

    Event::assertDispatched(DockerChangedEvent::class);
});
