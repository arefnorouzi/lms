<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'content' => $this->faker->realText(),
            'commentable_id' => rand(1, 20),
            'status' => 1,
        ];
    }

    public function post_comment(): static
    {
        return $this->state(fn (array $attributes) => [
            'commentable_type' => 'App\Models\Post',
        ]);
    }

    public function product_comment(): static
    {
        return $this->state(fn (array $attributes) => [
            'commentable_type' => 'App\Models\Product',
        ]);
    }

    public function product_child(): static
    {
        return $this->state(fn (array $attributes) => [
            'commentable_type' => 'App\Models\Product',
            'parent_id' => rand(1, 50),
        ]);
    }
}
