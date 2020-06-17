<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductDetail;

class ProductDetail extends Model
{
    protected $table = 'product_details';
    protected $fillable = ['id','name','description','slug','price','sale_price','qty','product_id','manufacturer_id','user_id','created_at','updated_at', 'stall_id'];

    public function images() {
        return $this->hasMany('App\Image', 'product_detail_id');
    }
}
