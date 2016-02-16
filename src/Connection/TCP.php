<?php
/**
 * Class to encapsulate the TCP connection to the server
 */

namespace PHPOxford\Spires\IRC\Connection;

use PHPOxford\Spires\IRC\Connection\Exceptions\ConnectionException;
use PHPOxford\Spires\IRC\Connection\Exceptions\ReadException;
use PHPOxford\Spires\IRC\Connection\Exceptions\WriteException;

class TCP implements Connection
{
    /**
     * @var Details
     */
    private $details;

    /**
     * @var resource
     */
    private $socket;

    /**
     * TCP constructor.
     * @param Details $details
     * @throws ConnectionException
     */
    public function __construct(Details $details)
    {
        $this->details = $details;
        $this->connect();
    }

    /**
     * Creates a connection to the remote host
     * @throws ConnectionException
     */
    private function connect()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        $isConnected = socket_connect(
            $this->socket,
            $this->details->server(),
            $this->details->port()
        );

        if (!$isConnected) {
            throw new ConnectionException(socket_last_error($this->socket));
        }
    }

    /**
     * Reads 2048 bytes
     * @return string
     * @throws ReadException
     */
    public function read()
    {
        $data = socket_read($this->socket, 2048, PHP_NORMAL_READ);

        if ($data === false) {
            throw new ReadException(socket_last_error($this->socket));
        }

        return $data;
    }

    /**
     * @param string $string
     * @return int
     * @throws WriteException
     */
    public function write(string $string)
    {
        $bytesWritten = socket_write($this->socket, $string);

        if ($bytesWritten === false) {
            throw new WriteException(socket_last_error($this->socket));
        }

        return $bytesWritten;
    }
}
