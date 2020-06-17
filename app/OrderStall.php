<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStall extends Model
{
    protected $table = 'order_stalls';
    protected $fillable = ['id', 'order_id', 'stall_id', 'created_at', 'updated_at'];
}
