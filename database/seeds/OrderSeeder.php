<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\Stall;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $max_id_stalls = Stall::select('id')->where('stall_name', '!=', "")->max('id');

        $min_id_stalls = Stall::select('id')->where('stall_name', '!=', "")->min('id');
        
        $orders = Order::where('stall_id', 0)->get();

        foreach ($orders as $key => $order) {
            
        	if ($order['stall_id'] == 0) {
                $order->update([
                    'stall_id' => rand($min_id_stalls, $max_id_stalls)
                ]);
            }
               
        }
        // dd('ddd');
    }
}
