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
use Longman\TelegramBot\Request;

/**
 * Start command
 */
class AbstractCommand extends UserCommand
{
    protected function isAdmin($chatId, $sendUserId)
    {
        $chatAdmins = Request::getChatAdministrators([
            'chat_id' => $chatId
        ]);

        $chatAdmins = json_decode($chatAdmins, true);

        $isAdmin = false;
        foreach ($chatAdmins['result'] as $admin) {
            if ($admin['user']['id'] === $sendUserId) {
                $isAdmin = true;
            }
        }

        return $isAdmin;
    }

    public function execute()
    {

    }
}
