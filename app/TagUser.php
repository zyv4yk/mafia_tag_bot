<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class TagUser
 * @package App
 * @property $user_id
 * @property $chat_id
 * @property $name
 * @property $updated_at
 * @property $created_at
 */
class TagUser extends Model
{
    protected $table = 'tag_users';
    protected $primaryKey = 'user_id';

    protected $fillable = ['user_id', 'chat_id', 'name'];
    public $timestamps = true;

    public static function saveNewTag($userId, $chatId, $userName)
    {
        $blackList = explode(',', config('phptelegrambot.tag_black_list'));

        $blackList = $blackList ?: [];

        if (in_array($userId, $blackList, false)) {
            return true;
        }

        if ($user = self::isUserSaved($userId, $chatId)) {
            $now = Carbon::now();
            if ($user->updated_at === null || $now->diffInDays($user->updated_at) > 1) {
                $user->updateTimestamps();
                $user->save();
            }

            return true;
        }

        $model          = new self();
        $model->user_id = $userId;
        $model->chat_id = $chatId;
        $model->name    = $userName;
        $model->updateTimestamps();

        return $model->save();
    }

    public static function deleteUser($userId, $chatId)
    {
        return DB::delete('DELETE FROM tag_users WHERE user_id = ? AND chat_id = ?', [$userId, $chatId]);
    }

    public static function isUserSaved($userId, $chatId)
    {
        return TagUser::where('user_id', '=', $userId)->where('chat_id', '=', $chatId)->first();
    }

    public static function getAllByChatId($chatId, $userId)
    {
        return TagUser::where('chat_id', '=', $chatId)->where('user_id', '!=', $userId)->get();
    }
}
