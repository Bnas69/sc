<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $transaction->nomor_transaksi }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 13px;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
            background-color: #ffffff;
        }
        .invoice-card {
            max-width: 650px;
            margin: auto;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 30px;
        }
        .brand-section {
            border-bottom: 3px solid #10b981; /* Emerald Line */
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .brand-title {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.5px;
        }
        .brand-subtitle {
            font-size: 10px;
            color: #10b981;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1.5px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .meta-table td {
            vertical-align: top;
            width: 50%;
        }
        .meta-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .meta-value {
            font-size: 13px;
            font-weight: bold;
            color: #1e293b;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #f8fafc;
            border-bottom: 1px solid #cbd5e1;
            padding: 10px 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #475569;
            text-align: left;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }
        .total-box {
            text-align: right;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-top: 20px;
        }
        .total-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .total-val {
            font-size: 22px;
            font-weight: 900;
            color: #0f172a;
        }
        .footer-note {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="invoice-card">
        <!-- Brand Section -->
        <div class="brand-section">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <h1 class="brand-title">Smart-Catalog V2</h1>
                        <span class="brand-subtitle">Platform UMKM Terdistribusi</span>
                    </td>
                    <td style="text-align: right; vertical-align: bottom;">
                        <span style="font-size: 16px; font-weight: bold; color: #10b981; text-transform: uppercase; letter-spacing: 1px;">Slip Transaksi</span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Meta Section (Informasi Invoice) -->
        <table class="meta-table">
            <tr>
                <td>
                    <div class="meta-label">ID Transaksi Resmi</div>
                    <div class="meta-value" style="font-family: monospace;">{{ $transaction->nomor_transaksi }}</div>
                    
                    <div class="meta-label" style="margin-top: 15px;">Dikeluarkan Oleh</div>
                    <div class="meta-value">Merchant Kemitraan (Sales: {{ $transaction->merchant_code }})</div>
                </td>
                <td style="text-align: right;">
                    <div class="meta-label">Tanggal Cetak</div>
                    <div class="meta-value">{{ $transaction->created_at->format('d F Y') }}</div>
                    
                    <div class="meta-label" style="margin-top: 15px;">Jam Operasional</div>
                    <div class="meta-value">{{ $transaction->created_at->format('H:i:s') }} WIB</div>
                </td>
            </tr>
        </table>

        <!-- Tabel Ringkasan Varian -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Detail Komoditas</th>
                    <th>Klasifikasi Kategori</th>
                    <th style="text-align: right;">Harga Satuan</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: bold; color: #0f172a;">
                        {{ $transaction->product ? $transaction->product->nama_produk : 'Produk Terhapus dari Katalog' }}
                    </td>
                    <td>
                        {{ ($transaction->product && $transaction->product->category) ? $transaction->product->category->nama_kategori : 'Kategori Umum' }}
                    </td>
                    <td style="text-align: right;">
                        Rp {{ number_format($transaction->product ? $transaction->product->harga : 0) }}
                    </td>
                    <td style="text-align: center; font-weight: bold;">
                        {{ $transaction->qty }} Unit
                    </td>
                    <td style="text-align: right; font-weight: bold; color: #10b981;">
                        Rp {{ number_format(($transaction->product ? $transaction->product->harga : 0) * $transaction->qty) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Ringkasan Total Tagihan -->
        <div class="total-box">
            <div class="total-label">Nilai Tagihan Akhir Terverifikasi</div>
            <div class="total-val">
                Rp {{ number_format(($transaction->product ? $transaction->product->harga : 0) * $transaction->qty) }}
            </div>
        </div>

        <!-- Footer slip cetak -->
        <div class="footer-note">
            <p>Bukti slip pembayaran ini dikeluarkan secara resmi melalui sistem server Smart-Catalog V2.</p>
            <p>Terima kasih telah berkontribusi memajukan produk UMKM mitra lokal kami!</p>
        </div>
    </div>
</body>
</html>