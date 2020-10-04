<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class TagUser
 * @package App
 * @property $user_id
 * @property $chat_id
 * @property $name
 */
class TagUser extends Model
{
    protected $table = 'tag_users';
    protected $primaryKey = 'user_id';

    protected $fillable = ['user_id', 'chat_id', 'name'];
    public $timestamps = false;

    public static function saveNewTag($userId, $chatId, $userName)
    {
        $blackList = explode(',', config('phptelegrambot.tag_black_list'));

        $blackList = $blackList ?: [];

        if (in_array($userId, $blackList, false) || self::isUserSaved($userId, $chatId)) {
            return true;
        }

        $model          = new self();
        $model->user_id = $userId;
        $model->chat_id = $chatId;
        $model->name    = $userName;

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
