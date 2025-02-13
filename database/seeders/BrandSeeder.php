<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Brand::first();
        if (!$model)
        {
            $model = [
                [
                    'id' => 1, 'name' => 'پایتون' , 'title' => 'زبان پایتون',
                    'en_name' => 'python', 'slug' => 'python', 'image' => '/icons/python.svg'
                ],
                [
                    'id' => 2, 'name' => 'PHP' , 'title' => 'زبان PHP',
                    'en_name' => 'php', 'slug' => 'php', 'image' => '/icons/php.svg'
                ],
                [
                    'id' => 3, 'name' => 'جاوا اسکریپت' , 'title' => 'زبان جاوا اسکریپت',
                    'en_name' => 'javascript', 'slug' => 'js', 'image' => '/icons/js.svg'
                ],
                [
                    'id' => 4, 'name' => 'وردپرس' , 'title' => 'آموزش وردپرس',
                    'en_name' => 'wordpress', 'slug' => 'wordpress', 'image' => '/icons/wp.svg'
                ],
            ];

            DB::table('brands')->insert($model);
        }
    }
}
