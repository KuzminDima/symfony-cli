<?php

namespace Messanger\Transports;

use Messanger\Serializers\JsonSerializer;
use Symfony\Component\Messenger\Bridge\Redis\Transport\Connection;
use Symfony\Component\Messenger\Bridge\Redis\Transport\RedisReceiver;
use Symfony\Component\Messenger\Bridge\Redis\Transport\RedisSender;
use Symfony\Component\Messenger\Transport\Receiver\ReceiverInterface;
use Symfony\Component\Messenger\Transport\Sender\SenderInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

/**
 * Class RedisTransport
 * @package Messanger\Transports
 */
class RedisTransport implements TransportInterface
{
    /**
     * @var Connection $connection
     */
    protected ?Connection $connection = null;

    /**
     * @inheritDoc
     */
    public function getSender(): SenderInterface
    {
        return new RedisSender(
            $this->getConnection(),
            $this->getSerializer()
        );
    }

    /**
     * @inheritDoc
     */
    public function getReceiver(): ReceiverInterface
    {
        return new RedisReceiver(
            $this->getConnection(),
            $this->getSerializer()
        );
    }

    /**
     * @inheritDoc
     */
    public function getSerializer(): SerializerInterface
    {
        return new JsonSerializer;
    }


    /**
     * Returns Redis connection
     *
     * @return Connection
     */
    public function getConnection()
    {
        if ($this->connection === null) {
            $options = [
                'stream' => $_ENV['REDIS_MESSANGER_STREAM_NAME'] ?? 'default',
                'group' => $_ENV['REDIS_MESSANGER_GROUP'] ?? 'default',
                'consumer' => $_ENV['REDIS_MESSANGER_CONSUMER'] ?? 'default',
            ];

            $dsn = $_ENV['REDIS_DSN'] ?? 'localhost:6379';

            $this->connection = Connection::fromDsn($dsn, $options);
        }

        return $this->connection;
    }
}