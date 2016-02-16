<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC\Plugins;

use PHPOxford\Spires\IRC\Commands\Privmsg;
use PHPOxford\Spires\IRC\Message;
use PHPOxford\Spires\IRC\IrcClient;
use PHPOxford\Spires\IRC\Plugin;

class Greetings implements Plugin
{
    public function handle(IrcClient $client, Message $message)
    {
        if ($message->command() instanceof Privmsg) {
            /** @var Privmsg $command */
            $command = $message->command();

            if ($command->hasTarget($client->channel())) {
                if (preg_match('/^(hi|hello|hey) spires$/i', $command->text())) {
                    $client->channelMessage("Hello {$message->prefix()->nickname()}");
                }
            }
        }
    }
}
