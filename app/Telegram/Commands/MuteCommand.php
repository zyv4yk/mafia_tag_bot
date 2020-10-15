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

use App\Helper\Telegram;
use App\TagUser;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Commands\AdminCommand;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

/**
 * Start command
 */
class MuteCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'mute';

    /**
     * @var string
     */
    protected $description = 'mute command';

    /**
     * @var string
     */
    protected $usage = '/mute';

    /**
     * @var string
     */
    protected $version = '1.0.0';

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

        $isAdmin = Telegram::isChatAdmin($sendInChat, $sendUserId);

        $replyTo = $this->getMessage()->getReplyToMessage();

        if ($replyTo !== null && $isAdmin) {
            $userId    = $replyTo->getFrom()->getId();
            $chatId    = $replyTo->getChat()->getId();
            $name      = $replyTo->getFrom()->getFirstName();
            $messageId = $replyTo->getMessageId();

            if (TagUser::deleteUser($userId, $chatId)) {
                return $this->replyToChat(
                    "$name, ты удален из списка, так как играть с мутом запрещено правилами!",
                    ['parse_mode' => 'Markdown', 'reply_to_message_id' => $messageId]
                );
            }
        }

        return Request::emptyResponse();
    }
}
