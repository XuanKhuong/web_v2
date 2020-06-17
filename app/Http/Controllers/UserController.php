<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => 'getLogout']);
    }

    public function getProFile(){
    	$user = Auth::user();
    	dd($user);
    	return view('content-profile.profile', compact('user'));
    }
}
