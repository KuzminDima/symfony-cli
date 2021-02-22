<?php

namespace Commands\Messages;

use Messanger\Message;
use Messanger\Serializers\JsonSerializer;
use Messanger\Transports\RedisTransport;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Messenger\Bridge\Redis\Transport\RedisReceiver;
use Symfony\Component\Messenger\Bridge\Redis\Transport\RedisSender;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Symfony\Component\Messenger\Bridge\Redis\Transport\Connection;

/**
 * Class Push
 * @package Commands\Messages
 */
class Send extends Command
{
    protected static $defaultName = 'message:send';

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setDescription('Send a message on the queue.')
            ->setHelp('This command allows you to send a message in the queue')
        ;
    }

    /**
     * @inheritDoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question("Enter the message you want to save to the queue:\n");

        $message = $helper->ask($input, $output, $question);

        try {
            $sender = (new RedisTransport)->getSender();
            $sender->send(
                new Envelope(
                    new Message(['message' => $message])
                )
            );

            $output->writeln('Message saved successfully');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('An error occurred while sending your message: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}