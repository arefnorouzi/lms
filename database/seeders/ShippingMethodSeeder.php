<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = ShippingMethod::first();
        if (!$model){
            $items = array(
                array('id'=> 1,'title'=>'دانلود','image'=>'','price' => 0, 'status' => 1),
            );
            foreach ($items as $item)
            {
                DB::table('shipping_methods')->insert($item);
            }
        }
    }
}
