<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC\Message;

class Prefix
{
    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $hostname;

    /**
     * @var string
     */
    private $servername;

    public function __construct(
        string $nickname = null,
        string $username = null,
        string $hostname = null,
        string $servername = ''
    ) {
        $this->nickname = $nickname ?: '';
        $this->username = $username ?: '';
        $this->hostname = $hostname ?: '';
        $this->servername = $servername ?: '';
    }

    public static function none() : self
    {
        return new static();
    }

    public static function user(string $nickname, string $username = null, string $hostname = null) : self
    {
        return new static($nickname, $username, $hostname);
    }

    public static function server(string $servername) : self
    {
        return new static(null, null, null, $servername);
    }

    public function nickname() : string
    {
        return $this->nickname;
    }

    public function username() : string
    {
        return $this->username;
    }

    public function hostname() : string
    {
        return $this->hostname;
    }

    public function servername() : string
    {
        return $this->servername;
    }

    public function raw() : string
    {
        $raw = '';

        $raw .= empty($this->nickname) ? '' : ":{$this->nickname}";
        $raw .= empty($this->username) ? '' : "!{$this->username}";
        $raw .= empty($this->hostname) ? '' : "@{$this->hostname}";
        $raw .= empty($this->servername) ? '' : ":{$this->servername}";

        return trim($raw);
    }
}
