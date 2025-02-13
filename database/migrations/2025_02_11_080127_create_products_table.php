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
        Schema::create('products', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('name', 120);
            $table->string('slug', 200);
            $table->string('sku', 100);
            $table->string('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('offer_price')->nullable();
            $table->date('offer_end_date')->nullable();
            $table->unsignedSmallInteger('category_id')->nullable();
            $table->unsignedSmallInteger('brand_id')->nullable();
            $table->unsignedSmallInteger('stock')->default(1);
            $table->unsignedMediumInteger('sales')->default(0);
            $table->unsignedInteger('views')->default(1);
            $table->boolean('status')->default(0);
            $table->string('course_type')->default(\App\Enums\CourseTypes::COURSE->value);
            $table->string('course_status')->default(\App\Enums\CourseStatus::RECORDEING->value);
            $table->string('meta')->nullable();
            $table->string('keywords')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('sessions')->default(1);
            $table->string('course_time')->nullable();
            $table->string('course_demo')->nullable();
            $table->string('git_repo')->nullable();
            $table->boolean('lisense_status')->default(1);
            $table->boolean('source_status')->default(1);
            $table->boolean('teacher_support')->default(1);
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
        Schema::dropIfExists('products');
    }
};
