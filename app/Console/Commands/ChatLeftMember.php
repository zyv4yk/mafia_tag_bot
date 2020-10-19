<?php

namespace App\Console\Commands;

use App\TagUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Request;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class ChatLeftMember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:left:member';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(PhpTelegramBotContract $telegram)
    {
        $users = TagUser::all();

        /** @var TagUser $user */
        foreach ($users as $user) {
            $info = Request::getChatMember([
                'chat_id' => $user->chat_id,
                'user_id' => $user->user_id,
            ]);

            $info = json_decode($info, true);


            if ($info['ok'] !== true || $info['result']['status'] === 'left') {
                TagUser::deleteUser($user->user_id, $user->chat_id);
            }
        }

        return true;
    }
}
