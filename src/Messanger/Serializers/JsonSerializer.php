<?php

namespace Messanger\Serializers;

use Messanger\Message;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * Class JsonSerializer
 * @package Messanger\Serializers
 */
class JsonSerializer implements SerializerInterface
{
    protected JsonEncoder $encoder;

    /**
     * JsonSerializer constructor.
     */
    public function __construct()
    {
        $this->encoder = new JsonEncoder();
    }

    /**
     * @inheritDoc
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        $message = new Message(
            $this->encoder->decode($encodedEnvelope['body'], JsonEncoder::FORMAT)
        );

        return new Envelope($message);
    }

    /**
     * @inheritDoc
     */
    public function encode(Envelope $envelope): array
    {
        /** @var Message $message */
        $message = $envelope->getMessage();

        return [
            'body' => $this->encoder->encode($message->getContent(), JsonEncoder::FORMAT),
            'headers' => [],
        ];
    }
}
