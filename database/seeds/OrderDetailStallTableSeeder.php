<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\OrderDetail;
use App\Stall;
use App\OrderDetailStall;

class OrderDetailStallTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::select('id', 'stall_id')->get();

        foreach ($orders as $key => $order) {
        	if ($order['stall_id'] != 0) {
        		
        		$order_details = OrderDetail::select('id', 'order_id')->where('order_id', $order['id'])->get();

        		foreach ($order_details as $key => $order_detail) {
        			
        			$order_detail_stalls = OrderDetailStall::create([
        				'stall_id' => $order['stall_id'],
        				'order_detail_id' => $order_detail['id']
        			]);

        		}
        	}
        }

        // dd('ddd');
    }
}
