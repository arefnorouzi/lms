<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('name', 120);
            $table->string('slug', 200);
            $table->string('sku', 100);
            $table->string('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedSmallInteger('category_id')->nullable();
            $table->unsignedInteger('views')->default(1);
            $table->boolean('status')->default(0);
            $table->string('meta')->nullable();
            $table->string('keywords')->nullable();
            $table->text('description')->nullable();
            $table->string('video')->nullable();
            $table->string('git_repo')->nullable();
            $table->unsignedMediumInteger('user_id')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
