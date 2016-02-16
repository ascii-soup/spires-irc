<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC;

use PHPOxford\Spires\IRC\Commands\Command;
use PHPOxford\Spires\IRC\Commands\Join;
use PHPOxford\Spires\IRC\Commands\Ping;
use PHPOxford\Spires\IRC\Commands\Privmsg;
use PHPOxford\Spires\IRC\Connection;
use PHPOxford\Spires\IRC\Message;
use PHPOxford\Spires\IRC\Message\Prefix;
use PHPOxford\Spires\IRC\Parser;
use PHPOxford\Spires\IRC\User;

class IrcClient
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     */
    private $actions = [];

    /**
     * @var Plugin[]
     */
    private $plugins = [];

    private $socket;

    public function __construct(Connection $connection, User $user)
    {
        $this->connection = $connection;
        $this->user = $user;
    }

    public function connection() : Connection
    {
        return $this->connection;
    }

    public function channel() : string
    {
        return $this->connection()->channel();
    }

    public function user() : User
    {
        return $this->user;
    }

    public function socket()
    {
        return $this->socket;
    }

    public function connect()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        $isConnected = socket_connect(
            $this->socket,
            $this->connection()->server(),
            $this->connection()->port()
        );

        $this->write("NICK {$this->user()->nickname()}\r\n");
        $this->write("USER {$this->user()->username()} {$this->user()->usermode()} * :{$this->user()->realname()}\r\n");
        $this->write("JOIN {$this->connection()->channel()}\r\n");
    }

    public function addAction($callback)
    {
        $this->actions[] = $callback;
    }

    public function addPlugin(Plugin $plugin)
    {
        $this->plugins[] = $plugin;
    }

    public function read()
    {
        return socket_read($this->socket, 2048, PHP_NORMAL_READ);
    }

    public function write(string $response)
    {
        $response = trim($response);

        $this->debug("[ write ]: " . $response . "\n");
        return socket_write($this->socket, $response . "\r\n");
    }

    public function debug(string $string)
    {
        fwrite(STDOUT, $string);
    }

    public function channelMessage(string $message)
    {
        $this->write((string) new Privmsg([$this->channel()], $message));
    }

    public function run()
    {
        $parser = new Parser();

        while ($raw = $this->read()) {

            if (!$raw = trim($raw)) {
                continue;
            }
            $this->debug("\n\n[ read  ]: " . $raw);
            $message = $parser->parse($raw . "\r\n");

            $prefix = new Prefix(
                $message['nickname'],
                $message['username'],
                $message['hostname'],
                $message['servername']
            );

            switch ($message['command']) {
                case 'PING':
                    $message = new Message(
                        $prefix,
                        Ping::fromParams($message['params'])
                    );
                    break;

                case 'JOIN':
                    $message = new Message(
                        $prefix,
                        Join::fromParams($message['params'])
                    );
                    break;

                case 'PRIVMSG':
                    $message = new Message(
                        $prefix,
                        Privmsg::fromParams($message['params'])
                    );
                    break;

                default:
                    $message = new Message(
                        $prefix,
                        new Command($message['command'], $message['params'])
                    );
            }

            ob_start();
                var_dump($message);
                $messageDump = ob_get_contents();
            ob_end_clean();
            $this->debug("\n" . $messageDump);


            foreach ($this->plugins as $plugin) {
                $plugin->handle($this, $message);
            }

            foreach ($this->actions as $action) {
                $action($this, $message);
            }
        }
    }
}
