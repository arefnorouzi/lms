<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Course::first();
        if (!$model)
        {
            $products = Product::get();
            foreach ($products as $product)
            {
                for ($i = 1; $i <= 7; $i++)
                {
                    Course::create([
                       'product_id' => $product->id,
                        'name' => "فصل $i",
                        'description' => "<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. </p>
<ul>
<li><a href='#'>لینک قسمت اول</a></li>
<li><a href='#'>لینک قسمت دوم</a></li>
<li><a href='#'>لینک قسمت سوم</a></li>
</ul>
"
                    ]);
                }
            }
        }
    }
}
