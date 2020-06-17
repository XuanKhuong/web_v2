<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductStall extends Model
{
    protected $table = 'product_stalls';
    protected $fillable = ['id', 'stall_id', 'product_id', 'created_at', 'updated_at'];
}
