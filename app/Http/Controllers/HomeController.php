<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => 'getLogout']);
    }

    public function getindex(){
        return view('home');
    }

    public function getLogout(){
        Auth::logout();
        return redirect(\URL::previous());
    }
}
