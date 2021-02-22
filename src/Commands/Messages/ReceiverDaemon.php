<?php

namespace Commands\Messages;

use Messanger\Message;
use Messanger\Transports\RedisTransport;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Handler\HandlerDescriptor;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Worker;

/**
 * Class ReceiverDaemon
 * @package Commands\Messages
 */
class ReceiverDaemon extends Command
{
    protected static $defaultName = 'message:receiver-daemon:start';

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setDescription('Starts a daemon to monitor the message queue.');
    }

    /**
     * @inheritDoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $locator = new HandlersLocator([
            Message::class => [
                new HandlerDescriptor(
                    function (Message $message) use ($output) {
                        $output->writeln('New Message: ' . $message->getContent()['message']);
                    }
                )
            ]
        ]);

        $bus = new MessageBus([
            new HandleMessageMiddleware($locator)
        ]);

        $receivers = [
            (new RedisTransport)->getReceiver(),
        ];

        $worker = new Worker($receivers, $bus);

        $worker->run();
    }
}