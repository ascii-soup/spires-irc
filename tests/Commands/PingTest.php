<?php

namespace PHPOxford\Spires\IRC\Tests\Irc\Commands;

use PHPOxford\Spires\IRC\Commands\Ping;
use PHPOxford\Spires\IRC\Message\Command as CommandInterface;

class PingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Ping
     */
    public function implements_command_interface()
    {
        $command = new Ping('wolfe.freenode.net');

        assertThat($command, is(anInstanceOf(CommandInterface::class)));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Ping::command
     */
    public function can_get_the_command_string()
    {
        $command = new Ping('wolfe.freenode.net');

        assertThat($command->command(), is(identicalTo('PING')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Ping::server1
     */
    public function can_get_server1()
    {
        $command = new Ping('wolfe.freenode.net');

        assertThat($command->server1(), is(identicalTo('wolfe.freenode.net')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Ping::server2
     */
    public function can_get_server2()
    {
        $command = new Ping('cable.virginm.net', 'wolfe.freenode.net');

        assertThat($command->server2(), is(identicalTo('wolfe.freenode.net')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Ping::params
     */
    public function can_get_params_with_one_server()
    {
        $command = new Ping('cable.virginm.net');

        assertThat($command->params(), is(identicalTo('cable.virginm.net')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Ping::params
     */
    public function can_get_params_with_two_servers()
    {
        $command = new Ping('cable.virginm.net', 'wolfe.freenode.net');

        assertThat($command->params(), is(identicalTo('cable.virginm.net wolfe.freenode.net')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Ping::__toString
     */
    public function can_cast_to_string_with_server1()
    {
        $command = new Ping('cable.virginm.net');

        assertThat((string) $command, is(identicalTo('PING cable.virginm.net')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Ping::__toString
     */
    public function can_cast_to_string_with_server1_and_server2()
    {
        $command = new Ping('cable.virginm.net', 'wolfe.freenode.net');

        assertThat((string) $command, is(identicalTo('PING cable.virginm.net wolfe.freenode.net')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Ping::fromParams
     */
    public function can_construct_from_params()
    {
        $command = Ping::fromParams('cable.virginm.net wolfe.freenode.net');

        assertThat($command->command(), is(identicalTo('PING')));
        assertThat($command->server1(), is(identicalTo('cable.virginm.net')));
        assertThat($command->server2(), is(identicalTo('wolfe.freenode.net')));
        assertThat((string) $command, is(identicalTo('PING cable.virginm.net wolfe.freenode.net')));
    }
}
