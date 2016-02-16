<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC;

use PHPOxford\Spires\IRC\Message\Prefix;
use PHPOxford\Spires\IRC\Message\Command;

class Message
{
    /**
     * @var Prefix
     */
    private $prefix;

    /**
     * @var Command
     */
    private $command;

    public function __construct(Prefix $prefix, Command $command)
    {
        $this->prefix = $prefix;
        $this->command = $command;
    }

    public function prefix() : Prefix
    {
        return $this->prefix;
    }

    public function command() : Command
    {
        return $this->command;
    }

    public function raw()
    {
        return trim($this->prefix->raw() . ' ' . (string) $this->command);
    }
}
