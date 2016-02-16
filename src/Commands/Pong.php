<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC\Commands;

use PHPOxford\Spires\IRC\Message\Command as CommandInterface;

class Pong extends Base implements CommandInterface
{
    /**
     * @var string
     */
    protected $command = 'PONG';

    /**
     * @var string
     */
    private $server;

    /**
     * @var string
     */
    private $server2;

    public function __construct(string $server, string $server2 = null)
    {
        $this->server = $server;
        $this->server2 = $server2 ?? '';
    }

    public static function fromParams(string $params) : self
    {
        $servers = explode(' ', $params);

        $server = ltrim($servers[0], ':');
        $server2 = ltrim(($servers[1] ?? ''), ':');

        return new static($server, $server2);
    }

    public function server() : string
    {
        return $this->server;
    }

    public function server2()
    {
        return $this->server2;
    }

    public function params() : string
    {
        return trim($this->server .  ' ' . $this->server2);
    }
}
