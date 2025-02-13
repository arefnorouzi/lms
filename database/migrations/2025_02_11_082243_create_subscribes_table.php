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
        Schema::create('subscribes', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned();
            $table->string('name');
            $table->string('meta')->nullable();
            $table->string('image')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedInteger('price');
            $table->unsignedInteger('offer_price')->nullable();
            $table->date('offer_end_date')->nullable();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('period')->default(1); // 1 month
            $table->unsignedInteger('free_lower_than')->default(100000);
            $table->unsignedTinyInteger('sessions')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribes');
    }
};
