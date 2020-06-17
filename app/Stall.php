<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stall extends Model
{
    protected $table = 'stalls';
    protected $fillable = ['id', 'user_id', 'stall_name', 'address', 'created_at', 'updated_at'];
}
