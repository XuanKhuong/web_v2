<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';
    protected $fillable = ['id','user_id','stall_manager_id','created_at','updated_at'];
}
