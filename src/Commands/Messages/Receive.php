<?php

namespace Commands\Messages;

use Messanger\Transports\RedisTransport;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Receive
 * @package Commands\Messages
 */
class Receive extends Command
{
    protected static $defaultName = 'message:receive';

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setDescription('Receive a message from the queue.')
            ->setHelp('This command allows you to receive a message from the queue');
    }

    /**
     * @inheritDoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $receiver = (new RedisTransport)->getReceiver();

            if ($envelopes = $receiver->get()) {
                foreach ($envelopes as $envelope) {
                    $output->writeln('New message: ' . $envelope->getMessage()->getContent()['message']);
                    $receiver->reject($envelope);
                }
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('An error occurred while receiving your message: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}