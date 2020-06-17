<?php

use Illuminate\Database\Seeder;
use App\UserChat;
use App\User;
use App\Chat;

class UserChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$getChat = Chat::select('id', 'user_id', 'stall_manager_id')->get();
    	$users = array(1, 3, 16, 19);

    	foreach ($users as $user_id) {
    		foreach ($getChat as $chat) {
    			if ($user_id == $chat->user_id) {
    				UserChat::create([
		    				'user_id' => $user_id,
		    				'chat_id' => $chat->id
		    			]);
    			} else if ($user_id == $chat->stall_manager_id) {
    				UserChat::create([
		    				'user_id' => $user_id,
		    				'chat_id' => $chat->id
		    			]);
    			}
    		}
    	}

    	// UserChat::truncate();



    	// dd();
    }
}
