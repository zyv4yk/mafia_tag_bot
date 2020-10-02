<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class CheckCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'check';

    /**
     * @var string
     */
    protected $description = 'Check command';

    /**
     * @var string
     */
    protected $usage = '/check';

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
        $messageId = $this->getMessage()->getMessageId();


        return $this->replyToChat(
            "Че надо?",
            ['reply_to_message_id' => $messageId]
        );
    }
}
