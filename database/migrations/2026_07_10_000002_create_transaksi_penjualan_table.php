<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();     // Nomor Transaksi
            $table->timestamp('tanggal')->useCurrent();       // Tanggal (auto)
            $table->foreignId('produk_id')->constrained('produk')->cascadeOnDelete(); // Produk
            $table->unsignedInteger('qty');                   // Qty
            $table->string('merchant_code');                  // Merchant Code (Sales)
            $table->unsignedInteger('harga_satuan');           // snapshot harga saat transaksi
            $table->unsignedBigInteger('total_harga');         // qty * harga_satuan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_penjualan');
    }
};