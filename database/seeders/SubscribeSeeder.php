<?php

namespace Database\Seeders;

use App\Models\Subscribe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscribeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Subscribe::first();
        if (!$model)
        {
            $model = [
                [
                    'id' => 1, 'name' => 'پشتیبانی برنزی', 'slug' => 'bronze', 'sessions' => 4,
                    'image' => '/icons/bronze.svg', 'price' => 480000, 'period' => 1
                ],
                [
                    'id' => 2, 'name' => 'پشتیبانی نقره‌ای', 'slug' => 'silver', 'sessions' => 6,
                    'image' => '/icons/silver.svg', 'price' => 720000, 'period' => 1
                ],
                [
                    'id' => 3, 'name' => 'پشتیبانی طلایی', 'slug' => 'golden', 'sessions' => 10,
                    'image' => '/icons/gold.svg', 'price' => 1000000, 'period' => 3
                ],

            ];

            DB::table('subscribes')->insert($model);
        }
    }
}
