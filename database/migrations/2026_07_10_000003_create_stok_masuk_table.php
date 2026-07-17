<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('stock_code')->unique();          // Stock Code
            $table->timestamp('tanggal')->useCurrent();        // Tanggal (auto)
            $table->foreignId('produk_id')->constrained('produk')->cascadeOnDelete(); // Produk
            $table->unsignedInteger('qty');                    // Qty
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_masuk');
    }
};