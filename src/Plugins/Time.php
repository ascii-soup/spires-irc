<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC\Plugins;

use PHPOxford\Spires\IRC\Commands\Privmsg;
use PHPOxford\Spires\IRC\Message;
use PHPOxford\Spires\IRC\IrcClient;
use PHPOxford\Spires\IRC\Plugin;

class Time implements Plugin
{
    public function handle(IrcClient $client, Message $message)
    {
        if ($message->command() instanceof Privmsg) {
            /** @var Privmsg $command */
            $command = $message->command();

            if ($command->hasTarget($client->channel())) {
                if (preg_match('/^!?spires,? what time is it\??/i', $command->text())) {
                    $time = date('H:i');
                    $client->channelMessage(" \\o/  /       {$time}       \\");
                    $client->channelMessage("  |   \\ It's hammer time! /");
                    $client->channelMessage(" / \\");
                }
            }
        }
    }
}
