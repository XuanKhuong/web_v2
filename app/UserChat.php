<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    protected $table 		= 'user_chats';
    protected $fillable 	= ['id, user_id', 'chat_id', 'created_at', 'updated_at'];
}
