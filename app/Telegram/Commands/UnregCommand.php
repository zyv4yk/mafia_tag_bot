<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use App\TagUser;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class UnregCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'unreg';

    /**
     * @var string
     */
    protected $description = 'Remove command';

    /**
     * @var string
     */
    protected $usage = '/unreg';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var bool
     */
    protected $private_only = false;

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        $userId    = $this->getMessage()->getFrom()->getId();
        $chatId    = $this->getMessage()->getChat()->getId();
        $messageId = $this->getMessage()->getMessageId();

        if (TagUser::deleteUser($userId, $chatId)) {
            return $this->replyToChat(
                "Готово, ты покинул семью!",
                ['reply_to_message_id' => $messageId]
            );
        }

        return $this->replyToChat(
            "Я усталь, попробуй позже",
            ['parse_mode' => 'Markdown', 'reply_to_message_id' => $messageId]
        );
    }
}
