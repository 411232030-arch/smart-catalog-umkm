<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('transaksi_kopi');
    }

    public function down(): void
    {
        Schema::create('transaksi_kopi', function (Blueprint $table) {
            $table->id();
            $table->integer('nominal_pendapatan');
            $table->timestamps();
        });
    }
};
