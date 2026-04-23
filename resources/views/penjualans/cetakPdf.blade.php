<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            color: #000;
        }
        .container {
            width: 100%;
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat img {
            width: 90px;
            height: auto;
            margin-right: 15px;
        }
        .kop-surat .info {
            text-align: left;
        }
        .kop-surat .info h2 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
        .kop-surat .info p {
            margin: 2px 0;
            font-size: 14px;
        }
        .judul {
            text-align: center;
            margin-bottom: 15px;
        }
        .judul h3 {
            margin: 0;
            text-transform: uppercase;
            font-size: 18px;
            font-weight: bold;
        }
        .judul p {
            margin: 3px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        tfoot td {
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            text-align: center;
        }
        .ttd {
            margin-left: 50px;
            text-align: center;
        }
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="kop-surat">
            <div class="info">
                <h2>A.W. Karya Bangunan</h2>
                <p>Jl. Mesjid, Sungai Pua, Kec. Sungai Pua, Kabupaten Agam, Sumatera Barat 26181</p>
                <p>Telp: (0752) 691374</p>
            </div>
        </div>
        <div class="judul">
            <h3>Laporan Penjualan</h3>
            <p>Periode: <strong>{{ $bulan }} {{ $tahun }}</strong></p>
        </div>
        @if($message)
            <p style="color: red; font-weight: bold; text-align: center;">{{ $message }}</p>
        @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Nama Customer</th>
                    <th>Rincian Produk</th>
                    <th>Total Harga</th>
                    <th>Alamat Pengiriman</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkouts as $checkout)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $checkout->tanggal_pemesanan->format('d-m-Y') }}</td>
                    <td>{{ $checkout->user->name ?? '-' }}</td>
                    <td>
                        @foreach($checkout->produk_details as $produk)
                            @php
                                $namaProduk = is_array($produk) ? ($produk['nama_produk'] ?? $produk['nama'] ?? '-')
                                                                : ($produk->nama_produk ?? $produk->nama ?? '-');
                                $jumlah = is_array($produk) ? ($produk['jumlah'] ?? 0) : ($produk->jumlah ?? 0);
                                $harga  = is_array($produk) ? ($produk['harga'] ?? 0)  : ($produk->harga ?? 0);
                            @endphp
                            {{ $namaProduk }} ({{ $jumlah }} x Rp {{ number_format($harga, 0, ',', '.') }})<br>
                        @endforeach
                    </td>
                    <td class="text-end">Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $checkout->alamat_pengiriman }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right;">Total Penjualan:</td>
                    <td colspan="2">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
        @endif
        <div class="footer">
            <div class="ttd">
                <p>Sungai Pua, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p>Pimpinan</p>
                <br><br><br>
                <p><strong>________________________</strong></p>
            </div>
        </div>

    </div>
</body>
</html>
