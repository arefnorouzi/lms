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
        Schema::create('order_items', function (Blueprint $table) {
            $table->integerIncrements('id')->unsigned();
            $table->unsignedMediumInteger('order_id');
            $table->unsignedSmallInteger('qty')->default(1);
            $table->unsignedMediumInteger('product_id')->nullable();
            $table->unsignedInteger('unit_price');
            $table->unsignedInteger('product_price')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
