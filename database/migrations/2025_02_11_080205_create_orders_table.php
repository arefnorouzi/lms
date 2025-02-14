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
        Schema::create('orders', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->unsignedMediumInteger('user_id');
            $table->string('uuid');
            $table->string('status', 100)
                ->default(\App\Enums\OrderStatuses::PENDING->value);
            $table->unsignedInteger('amount')->default(0);
            $table->unsignedInteger('discount')->default(0);
            $table->unsignedInteger('shipping_cost')->default(0);
            $table->unsignedInteger('tax')->default(0);
            $table->unsignedInteger('total')->default(0);
            $table->string('discount_code', 50)->nullable();
            $table->unsignedTinyInteger('payment_method_id')->nullable();
            $table->unsignedTinyInteger('shipping_method_id')->nullable();
            $table->string('bank_trans_id', 200)->nullable();
            $table->string('bank_payment_code', 200)->nullable();
            $table->string('post_tracking_code', 200)->nullable();
            $table->string('customer_name', 70)->nullable();
            $table->string('customer_email', 70)->nullable();
            $table->string('customer_address', 250)->nullable();
            $table->string('customer_zip_code', 10)->nullable();
            $table->string('customer_phone', 30)->nullable();
            $table->string('customer_note', 250)->nullable();
            $table->timestamp('purchased_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
