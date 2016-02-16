<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC\Commands;

use PHPOxford\Spires\IRC\Message\Command as CommandInterface;

class Join extends Base implements CommandInterface
{
    /**
     * @var string
     */
    protected $command = 'JOIN';

    /**
     * @var string[]
     */
    private $channels;

    /**
     * @var string[]
     */
    private $keys;

    public function __construct(array $channels, array $keys = null)
    {
        $this->channels = $channels;
        $this->keys = $keys ?? [];
    }

    public static function fromParams(string $params) : self
    {
        $arguments = explode(' ', $params);

        $channels = explode(',', $arguments[0]);
        $keys = isset($arguments[1]) ? explode(',', $arguments[1]) : [];

        return new static($channels, $keys);
    }

    public function channels() : array
    {
        return $this->channels;
    }

    public function keys() : array
    {
        return $this->keys;
    }

    public function params() : string
    {
        return trim(implode(',', $this->channels) .  ' ' . implode(',', $this->keys));
    }
}
