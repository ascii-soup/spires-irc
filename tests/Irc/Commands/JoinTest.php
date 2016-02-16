<?php

namespace PHPOxford\Spires\IRC\Tests\Irc\Commands;

use PHPOxford\Spires\IRC\Commands\Join;
use PHPOxford\Spires\IRC\Message\Command as CommandInterface;

class JoinTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Join
     */
    public function implements_command_interface()
    {
        $command = new Join(['#phpoxford']);

        assertThat($command, is(anInstanceOf(CommandInterface::class)));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Join::command
     */
    public function can_get_the_command_string()
    {
        $command = new Join(['#phpoxford']);

        assertThat($command->command(), is(identicalTo('JOIN')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Join::channels
     */
    public function can_get_channels()
    {
        $command = new Join(['#phpoxford', '#phpoxfordgames']);

        assertThat($command->channels(), is(identicalTo(['#phpoxford', '#phpoxfordgames'])));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Join::keys
     */
    public function can_get_keys()
    {
        $command = new Join(['#phpoxford'], ['firstkey', 'secondkey']);

        assertThat($command->keys(), is(identicalTo(['firstkey', 'secondkey'])));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Join::params
     */
    public function can_get_params_with_one_channel()
    {
        $command = new Join(['#phpoxford']);

        assertThat($command->params(), is(identicalTo('#phpoxford')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Join::params
     */
    public function can_get_params_with_more_channels()
    {
        $command = new Join(['#phpoxford', '#phpoxfordgames']);

        assertThat($command->params(), is(identicalTo('#phpoxford,#phpoxfordgames')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Join::params
     */
    public function can_get_params_with_one_key()
    {
        $command = new Join(['#phpoxford'], ['firstkey']);

        assertThat($command->params(), is(identicalTo('#phpoxford firstkey')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Join::params
     */
    public function can_get_params_with_more_keys()
    {
        $command = new Join(['#phpoxford', '#phpoxfordgames'], ['firstkey', 'secondkey']);

        assertThat($command->params(), is(identicalTo('#phpoxford,#phpoxfordgames firstkey,secondkey')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Join::__toString
     */
    public function can_cast_to_string_with_channels()
    {
        $command = new Join(['#phpoxford', '#phpoxfordgames']);

        assertThat((string) $command, is(identicalTo('JOIN #phpoxford,#phpoxfordgames')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Join::__toString
     */
    public function can_cast_to_string_with_channels_and_keys()
    {
        $command = new Join(['#phpoxford', '#phpoxfordgames'], ['firstkey', 'secondkey']);

        assertThat((string) $command, is(identicalTo('JOIN #phpoxford,#phpoxfordgames firstkey,secondkey')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Commands\Join::fromParams
     */
    public function can_construct_from_params()
    {
        $command = Join::fromParams('#phpoxford,#phpoxfordgames firstkey,secondkey');

        assertThat($command->command(), is(identicalTo('JOIN')));
        assertThat($command->channels(), is(identicalTo(['#phpoxford', '#phpoxfordgames'])));
        assertThat($command->keys(), is(identicalTo(['firstkey', 'secondkey'])));
        assertThat((string) $command, is(identicalTo('JOIN #phpoxford,#phpoxfordgames firstkey,secondkey')));
    }
}
