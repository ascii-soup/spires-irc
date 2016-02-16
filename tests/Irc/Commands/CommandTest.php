<?php

namespace PHPOxford\Spires\IRC\Tests\Irc\Commands;

use PHPOxford\Spires\IRC\Commands\Command;
use PHPOxford\Spires\IRC\Message\Command as CommandInterface;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Command::command
     */
    public function implements_command_interface()
    {
        $command = new Command('PING', 'blah.freenode.com');

        assertThat($command, is(anInstanceOf(CommandInterface::class)));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Command::command
     */
    public function can_get_the_command_string()
    {
        $command = new Command('PING', 'blah.freenode.com');

        assertThat($command->command(), is(identicalTo('PING')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Command::params
     */
    public function can_get_the_params_string()
    {
        $command = new Command('USER', 'guest 0 * :Ronnie Reagan');

        assertThat($command->params(), is(identicalTo('guest 0 * :Ronnie Reagan')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Command::__toString
     */
    public function can_cast_to_string_without_params()
    {
        $command = new Command('QUIT');

        assertThat((string) $command, is(identicalTo('QUIT')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Command::__toString
     */
    public function can_cast_to_string_with_params()
    {
        $command = new Command('USER', 'guest 0 * :Ronnie Reagan');

        assertThat((string) $command, is(identicalTo('USER guest 0 * :Ronnie Reagan')));
    }
}
