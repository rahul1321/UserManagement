<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Chat.
 *
 * @package namespace App\Entities;
 */
class Chat extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message','chat_room_id','to_user_id','from_user_id'];

    public function toUser()
    {
        return $this->belongsTo(User::class,'to_user_id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class,'from_user_id');
    }
    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class,'chat_room_id');
    }
}
