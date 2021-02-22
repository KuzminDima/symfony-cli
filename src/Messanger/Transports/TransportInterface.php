<?php

namespace Messanger\Transports;

use Symfony\Component\Messenger\Transport\Receiver\ReceiverInterface;
use Symfony\Component\Messenger\Transport\Sender\SenderInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

/**
 * Interface TransportInterface
 * @package Messanger\Transports
 */
interface TransportInterface
{
    /**
     * Returns the sender
     *
     * @return SenderInterface
     */
    public function getSender(): SenderInterface;

    /**
     * Returns the receiver
     *
     * @return ReceiverInterface
     */
    public function getReceiver(): ReceiverInterface;

    /**
     * Returns the serializer
     *
     * @return SerializerInterface
     */
    public function getSerializer(): SerializerInterface;
}
