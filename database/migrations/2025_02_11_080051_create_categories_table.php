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
        Schema::create('categories', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name', 100);
            $table->string('slug', 200)->unique();
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('parent_id')->nullable();
            $table->string('meta')->nullable();
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('home_page')->default(true);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
