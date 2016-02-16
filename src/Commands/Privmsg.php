<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC\Commands;

use PHPOxford\Spires\IRC\Message\Command as CommandInterface;

class Privmsg extends Base implements CommandInterface
{
    /**
     * @var string
     */
    protected $command = 'PRIVMSG';

    /**
     * @var array
     */
    private $targets;

    /**
     * @var string
     */
    private $text;

    public function __construct(array $targets, string $text)
    {
        $this->targets = $targets;
        $this->text = $text;
    }

    public static function fromParams(string $params) : self
    {
        list($targets, $text) = explode(' ', $params, 2);

        $targets = explode(',', $targets);
        $text = ltrim($text, ':');

        return new static($targets, $text);
    }

    public function targets() : array
    {
        return $this->targets;
    }

    public function text()
    {
        return $this->text;
    }

    public function params() : string
    {
        return implode(',', $this->targets) .  ' :' . $this->text;
    }

    public function hasTarget($target)
    {
        return in_array($target, $this->targets());
    }
}
