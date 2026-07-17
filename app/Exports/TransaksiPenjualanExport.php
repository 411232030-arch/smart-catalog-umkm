<?php

namespace App\Exports;

use App\Models\TransaksiPenjualan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransaksiPenjualanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection(): Collection
    {
        return TransaksiPenjualan::with('produk')
            ->orderByDesc('tanggal')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Transaksi',
            'Tanggal',
            'Produk',
            'Qty',
            'Merchant Code',
            'Harga Satuan (Rp)',
            'Total Harga (Rp)',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->nomor_transaksi,
            optional($row->tanggal)->format('d-m-Y H:i'),
            $row->produk->nama_kopi ?? '-',
            $row->qty,
            $row->merchant_code,
            $row->harga_satuan,
            $row->total_harga,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}