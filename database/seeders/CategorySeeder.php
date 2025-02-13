<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Category::first();
        if(!$model)
        {
            $model = [
                [
                    'id' => 1, 'name' => 'پایتون', 'slug' => 'python', 'image' => '/icons/python.svg', 'parent_id' => null
                ],
                [
                    'id' => 2, 'name' => 'PHP', 'slug' => 'php', 'image' => '/icons/php.svg', 'parent_id' => null
                ],
                [
                    'id' => 3, 'name' => 'جاوا اسکریپت', 'slug' => 'js', 'image' => '/icons/js.svg', 'parent_id' => null
                ],
                [
                    'id' => 4, 'name' => 'وردپرس', 'slug' => 'wordpress', 'image' => '/icons/wp.svg', 'parent_id' => null
                ],
                [
                    'id' => 5, 'name' => 'لاراول', 'slug' => 'laravel', 'image' => '/icons/laravel.svg', 'parent_id' => 2
                ],
                [
                    'id' => 6, 'name' => 'جنگو', 'slug' => 'django', 'image' => '/icons/django.svg', 'parent_id' => 1
                ],
                [
                    'id' => 7, 'name' => 'FastAPI', 'slug' => 'fastapi', 'image' => '/icons/fastapi.svg', 'parent_id' => 1
                ],
                [
                    'id' => 8, 'name' => 'react', 'slug' => 'react', 'image' => '/icons/react.svg', 'parent_id' => 3
                ],
                [
                    'id' => 9, 'name' => 'vue', 'slug' => 'vue', 'image' => '/icons/vue.svg', 'parent_id' => 3
                ],
            ];

            DB::table('categories')->insert($model);
        }
    }
}
