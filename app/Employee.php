<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use App\Employee;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['id','name','phone','address','user_id','gender','old','created_at','updated_at'];
    protected $guard = "employees";
}
