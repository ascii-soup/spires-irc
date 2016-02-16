<?php

namespace PHPOxford\Spires\IRC\Tests\Irc\Message;

use PHPOxford\Spires\IRC\Message\Prefix;

class PrefixTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message\Prefix::nickname
     */
    public function can_get_nickname()
    {
        $prefix = new Prefix('nickname');

        assertThat($prefix->nickname(), is(identicalTo('nickname')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message\Prefix::username
     */
    public function can_get_username()
    {
        $prefix = new Prefix(null, 'username');

        assertThat($prefix->username(), is(identicalTo('username')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message\Prefix::hostname
     */
    public function can_get_hostname()
    {
        $prefix = new Prefix(null, null, 'hostname.com');

        assertThat($prefix->hostname(), is(identicalTo('hostname.com')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message\Prefix::servername
     */
    public function can_get_servername()
    {
        $prefix = new Prefix(null, null, null, 'servername.com');

        assertThat($prefix->servername(), is(identicalTo('servername.com')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message\Prefix::none
     */
    public function factory_method_for_empty_prefix()
    {
        $prefix = Prefix::none();

        assertThat($prefix->nickname(), is(emptyString()));
        assertThat($prefix->username(), is(emptyString()));
        assertThat($prefix->hostname(), is(emptyString()));
        assertThat($prefix->servername(), is(emptyString()));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message\Prefix::user
     */
    public function factory_method_for_user_prefix()
    {
        $prefix = Prefix::user('nickname', 'username', 'hostname.com');

        assertThat($prefix->nickname(), is(identicalTo('nickname')));
        assertThat($prefix->username(), is(identicalTo('username')));
        assertThat($prefix->hostname(), is(identicalTo('hostname.com')));
        assertThat($prefix->servername(), is(emptyString()));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message\Prefix::server
     */
    public function factory_method_for_server_prefix()
    {
        $prefix = Prefix::server('servername.com');

        assertThat($prefix->nickname(), is(emptyString()));
        assertThat($prefix->username(), is(emptyString()));
        assertThat($prefix->hostname(), is(emptyString()));
        assertThat($prefix->servername(), is(identicalTo('servername.com')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message\Prefix::raw
     */
    public function can_get_the_raw_prefix_string_for_empty_prefix()
    {
        $prefix = Prefix::none();

        assertThat($prefix->raw(), is(emptyString()));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message\Prefix::raw
     */
    public function can_get_the_raw_prefix_string_for_user_prefix_with_all_set()
    {
        $prefix = Prefix::user('nickname', 'username', 'hostname.com');

        assertThat($prefix->raw(), is(identicalTo(':nickname!username@hostname.com')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message\Prefix::raw
     */
    public function can_get_the_raw_prefix_string_for_user_prefix_with_nick_and_user_set()
    {
        $prefix = Prefix::user('nickname', 'username', null);

        assertThat($prefix->raw(), is(identicalTo(':nickname!username')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message\Prefix::raw
     */
    public function can_get_the_raw_prefix_string_for_user_prefix_with_nick_and_host_set()
    {
        $prefix = Prefix::user('nickname', null, 'hostname.com');

        assertThat($prefix->raw(), is(identicalTo(':nickname@hostname.com')));
    }

    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Message\Prefix::raw
     */
    public function can_get_the_raw_prefix_string_for_server_prefix()
    {
        $prefix = Prefix::server('servername.com');

        assertThat($prefix->raw(), is(identicalTo(':servername.com')));
    }
}
