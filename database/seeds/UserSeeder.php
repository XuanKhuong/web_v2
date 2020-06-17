<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Stall;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$max_id_stalls = Stall::select('id')->where('stall_name', '!=', "")->max('id');

        $min_id_stalls = Stall::select('id')->where('stall_name', '!=', "")->min('id');
        
        $users = User::where('stall_id', 0)->where('admin', 1)->get();

        foreach ($users as $key => $user) {
            
        	if ($user['stall_id'] == 0) {
                $user->update([
                    'stall_id' => rand($min_id_stalls, $max_id_stalls)
                ]);
            }
               
        }*/

        $users = User::where('stall_id', 0)->where('customer', 0)->update([
            'employee'  =>  0,
            'customer'  =>  1,
            'admin'     =>  0
        ]);
    }
}
