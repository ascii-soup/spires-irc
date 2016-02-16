<?php

namespace PHPOxford\Spires\IRC\Tests\Irc;

use PHPOxford\Spires\IRC\Message;
use PHPOxford\Spires\IRC\Message\Prefix;
use PHPOxford\Spires\IRC\Commands\Command;
use PHPOxford\Spires\IRC\Message\Command as CommandInterface;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message::prefix
     */
    public function holds_prefix_instance()
    {
        $message = new Message(
            Prefix::none(),
            new Command('PING', 'blah.freenode.com')
        );

        assertThat($message->prefix(), is(anInstanceOf(Prefix::class)));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message::command
     */
    public function holds_command_instance()
    {
        $message = new Message(
            Prefix::none(),
            new Command('PING', 'blah.freenode.com')
        );

        assertThat($message->command(), is(anInstanceOf(CommandInterface::class)));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message::raw
     */
    public function can_get_the_raw_message_without_prefix()
    {
        $message = new Message(
            Prefix::none(),
            new Command('PING', 'blah.freenode.com')
        );

        assertThat($message->raw(), is(identicalTo('PING blah.freenode.com')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message::raw
     */
    public function can_get_the_raw_message_with_prefix()
    {
        $message = new Message(
            Prefix::user('nickname', 'username', 'hostname.com'),
            new Command('PING', 'blah.freenode.com')
        );

        assertThat($message->raw(), is(identicalTo(':nickname!username@hostname.com PING blah.freenode.com')));
    }
}
