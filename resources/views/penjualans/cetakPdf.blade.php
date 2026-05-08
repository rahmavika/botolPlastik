<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            margin: 0;
            color: #000;
        }
        .container {
            width: 100%;
            max-width: 1000px;
            margin: auto;
            padding: 10px 15px;
        }
        .kop-surat {
            border-bottom: 2px solid #000;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .kop-surat p {
            margin: 1px 0;
            font-size: 12px;
        }
        .judul {
            text-align: center;
            margin-bottom: 10px;
        }
        .judul h3 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .judul p {
            margin: 2px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
            margin-top: 5px;
        }
        th, td {
            border: 1px solid #555;
            padding: 4px 6px;
            vertical-align: top;
        }
        th {
            background-color: #eaeaea;
            text-align: center;
            font-weight: bold;
        }
        td.text-center { text-align: center; }
        td.text-end { text-align: right; }
        tfoot td {
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }
        .ttd {
            text-align: center;
            font-size: 12px;
        }
        .ttd p {
            margin: 2px 0;
        }
        @page {
            size: A4 portrait;
            margin: 12mm;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="kop-surat">
        <h2>Botol Plastik Riau</h2>
        <p>Jl. Paus, Tengkerang Tengah, Kec. Marpoyan Damai, Kota Pekanbaru, Riau</p>
        <p>Telp: 081371209486</p>
    </div>
    <div class="judul">
        <h3>Laporan Penjualan</h3>
        <p>Periode: <strong>{{ $bulan }} {{ $tahun }}</strong></p>
    </div>
    @if($message)
        <p style="color:red; text-align:center; font-weight:bold;">{{ $message }}</p>
    @else
        @php
            $totalProduk = 0;
            $totalOngkir = 0;
        @endphp
        <table>
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="11%">Tanggal</th>
                    <th width="14%">Customer</th>
                    <th>Rincian Produk</th>
                    <th width="12%">Subtotal</th>
                    <th width="10%">Ongkir</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkouts as $checkout)
                @php
                    $ongkir = $checkout->ongkir ?? 0;
                    $total = $checkout->total_harga;
                    $produkOnly = $total - $ongkir;
                    $totalProduk += $produkOnly;
                    $totalOngkir += $ongkir;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        {{ $checkout->tanggal_pemesanan->format('d-m-Y') }}
                    </td>
                    <td>{{ $checkout->user->name ?? '-' }}</td>
                    <td>
                        @foreach($checkout->produk_details as $produk)
                            @php
                                $namaProduk = is_array($produk) ? ($produk['nama_produk'] ?? $produk['nama'] ?? '-') : ($produk->nama_produk ?? $produk->nama ?? '-');
                                $jumlah = is_array($produk) ? ($produk['jumlah'] ?? 0) : ($produk->jumlah ?? 0);
                                $harga  = is_array($produk) ? ($produk['harga'] ?? 0)  : ($produk->harga ?? 0);
                            @endphp
                            {{ $namaProduk }} ({{ $jumlah }} x {{ number_format($harga,0,',','.') }})<br>
                        @endforeach
                    </td>
                    <td class="text-end">
                        Rp {{ number_format($produkOnly, 0, ',', '.') }}
                    </td>
                    <td class="text-end">
                        Rp {{ number_format($ongkir, 0, ',', '.') }}
                    </td>
                    <td class="text-end">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end">Subtotal Produk</td>
                    <td colspan="3">
                        Rp {{ number_format($totalProduk, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end">Total Ongkir</td>
                    <td colspan="3">
                        Rp {{ number_format($totalOngkir, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end"><strong>Total Keseluruhan</strong></td>
                    <td colspan="3">
                        <strong>
                            Rp {{ number_format($totalProduk + $totalOngkir, 0, ',', '.') }}
                        </strong>
                    </td>
                </tr>
            </tfoot>
        </table>
    @endif
    <div class="footer">
        <div class="ttd">
            <p>Riau, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Pimpinan</p>
            <br><br>
            <p><strong>____________________</strong></p>
        </div>
    </div>
</div>
</body>
</html>