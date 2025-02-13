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
        Schema::create('invoices', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->unsignedMediumInteger('user_id');
            $table->unsignedInteger('amount')->default(0);
            $table->unsignedInteger('payment_method_id')->nullable();
            $table->string('bank_trans_id', 200)->nullable();
            $table->string('bank_payment_code', 200)->nullable();
            $table->string('customer_name', 70)->nullable();
            $table->string('card_number', 70)->nullable();
            $table->string('status')->default(\App\Enums\PaymentStatus::PENDING->value);
            $table->string('payment_type', 50)->default(\App\Enums\InvoiceTypes::DEPOSIT->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
