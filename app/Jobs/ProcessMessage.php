<?php

namespace App\Jobs;

use App\TagUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Log\Logger;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class ProcessMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $message;

    /**
     * Create a new job instance.
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @param PhpTelegramBotContract $telegram
     *
     * @return void
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function handle(PhpTelegramBotContract $telegram, Logger $log): void
    {
//        $log->info('resilent proccess');
//        $log->info($this->message);
        $message = json_decode($this->message, true);
        $message = $message['message'];
        TagUser::saveNewTag($message['from']['id'], $message['chat']['id'], $message['from']['first_name']);
    }
}
