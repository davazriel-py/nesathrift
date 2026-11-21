<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();

            $table->unsignedBigInteger('offered_price')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled', 'completed'])
                  ->default('pending');

            $table->timestamps();

            $table->unique(['product_id', 'buyer_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};