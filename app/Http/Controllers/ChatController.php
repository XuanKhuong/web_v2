<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Chat;
use App\Message;

class ChatController extends Controller
{
    public function getNoti(){
    	$count_noti = Message::where('receiver_id', Auth::id())
    						 ->where('status', 0)
    						 ->count();
    	dd($count_noti);
    }
}
