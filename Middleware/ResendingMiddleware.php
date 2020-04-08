<?php

namespace App\Messenger\Middleware;

use App\Message\TestMessage;
use App\Stamps\LoopCount;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

class ResendingMiddleware implements MiddlewareInterface
{

    private $bus;
    const RESEND_THRESHOLD = 10;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {

        $envelope = $stack->next()->handle($envelope, $stack);

        if (null !== $stamp = $envelope->last(LoopCount::class)) {
            $count = $stamp->getCount();
        } else {
            return $envelope;
        }

        // Stop re-dispatching
        if ($count > self::RESEND_THRESHOLD) {
            return $envelope;
        }

        $this->bus->dispatch(new TestMessage("Test"),[
            new DelayStamp(5000),
            new LoopCount($count + 1)
        ]);

        return $envelope;
    }

}
