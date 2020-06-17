<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Component;
class Component extends Model
{
	
	protected $table = 'components';
	protected $fillable = ['id','name','description','thumbnail','slug','user_id','created_at','updated_at'];
}
