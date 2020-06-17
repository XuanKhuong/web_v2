<?php

use Illuminate\Database\Seeder;
use App\Stall;
use App\Statistical;

class StatisticalSeeder extends Seeder
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
        
        $statisticals = Statistical::where('stall_id', 0)->get();

        foreach ($statisticals as $key => $statistical) {
            
        	if ($statistical['stall_id'] == 0) {
                $statistical->update([
                    'stall_id' => rand($min_id_stalls, $max_id_stalls)
                ]);
            }
               
        }
    }
}
