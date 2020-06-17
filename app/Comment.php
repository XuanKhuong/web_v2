<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Comment;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['id','content','user_id','product_dt_id','product_id','created_at','updated_at'];
}
