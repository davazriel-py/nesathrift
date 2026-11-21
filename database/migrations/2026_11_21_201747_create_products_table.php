<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();

            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('price');
            $table->enum('condition', ['baru', 'seperti_baru', 'layak_pakai']);
            $table->enum('campus_location', ['ketintang', 'lidah_wetan', 'lainnya']);
            $table->string('image_path');

            // Status & data penjualan
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->foreignId('buyer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('sold_price')->nullable();
            $table->timestamp('sold_at')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('campus_location');
            $table->index('price');
            $table->index(['category_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};