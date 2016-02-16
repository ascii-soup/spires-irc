<?php
declare(strict_types=1);

namespace PHPOxford\Spires\IRC\Commands;

use PHPOxford\Spires\IRC\Message\Command as CommandInterface;

class Command extends Base implements CommandInterface
{
    /**
     * @var string
     */
    protected $command;

    /**
     * @var string
     */
    protected $params;

    public function __construct(string $command, string $params = null)
    {
        $this->command = $command;
        $this->params = $params ?: '';
    }

    public static function fromParams(string $params) : self
    {
        // TODO: Implement fromParams() method.
    }

    public function params() : string
    {
        return $this->params;
    }
}
