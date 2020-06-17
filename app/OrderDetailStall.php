<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetailStall extends Model
{
    protected $table = 'order_detail_stalls';
    protected $fillable = ['id', 'stall_id', 'order_detail_id', 'created_at', 'updated_at'];
}
