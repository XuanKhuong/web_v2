<?php

use Illuminate\Database\Seeder;
use App\Stall;
use App\Product;
use App\ProductStall;

class ProductStallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::select('id')->get();
        $stalls = Stall::select('id')->get();

        foreach ($stalls as $stall) {
        	
        	foreach ($products as $product) {
        		$product_stalls = ProductStall::create([
        			'stall_id' => $stall['id'],
        			'product_id' => $product['id']
        		]);
        	}

        }
    }
}
