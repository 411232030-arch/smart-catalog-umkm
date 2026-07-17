<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Carbon;

class ReportService
{
    /**
     * Generate PDF Report untuk semua transaksi penjualan
     */
    public function generatePDF($filters = [])
    {
        $query = TransaksiPenjualan::with('produk')->orderBy('tanggal', 'desc');

        if (!empty($filters['start_date'])) {
            $query->whereDate('tanggal', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('tanggal', '<=', $filters['end_date']);
        }

        $transaksi = $query->get();

        $total_transaksi = $transaksi->count();
        $total_pendapatan = $transaksi->sum('total_harga');
        $rata_rata_transaksi = $total_transaksi > 0 ? round($total_pendapatan / $total_transaksi, 0) : 0;
        $profit_bersih = $total_pendapatan * 0.65;

        $data = [
            'transaksi' => $transaksi,
            'total_transaksi' => $total_transaksi,
            'total_pendapatan' => $total_pendapatan,
            'rata_rata_transaksi' => $rata_rata_transaksi,
            'profit_bersih' => $profit_bersih,
            'generated_at' => now(),
            'period' => $this->getPeriodLabel($filters),
        ];

        $pdf = Pdf::loadView('reports.transaksi-pdf', $data)
            ->setPaper('a4')
            ->setOrientation('portrait');

        return $pdf;
    }

    /**
     * Get period label dari filters
     */
    private function getPeriodLabel($filters): string
    {
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            return Carbon::parse($filters['start_date'])->format('d-M-Y') . ' s/d ' .
                   Carbon::parse($filters['end_date'])->format('d-M-Y');
        } elseif (!empty($filters['start_date'])) {
            return 'Dari ' . Carbon::parse($filters['start_date'])->format('d-M-Y');
        } else {
            return 'Semua Data';
        }
    }

    /**
     * Export Excel dengan format yang lebih baik
     */
    public function generateExcel($filters = [])
    {
        $query = TransaksiPenjualan::with('produk')->orderBy('tanggal', 'asc');

        if (!empty($filters['start_date'])) {
            $query->whereDate('tanggal', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('tanggal', '<=', $filters['end_date']);
        }

        $transaksi = $query->get();

        $total_pendapatan = $transaksi->sum('total_harga');
        $total_keuntungan = $total_pendapatan * 0.65;

        $filename = 'laporan_penjualan_' . now()->format('Y-m-d_His') . '.xlsx';

        $callback = function () use ($transaksi, $total_pendapatan, $total_keuntungan) {
            echo "\xEF\xBB\xBF";
            echo '<html><head><meta charset="UTF-8"></head><body>';
            echo '<table border="1" cellpadding="5">';

            echo '<tr><th colspan="6" style="font-size:16px;background:#78350f;color:#fff;text-align:center;">LAPORAN TRANSAKSI PENJUALAN</th></tr>';
            echo '<tr><th colspan="6" style="text-align:center;">PT. UMKM COFFEE</th></tr>';
            echo '<tr><th colspan="6" style="text-align:center;">Dicetak: ' . now()->format('d-m-Y H:i:s') . '</th></tr>';
            echo '<tr></tr>';

            echo '<tr style="background:#fde68a;font-weight:bold;text-align:center;">';
            echo '<td>No</td>';
            echo '<td>Nomor Transaksi</td>';
            echo '<td>Tanggal</td>';
            echo '<td>Produk</td>';
            echo '<td>Qty</td>';
            echo '<td>Total Harga (Rp)</td>';
            echo '</tr>';

            foreach ($transaksi as $index => $row) {
                echo '<tr>';
                echo '<td style="text-align:center;">' . ($index + 1) . '</td>';
                echo '<td>' . $row->nomor_transaksi . '</td>';
                echo '<td style="text-align:center;">' . Carbon::parse($row->tanggal)->format('d-m-Y H:i') . '</td>';
                echo '<td>' . ($row->produk->nama_kopi ?? 'N/A') . '</td>';
                echo '<td style="text-align:center;">' . $row->qty . '</td>';
                echo '<td style="text-align:right;">' . number_format($row->total_harga, 0, ',', '.') . '</td>';
                echo '</tr>';
            }

            echo '<tr></tr>';
            echo '<tr style="font-weight:bold;background:#fef3c7;">';
            echo '<td colspan="5">TOTAL PENDAPATAN</td>';
            echo '<td style="text-align:right;background:#fcd34d;">' . number_format($total_pendapatan, 0, ',', '.') . '</td>';
            echo '</tr>';

            echo '<tr style="font-weight:bold;background:#dcfce7;color:#059669;">';
            echo '<td colspan="5">ESTIMASI KEUNTUNGAN BERSIH (65%)</td>';
            echo '<td style="text-align:right;background:#bbf7d0;">' . number_format($total_keuntungan, 0, ',', '.') . '</td>';
            echo '</tr>';

            echo '</table>';
            echo '</body></html>';
        };

        return $callback;
    }
}
