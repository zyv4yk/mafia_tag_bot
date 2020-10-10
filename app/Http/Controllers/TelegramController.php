<?php


namespace App\Http\Controllers;


use App\Jobs\ProcessMessage;
use Exception;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Exception\TelegramException;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class TelegramController extends Controller
{
    public function register(PhpTelegramBotContract $telegram, Logger $logger)
    {
        try {
            $hookUrl = config('app.url'). '/hook'; //TODO: url()
            $result  = $telegram->setWebhook($hookUrl);

            if ($result->isOk()) {
                $logger->info($result->getDescription());
            }

            return response($result->getDescription())->send();
        } catch (Exception $e) {
            $logger->error($e);
        }

        return response('Check logs')->send();
    }

    public function hook(PhpTelegramBotContract $telegram, Logger $logger)
    {
        try {
            $telegram->handle();

            //$logger->info($telegram->getCustomInput());
            if ($this->isCommandInMessage($telegram->getCustomInput())) {
                ProcessMessage::dispatch($telegram->getCustomInput());
            }
        } catch (TelegramException $e) {
            $logger->error($e);
        }
    }

    protected function isCommandInMessage($messageData): bool
    {
        $messageData = json_decode($messageData, true);

        if (isset($messageData['message']['entities']) && count($messageData['message']['entities'])) {
            foreach ($messageData['message']['entities'] as $entity) {
                if ($entity['type'] === 'bot_command') {
                    return false;
                }
            }
        }

        return true;
    }
}
