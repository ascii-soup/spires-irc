<?php
declare(strict_types=1);

use PHPOxford\Spires\IRC\Connection;
use PHPOxford\Spires\IRC\Message;
use PHPOxford\Spires\IRC\User;
use PHPOxford\Spires\IRC\IrcClient;
use PHPOxford\Spires\IRC\Plugins\Greetings;
use PHPOxford\Spires\IRC\Plugins\PingPong;
use PHPOxford\Spires\IRC\Plugins\Time;
use PHPOxford\Spires\IRC\Plugins\Welcome;

require_once 'vendor/autoload.php';

error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting as it comes in. */
ob_implicit_flush();

$client = new IrcClient(
    new Connection(
        '#phpoxford',
//        '##martinsbottesting',
        'irc.freenode.com'
    ),
    new User(
        'spires',
        'spires',
        'Spires ALPHA'
    )
);

$client->connect();


// Ping Pong
$client->addPlugin(new PingPong());

// Welcome users
$client->addPlugin(new Welcome());

// (hi|hello|hey) spires
$client->addPlugin(new Greetings());

// !spires what time is it?
$client->addPlugin(new Time());


$client->run();
