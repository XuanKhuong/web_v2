<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use App\Customer;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = ['id','name','phone','address','user_id','gender','old','created_at','updated_at'];
    protected $guard = "customers";
}
