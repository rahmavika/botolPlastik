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
            font-size: 11px;
            margin-top: 5px;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 4px 6px;
            vertical-align: top;
        }

        th {
            background-color: #eaeaea;
            text-align: center;
            font-weight: bold;
        }

        td.text-center {
            text-align: center;
        }

        td.text-end {
            text-align: right;
        }

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

    <!-- Kop Surat -->
    <div class="kop-surat">
        <h2>Botol Plastik Riau</h2>

        <p>
            Jl. Paus, Tengkerang Tengah,
            Kec. Marpoyan Damai,
            Kota Pekanbaru, Riau
        </p>

        <p>Telp: 081371209486</p>
    </div>

    <!-- Judul -->
    <div class="judul">
        <h3>Laporan Penjualan</h3>

        <p>
            Periode:
            <strong>{{ $bulan }} {{ $tahun }}</strong>
        </p>
    </div>

    @if($message)

        <p style="
            color:red;
            text-align:center;
            font-weight:bold;
        ">
            {{ $message }}
        </p>

    @else

        @php
            $totalKeseluruhan = 0;
        @endphp

        <table>

            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="11%">Tanggal Pesan</th>
                    <th width="11%">Tanggal Selesai</th>
                    <th width="14%">Customer</th>
                    <th>Rincian Produk</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>

            <tbody>

                @foreach($checkouts as $checkout)

                @php
                    $total = $checkout->total_harga;
                    $totalKeseluruhan += $total;
                @endphp

                <tr>

                    <!-- No -->
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <!-- Tanggal Pesan -->
                    <td class="text-center">
                        {{ $checkout->tanggal_pemesanan->format('d-m-Y') }}
                    </td>

                    <!-- Tanggal Selesai -->
                    <td class="text-center">
                        {{ $checkout->updated_at->format('d-m-Y') }}
                    </td>

                    <!-- Customer -->
                    <td>
                        {{ $checkout->user->name ?? '-' }}
                    </td>

                    <!-- Produk -->
                    <td>

                        @foreach($checkout->produk_details as $produk)

                            @php
                                $namaProduk = is_array($produk)
                                    ? ($produk['nama_produk'] ?? $produk['nama'] ?? '-')
                                    : ($produk->nama_produk ?? $produk->nama ?? '-');

                                $jumlah = is_array($produk)
                                    ? ($produk['jumlah'] ?? 0)
                                    : ($produk->jumlah ?? 0);

                                $harga = is_array($produk)
                                    ? ($produk['harga'] ?? 0)
                                    : ($produk->harga ?? 0);
                            @endphp

                            {{ $namaProduk }}
                            ({{ $jumlah }} x
                            {{ number_format($harga,0,',','.') }})
                            <br>

                        @endforeach

                    </td>

                    <!-- Total -->
                    <td class="text-end">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </td>

                </tr>

                @endforeach

            </tbody>

            <!-- Footer Total -->
            <tfoot>
                <tr>
                    <td colspan="5" class="text-end">
                        <strong>Total Keseluruhan</strong>
                    </td>

                    <td>
                        <strong>
                            Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}
                        </strong>
                    </td>
                </tr>
            </tfoot>

        </table>

    @endif

    <!-- Tanda Tangan -->
    <div class="footer">

        <div class="ttd">

            <p>
                Riau,
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </p>

            <p>Pimpinan</p>

            <br><br><br>

            <p>
                <strong>____________________</strong>
            </p>

        </div>

    </div>

</div>

</body>
</html>