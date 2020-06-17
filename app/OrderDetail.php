<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OrderDetail;

class OrderDetail extends Model
{
	protected $table = 'order_details';
    protected $fillable = ['id','name','qty','price','sale_price','total','order_id','created_at','updated_at', 'stall_id'];
}
