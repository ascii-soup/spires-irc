<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC\Commands;

use PHPOxford\Spires\IRC\Message\Command as CommandInterface;

class Ping extends Base implements CommandInterface
{
    /**
     * @var string
     */
    protected $command = 'PING';

    /**
     * @var string
     */
    private $server1;

    /**
     * @var string
     */
    private $server2;

    public function __construct(string $server1, string $server2 = null)
    {
        $this->server1 = $server1;
        $this->server2 = $server2 ?? '';
    }

    public static function fromParams(string $params) : self
    {
        $servers = explode(' ', $params);

        $server1 = ltrim($servers[0], ':');
        $server2 = ltrim(($servers[1] ?? ''), ':');

        return new static($server1, $server2);
    }

    public function server1() : string
    {
        return $this->server1;
    }

    public function server2()
    {
        return $this->server2;
    }

    public function params() : string
    {
        return trim($this->server1 .  ' ' . $this->server2);
    }
}
