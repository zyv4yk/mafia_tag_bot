<?php


namespace App\Helper;


use Longman\TelegramBot\Request;

class Telegram
{
    /**
     * @param string $chatId
     * @param string $userId
     *
     * @return bool
     */
    public static function isChatAdmin(string $chatId, string $userId): bool
    {
        $chatAdmins = Request::getChatAdministrators([
            'chat_id' => $chatId
        ]);

        $chatAdmins = json_decode($chatAdmins, true);

        $isAdmin = false;
        foreach ($chatAdmins['result'] as $admin) {
            if ($admin['user']['id'] === $userId) {
                $isAdmin = true;
            }
        }

        return $isAdmin;
    }
}
