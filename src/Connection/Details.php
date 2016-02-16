<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC\Connection;

class Details
{
    /**
     * @var string
     */
    private $channel;

    /**
     * @var string
     */
    private $server;

    /**
     * @var int
     */
    private $port;

    public function __construct(string $server, int $port = 6667)
    {
        $this->server = $server;
        $this->port = $port;
    }

    public function server() : string
    {
        return $this->server;
    }

    public function port() : int
    {
        return $this->port;
    }
}
