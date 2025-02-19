<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = rand(0, 1);
        $price = rand(80, 100) * 10000;
        $offer_price = null;
        $offer_end_date = null;
        if($status)
        {
            $offer_price = rand(60, 79) * 10000;
            $offer_end_date = now()->addDays(rand(3, 30));
        }

        $titles = ["آموزش", "دوره", "پکیج"];
        $name = $titles[rand(1, count($titles)) -1] . " " . $this->faker->company();
        $rand_number = rand(1, 10);
        $sku = rand(1, 50) . '-' . rand(1, 1000);
        $image_rand = rand(1, 3);
        return [
            'name' => $name,
            'subtitle' => 'آموزش پروژه محور ' . $name,
            'slug' => Str::slug($name),
            'thumbnail' => "/uploads/products/$image_rand.jpg",
            'image' => "/uploads/posts/$image_rand.jpg",
            'meta' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.',
            'description' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.',
            'category_id' => rand(1, 9),
            'sku' => $sku,
            'status' => 1,
            'views' => rand(5, 860),
            'published_at' => now()->subWeeks(rand(1, 30)),
            'user_id' => User::factory()
        ];
    }
}
