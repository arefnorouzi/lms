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
        Schema::create('comments', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->text('content');
            $table->boolean('status')->default(false);
            $table->morphs('commentable'); // This creates `commentable_id` and `commentable_type`
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedMediumInteger('parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
