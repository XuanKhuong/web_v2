<?php

use Illuminate\Database\Seeder;
use App\OrderStall;
use App\Order;

class OrderStallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::select('id', 'stall_id')->get();

        foreach ($orders as $order) {

        	if ($order['id'] != 0 && $order['stall_id'] != 0) {
	        	// var_dump($order['stall_id']);
	        	// var_dump($order['id']);
        		$order_stalls = OrderStall::create([
        			'stall_id' => $order['stall_id'],
        			'order_id' => $order['id']
        		]);
        	}
        }

        // dd('ddd');
    }
}
