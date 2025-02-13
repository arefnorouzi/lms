<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Comment::first();
        if(!$model)
        {
            Comment::factory()->count(100)->product_comment()->create();
            Comment::factory()->count(50)->product_child()->create();
        }
    }
}
