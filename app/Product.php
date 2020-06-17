<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['id','name','description','thumbnail','slug','user_id','created_at','updated_at'];
}
