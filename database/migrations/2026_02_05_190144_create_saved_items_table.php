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
        Schema::create('saved_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('saveable_type', 150);
            $table->unsignedBigInteger('saveable_id');
            $table->timestamps();
            $table->unique(['user_id', 'saveable_type', 'saveable_id'], 'uq_saved_unique');
            $table->index(['saveable_type', 'saveable_id'], 'idx_saved_item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_items');
    }
};
