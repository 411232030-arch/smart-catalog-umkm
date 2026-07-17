namespace App\Exports;

use App\Models\Transaksi; 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PendapatanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // FILTER: Mengambil data hanya jika tipenya adalah 'pendapatan' atau 'penjualan'
        // Sesuaikan 'tipe' dengan nama kolom di database Anda
        return Transaksi::where('tipe', 'pendapatan') 
                        ->orderBy('created_at', 'desc')
                        ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Produk',
            'Jumlah',
            'Total Pendapatan',
            'Tanggal',
        ];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->id,
            $transaksi->nama_produk,
            $transaksi->jumlah,
            $transaksi->total_harga, // Data angka agar bisa dihitung di Excel
            $transaksi->created_at->format('d/m/Y'),
        ];
    }
}