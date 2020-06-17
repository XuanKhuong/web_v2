<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManufacturerStall extends Model
{
    protected $table = 'manufacturer_stalls';
    protected $fillable = ['id', 'stall_id', 'manufacturer_id', 'created_at', 'updated_at'];
}
