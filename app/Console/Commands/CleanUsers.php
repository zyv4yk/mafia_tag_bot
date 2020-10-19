<?php

namespace App\Console\Commands;

use App\TagUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class CleanUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean old users';

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
    public function handle()
    {
        $users = TagUser::all();

        $deleted = [];
        $now     = Carbon::now();

        /** @var TagUser $user */
        foreach ($users as $user) {
            if ($now->diffInDays($user->updated_at) > 7) {
                TagUser::deleteUser($user->user_id, $user->chat_id);
                $deleted[$user->chat_id] = isset($deleted[$user->chat_id]) ? $deleted[$user->chat_id] + 1 : 1;
            }
        }

        foreach ($deleted as $chat => $count) {
            try {
                Request::sendMessage([
                    'chat_id' => $chat,
                    'text'    => "Удалено из списка $count пользователей",
                ]);
            } catch (TelegramException $e) {
                Log::critical($e);
            }
        }
    }
}
