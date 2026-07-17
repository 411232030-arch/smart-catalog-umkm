<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .generated-date {
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead tr {
            background-color: #f5e6d3;
            border: 1px solid #ddd;
        }
        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
        }
        table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .summary-row {
            font-weight: bold;
        }
        .summary-row.total {
            background-color: #fef3c7;
        }
        .summary-row.profit {
            background-color: #dcfce7;
            color: #059669;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            border-top: 2px solid #333;
            padding-top: 15px;
            font-size: 12px;
            color: #666;
        }
        .stats {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .stat-item {
            display: inline-block;
            margin-right: 30px;
            font-size: 13px;
        }
        .stat-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">PT. UMKM COFFEE</div>
        <div class="report-title">LAPORAN TRANSAKSI PENJUALAN</div>
        <div class="generated-date">
            Periode: {{ $period }} | Dicetak: {{ $generated_at->format('d-m-Y H:i:s') }}
        </div>
    </div>

    <div class="stats">
        <div class="stat-item">
            <span class="stat-label">Total Transaksi:</span> {{ $total_transaksi }}
        </div>
        <div class="stat-item">
            <span class="stat-label">Rata-rata per Transaksi:</span> Rp {{ number_format($rata_rata_transaksi, 0, ',', '.') }}
        </div>
        <div class="stat-item">
            <span class="stat-label">Total Pendapatan:</span> Rp {{ number_format($total_pendapatan, 0, ',', '.') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Nomor Transaksi</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 25%;">Produk</th>
                <th style="width: 8%; text-align: center;">Qty</th>
                <th style="width: 15%; text-align: right;">Harga Satuan</th>
                <th style="width: 20%; text-align: right;">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->nomor_transaksi }}</td>
                <td>{{ $item->tanggal->format('d-m-Y H:i') }}</td>
                <td>{{ $item->produk->nama_kopi ?? 'N/A' }}</td>
                <td style="text-align: center;">{{ $item->qty }}</td>
                <td class="text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <tbody>
            <tr class="summary-row total">
                <td colspan="6">TOTAL PENDAPATAN</td>
                <td class="text-right">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</td>
            </tr>
            <tr class="summary-row profit">
                <td colspan="6">ESTIMASI KEUNTUNGAN BERSIH (65%)</td>
                <td class="text-right">Rp {{ number_format($profit_bersih, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini adalah laporan resmi transaksi penjualan PT. UMKM COFFEE</p>
        <p>Laporan dihasilkan secara otomatis oleh sistem Smart Catalog UMKM</p>
    </div>
</body>
</html>
