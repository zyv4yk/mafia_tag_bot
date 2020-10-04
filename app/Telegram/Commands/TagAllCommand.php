<?php
namespace Longman\TelegramBot\Commands\UserCommands;

use App\TagUser;
use Generator;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class TagAllCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'tagall';

    /**
     * @var string
     */
    protected $description = 'Tag all command';

    /**
     * @var string
     */
    protected $usage = '/tagall';

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
        $chatId = $this->getMessage()->getChat()->getId();
        $userId = $this->getMessage()->getFrom()->getId();
        $tags   = TagUser::getAllByChatId($chatId, $userId);
        $count  = $tags->count();

        if ($count === 0) {
            return $this->replyToChat('No users to tag');
        }

        $generator = $this->getUsers($tags->all());
        $message   = '';
        for ($i = 1; $i <= $count; $i++) {
            $message .= $generator->current() . ' ';
            $generator->next();

            if ($i % 5 === 0) {
                $data = [
                    'chat_id'    => $chatId,
                    'parse_mode' => 'Markdown',
                    'text'       => $message,
                ];
                Request::sendMessage($data);
                $message = '';
            }
        }

        if ($message !== '') {
            $data = [
                'chat_id'    => $chatId,
                'parse_mode' => 'Markdown',
                'text'       => $message,
            ];
            Request::sendMessage($data);
        }

        return $this->replyToChat("Приглашение разослано. Всего отправлено: ${count}",
            [
                'chat_id'    => $chatId,
                'parse_mode' => 'Markdown'
            ]);
    }

    /**
     * @param array $tags
     *
     * @return Generator
     */
    protected function getUsers(array $tags): Generator
    {
        foreach ($tags as $userId => $tag) {
            yield "[${tag['name']}](tg://user?id=${tag['user_id']}) ";
        }
    }
}
