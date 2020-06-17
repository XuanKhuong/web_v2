<?php

use Illuminate\Database\Seeder;
use App\Stall;
use App\Manufacturer;
use App\ManufacturerStall;

class ManufacturerStallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manufacturers = Manufacturer::select('id')->get();
        $stalls = Stall::select('id')->get();

        foreach ($stalls as $stall) {
        	
        	foreach ($manufacturers as $manufacturer) {
        		$manufacturer_stalls = ManufacturerStall::create([
        			'stall_id' => $stall['id'],
        			'manufacturer_id' => $manufacturer['id']
        		]);
        	}

        }
    }
}
