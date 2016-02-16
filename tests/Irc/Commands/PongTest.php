<?php

namespace PHPOxford\Spires\IRC\Tests\Irc\Commands;

use PHPOxford\Spires\IRC\Commands\Pong;
use PHPOxford\Spires\IRC\Message\Command as CommandInterface;

class PongTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Pong
     */
    public function implements_command_interface()
    {
        $command = new Pong('wolfe.freenode.net');

        assertThat($command, is(anInstanceOf(CommandInterface::class)));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Pong::command
     */
    public function can_get_the_command_string()
    {
        $command = new Pong('wolfe.freenode.net');

        assertThat($command->command(), is(identicalTo('PONG')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Pong::server
     */
    public function can_get_server()
    {
        $command = new Pong('wolfe.freenode.net');

        assertThat($command->server(), is(identicalTo('wolfe.freenode.net')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Pong::server2
     */
    public function can_get_server2()
    {
        $command = new Pong('cable.virginm.net', 'wolfe.freenode.net');

        assertThat($command->server2(), is(identicalTo('wolfe.freenode.net')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Pong::params
     */
    public function can_get_params_with_one_server()
    {
        $command = new Pong('cable.virginm.net');

        assertThat($command->params(), is(identicalTo('cable.virginm.net')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Pong::params
     */
    public function can_get_params_with_two_servers()
    {
        $command = new Pong('cable.virginm.net', 'wolfe.freenode.net');

        assertThat($command->params(), is(identicalTo('cable.virginm.net wolfe.freenode.net')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Pong::__toString
     */
    public function can_cast_to_string_with_server1()
    {
        $command = new Pong('cable.virginm.net');

        assertThat((string) $command, is(identicalTo('PONG cable.virginm.net')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Pong::__toString
     */
    public function can_cast_to_string_with_server1_and_server2()
    {
        $command = new Pong('cable.virginm.net', 'wolfe.freenode.net');

        assertThat((string) $command, is(identicalTo('PONG cable.virginm.net wolfe.freenode.net')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Pong::fromParams
     */
    public function can_construct_from_params()
    {
        $command = Pong::fromParams('cable.virginm.net wolfe.freenode.net');

        assertThat($command->command(), is(identicalTo('PONG')));
        assertThat($command->server(), is(identicalTo('cable.virginm.net')));
        assertThat($command->server2(), is(identicalTo('wolfe.freenode.net')));
        assertThat((string) $command, is(identicalTo('PONG cable.virginm.net wolfe.freenode.net')));
    }
}
