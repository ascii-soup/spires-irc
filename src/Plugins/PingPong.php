<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC\Plugins;

use PHPOxford\Spires\IRC\Commands\Ping;
use PHPOxford\Spires\IRC\Commands\Pong;
use PHPOxford\Spires\IRC\Message;
use PHPOxford\Spires\IRC\Client;
use PHPOxford\Spires\IRC\Plugin;

class PingPong implements Plugin
{
    public function handle(Client $client, Message $message)
    {
        if ($message->command() instanceof Ping) {
            $client->write((string) Pong::fromParams($message->command()->params()));
        }
    }
}
