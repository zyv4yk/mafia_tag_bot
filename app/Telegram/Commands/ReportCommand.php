<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
/**
 * Start command
 */
class ReportCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'report';

    /**
     * @var string
     */
    protected $description = 'report command';

    /**
     * @var string
     */
    protected $usage = '/report';

    /**
     * @var string
     */
    protected $version = '1.1.0';

    /**
     * Command execute method
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute()
    {
        return $this->replyToChat(
            "Уф бля, снова ядом брызгаетесь"
        );
    }
}
