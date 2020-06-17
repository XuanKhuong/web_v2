<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['id','name','address','phone','customer_id','status','employee_id','total','created_at','updated_at', 'stall_id'];
}
