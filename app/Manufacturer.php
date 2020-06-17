<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Manufacturer;

class Manufacturer extends Model
{
    protected $table = 'manufacturers';
    protected $fillable = ['id','name','thumbnail','product_id','created_at','updated_at'];
}
