## Symfony messenger resending middleware
Resending middleware to keep dispatching a message in the Symfony MessageHandler until it has been dispatched 
a number of times

### Usage

Add the middleware to the configuration file of your Symfony project `(messenger.yaml)`
```framework:
    messenger:
        # Uncomment this (and the failed transport below) to send failed messages to this transport for later handling.
        # failure_transport: failed
        buses:
            messenger.bus.default:
                middleware:
                    - 'App\Messenger\Middleware\ResendingMiddleware
```
    
Add the LoopCount stamp the first time you dispatch a message

    $this->bus->dispatch(new TestMessage("Test"),[
        new LoopCount(0)
    ]);

In the ResendingMiddleware class change the resending threshold constant to how many times you want to resend a message

``  const RESEND_THRESHOLD = 10; ``  

