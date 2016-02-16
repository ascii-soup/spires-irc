<?php

namespace PHPOxford\Spires\IRC\Tests\Irc;

use PHPOxford\Spires\IRC\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \PHPOxford\Spires\IRC\Parser::parse
     * @dataProvider dataMessages
     */
    public function can_parse_valid_messages_to_an_array_of_data($message, $expected)
    {
        $parser = new Parser();

        $parse = $parser->parse($message);

        assertThat($parse, is(identicalTo($expected)));
    }

    public function dataMessages()
    {
        return [
            'Notice' => [
                ":sendak.freenode.net NOTICE * :*** Found your hostname\r\n",
                [
                    'prefix' => ':sendak.freenode.net',
                    'nickname' => '',
                    'username' => '',
                    'hostname' => '',
                    'servername' => 'sendak.freenode.net',
                    'command' => 'NOTICE',
                    'params' => '* :*** Found your hostname',
                ]
            ],
            'Command with no params' => [
                "QUIT\r\n",
                [
                    'prefix' => '',
                    'nickname' => '',
                    'username' => '',
                    'hostname' => '',
                    'servername' => '',
                    'command' => 'QUIT',
                    'params' => '',
                ]
            ],
            'Command with only one param' => [
                "NICK dilling\r\n",
                [
                    'prefix' => '',
                    'nickname' => '',
                    'username' => '',
                    'hostname' => '',
                    'servername' => '',
                    'command' => 'NICK',
                    'params' => 'dilling',
                ]
            ],
            'Command with multiple params' => [
                "USER guest 0 * :Ronnie Reagan\r\n",
                [
                    'prefix' => '',
                    'nickname' => '',
                    'username' => '',
                    'hostname' => '',
                    'servername' => '',
                    'command' => 'USER',
                    'params' => 'guest 0 * :Ronnie Reagan',
                ]
            ],
            'Only first part of the prefix present, then it is the servername' => [
                ":asimov.freenode.net QUIT\r\n",
                [
                    'prefix' => ':asimov.freenode.net',
                    'nickname' => '',
                    'username' => '',
                    'hostname' => '',
                    'servername' => 'asimov.freenode.net',
                    'command' => 'QUIT',
                    'params' => '',
                ]
            ],
            'First two parts of the prefix present, then it is the nickname and username' => [
                ":dilling!~dilling JOIN #phpoxford\r\n",
                [
                    'prefix' => ':dilling!~dilling',
                    'nickname' => 'dilling',
                    'username' => '~dilling',
                    'hostname' => '',
                    'servername' => '',
                    'command' => 'JOIN',
                    'params' => '#phpoxford',
                ]
            ],
            'All three parts of the prefix present, then it is the nickname, username and hostname' => [
                ":dilling!~dilling@cable.virginm.net NICK martindilling\r\n",
                [
                    'prefix' => ':dilling!~dilling@cable.virginm.net',
                    'nickname' => 'dilling',
                    'username' => '~dilling',
                    'hostname' => 'cable.virginm.net',
                    'servername' => '',
                    'command' => 'NICK',
                    'params' => 'martindilling',
                ]
            ],
            'The hostname can be a IPv4 address' => [
                ":dilling!~dilling@168.12.8.204 NICK martindilling\r\n",
                [
                    'prefix' => ':dilling!~dilling@168.12.8.204',
                    'nickname' => 'dilling',
                    'username' => '~dilling',
                    'hostname' => '168.12.8.204',
                    'servername' => '',
                    'command' => 'NICK',
                    'params' => 'martindilling',
                ]
            ],
            'The hostname can be a IPv6 address' => [
                ":dilling!~dilling@2001:0db8:0a0b:12f0:0000:0000:0000:0001 NICK martindilling\r\n",
                [
                    'prefix' => ':dilling!~dilling@2001:0db8:0a0b:12f0:0000:0000:0000:0001',
                    'nickname' => 'dilling',
                    'username' => '~dilling',
                    'hostname' => '2001:0db8:0a0b:12f0:0000:0000:0000:0001',
                    'servername' => '',
                    'command' => 'NICK',
                    'params' => 'martindilling',
                ]
            ],
            'Recognises really long messages' => [
                ":dilling!~dilling@cable.virginm.net PRIVMSG ascii-soup :This is a really really long message! " .
                "It is longer than most message, so I really hope this works as it should\r\n",
                [
                    'prefix' => ':dilling!~dilling@cable.virginm.net',
                    'nickname' => 'dilling',
                    'username' => '~dilling',
                    'hostname' => 'cable.virginm.net',
                    'servername' => '',
                    'command' => 'PRIVMSG',
                    'params' => 'ascii-soup :This is a really really long message! ' .
                        'It is longer than most message, so I really hope this works as it should',
                ]
            ],
            'Safety: PING command' => [
                "PING :wolfe.freenode.net\r\n",
                [
                    'prefix' => '',
                    'nickname' => '',
                    'username' => '',
                    'hostname' => '',
                    'servername' => '',
                    'command' => 'PING',
                    'params' => ':wolfe.freenode.net',
                ]
            ],
            'Safety: NICK command' => [
                ":dilling!~dilling@cable.virginm.net NICK :imchanged\r\n",
                [
                    'prefix' => ':dilling!~dilling@cable.virginm.net',
                    'nickname' => 'dilling',
                    'username' => '~dilling',
                    'hostname' => 'cable.virginm.net',
                    'servername' => '',
                    'command' => 'NICK',
                    'params' => ':imchanged',
                ]
            ],
            'Safety: JOIN command' => [
                ":dilling!~dilling@cable.virginm.net JOIN #phpoxford\r\n",
                [
                    'prefix' => ':dilling!~dilling@cable.virginm.net',
                    'nickname' => 'dilling',
                    'username' => '~dilling',
                    'hostname' => 'cable.virginm.net',
                    'servername' => '',
                    'command' => 'JOIN',
                    'params' => '#phpoxford',
                ]
            ],
            'Safety: PART command' => [
                ":dilling!~dilling@cable.virginm.net PART #phpoxford :Leaving\r\n",
                [
                    'prefix' => ':dilling!~dilling@cable.virginm.net',
                    'nickname' => 'dilling',
                    'username' => '~dilling',
                    'hostname' => 'cable.virginm.net',
                    'servername' => '',
                    'command' => 'PART',
                    'params' => '#phpoxford :Leaving',
                ]
            ],
            'Safety: QUIT command' => [
                ":dilling!~dilling@cable.virginm.net QUIT :Quit: I'm outta here\r\n",
                [
                    'prefix' => ':dilling!~dilling@cable.virginm.net',
                    'nickname' => 'dilling',
                    'username' => '~dilling',
                    'hostname' => 'cable.virginm.net',
                    'servername' => '',
                    'command' => 'QUIT',
                    'params' => ':Quit: I\'m outta here',
                ]
            ],
        ];
    }
}
