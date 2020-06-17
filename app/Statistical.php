<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistical extends Model
{
    protected $table = 'statisticals';
    protected $fillable = ['id','name','qty_sold','interest','product_detail_id','bought_at','created_at','updated_at', 'stall_id'];
}
