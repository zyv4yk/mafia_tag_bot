<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use App\TagUser;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class RegCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'addme';

    /**
     * @var string
     */
    protected $description = 'Addme command';

    /**
     * @var string
     */
    protected $usage = '/addme';

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

        $userId   = $this->getMessage()->getFrom()->getId();
        $userName = $this->getMessage()->getFrom()->getFirstName();
        $chatId   = $this->getMessage()->getChat()->getId();

        $messageId = $this->getMessage()->getMessageId();

        if (TagUser::saveNewTag($userId, $chatId, $userName)) {
            return $this->replyToChat(
                "${userName} теперь в семье :) ",
                ['parse_mode' => 'Markdown', 'reply_to_message_id' => $messageId]
            );
        }

        return $this->replyToChat(
            "Я усталь, попробуй позже",
            ['parse_mode' => 'Markdown', 'reply_to_message_id' => $messageId]
        );
    }
}
