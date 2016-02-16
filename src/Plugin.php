<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC;

use PHPOxford\Spires\IRC\Message;

interface Plugin
{
    public function handle(IrcClient $client, Message $message);
}
