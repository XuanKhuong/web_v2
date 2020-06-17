<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DetailComponent;

class DetailComponent extends Model
{
    protected $table = 'component_details';
    protected $fillable = ['id','name','component_id','description','qty','price','sale_price','slug','user_id','created_at','updated_at'];
}
