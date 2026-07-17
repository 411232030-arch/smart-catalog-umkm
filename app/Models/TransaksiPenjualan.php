<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiPenjualan extends Model
{
    protected $table = 'transaksi_penjualan';

    protected $fillable = [
        'nomor_transaksi',
        'tanggal',
        'produk_id',
        'qty',
        'merchant_code',
        'harga_satuan',
        'total_harga',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'qty' => 'integer',
        'harga_satuan' => 'integer',
        'total_harga' => 'integer',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}