<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC\Commands;

use PHPOxford\Spires\IRC\Message\Command as CommandInterface;

abstract class Base implements CommandInterface
{
    /**
     * @var string
     */
    protected $command;

    public function command() : string
    {
        return $this->command;
    }

    public function __toString() : string
    {
        return trim($this->command() . ' ' . $this->params());
    }
}
