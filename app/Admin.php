<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use App\Admin;

class Admin extends Model
{
    protected $table = 'admins';
    protected $fillable = ['id','name','phone','address','user_id','gender','old','created_at','updated_at'];
    protected $guard = "admins";
}