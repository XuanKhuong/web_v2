<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Test;
use App\Chat;
use App\Message;
use Auth;
use Carbon;

class SendMessageController extends Controller
{
    public function getChatPartner($id)
    {
        if (Auth::check()) {

            $getChats = Chat::select('id', 'user_id', 'stall_manager_id')->get();
            $getPartners = array();

            foreach ($getChats as $chat) {
                if ($id == $chat->user_id) {
                    $getPartners['myChat'] = Chat::select('chats.id as chat_id', 'users.id as partner_id', 'users.name', 
                                                'users.thumbnail')
                                        ->join('users', 'users.id', '=', 'chats.stall_manager_id')
                                        ->where('chats.user_id', '=', $id)
                                        ->orderBy('chats.id', 'DESC')
                                        ->get();

                } else if ($id == $chat->stall_manager_id) {
                    $getPartners['partner'] = Chat::select('chats.id as chat_id', 'users.id as partner_id', 'users.name', 
                                                'users.thumbnail')
                                        ->join('users', 'users.id', '=', 'chats.user_id')
                                        ->where('chats.stall_manager_id', Auth::user()->id)
                                        ->orderBy('chats.id', 'DESC')
                                        ->get();
                }
            }

            return response()->json(['error' => false ,'data'=>$getPartners]);
        } else {

            return response()->json(['error' => true ,'message'=>'something wrong!']);
        }
    }

    public function getMessage($id)
    {
        if (Auth::check()) {
            $messages = Chat::select('messages.content', 'messages.sender_id', 'messages.id as messages_id', 'chats.user_id', 'chats.stall_manager_id')
                            ->join('messages', 'messages.chat_id', '=', 'chats.id')
                            ->where('messages.chat_id', '=', $id)
                            ->get();

            return response()->json(['error' => false ,'data'=>$messages]);
        } else {

            return response()->json(['error' => true ,'message'=>'something wrong!']);
        }
    }

    public function sendMessage(Request $request)
    {
        event(new Test($request->all()));

        $getChat =  Chat::select('id')
                        ->where('user_id', '=', $request->user_id)
                        ->orWhere('stall_manager_id', '=', $request->user_id)
                        ->first();

        if (empty($getChat)) {
            Chat::create([
                'user_id'           => $request->user_id,
                'stall_manager_id'  => $request->partner_id
            ]);
        }
        $createMess = Message::create([
                          'sender_id' => $request->user_id,
                          'chat_id'   => $getChat->id,
                          'content'   => $request->content
                      ]);

        return $createMess;
    }
}
