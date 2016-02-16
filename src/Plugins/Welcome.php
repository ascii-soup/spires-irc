<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC\Plugins;

use PHPOxford\Spires\IRC\Commands\Join;
use PHPOxford\Spires\IRC\Message;
use PHPOxford\Spires\IRC\Client;
use PHPOxford\Spires\IRC\Plugin;

class Welcome implements Plugin
{
    public function handle(Client $client, Message $message)
    {
        if ($message->command() instanceof Join && $message->prefix()->nickname() != $client->user()->nickname()) {
            $client->channelMessage("Welcome {$message->prefix()->nickname()} :D");
        }
    }
}
