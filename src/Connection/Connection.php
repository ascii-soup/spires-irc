<?php
/**
 * Connection interface
 */

namespace PHPOxford\Spires\IRC\Connection;

interface Connection
{
    /**
     * Reads 2048 bytes
     * @return string
     */
    public function read();

    /**
     * @param string $string
     * @return int
     */
    public function write(string $string);
}
