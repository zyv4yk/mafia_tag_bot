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

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

/**
 * Start command
 */
class KickCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $name = 'kick';

    /**
     * @var string
     */
    protected $description = 'kick command';

    /**
     * @var string
     */
    protected $usage = '/kick';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    protected $enabled = false;

    /**
     * Command execute method
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute()
    {
        $sendUserId = $this->getMessage()->getFrom()->getId();
        $sendInChat = $this->getMessage()->getChat()->getId();

        $isAdmin = $this->isAdmin($sendInChat, $sendUserId);

        if (!$isAdmin) {
            Request::kickChatMember([
                'chat_id' => $sendInChat,
                'user_id' => $sendUserId,
            ]);

            Request::unbanChatMember([
                'chat_id' => $sendInChat,
                'user_id' => $sendUserId,
            ]);

            $this->replyToChat('Прівєт, пострижися :)');
        }

        return Request::emptyResponse();
    }
}
