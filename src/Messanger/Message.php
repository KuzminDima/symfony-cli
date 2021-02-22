<?php

namespace Messanger;

/**
 * Class Message
 * @package Messanger
 */
class Message
{
    /**
     * @var array $content
     */
    protected array $content;

    /**
     * Message constructor.
     * @param array $content
     */
    public function __construct(array $content)
    {
        $this->content = $content;
    }

    /**
     * Returns message content
     *
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }
}