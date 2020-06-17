<?php

use Illuminate\Database\Seeder;
use App\ProductDetail;
use App\Stall;

class ProductDetailSeeder extends Seeder
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
        
        $product_details = ProductDetail::where('stall_id', 0)->get();

        foreach ($product_details as $key => $product_detail) {
            
        	if ($product_detail['stall_id'] == 0) {
                $product_detail->update([
                    'stall_id' => rand($min_id_stalls, $max_id_stalls)
                ]);
            }
               
        }
    }
}
