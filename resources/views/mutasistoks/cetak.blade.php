<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Mutasi Stok</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .kop-surat {
            text-align: center;
        }
        .kop-surat h1 {
            font-size: 16pt;
            margin: 0;
        }
        .kop-surat p {
            margin: 2px 0;
            font-size: 11pt;
        }
        .line {
            border-top: 3px double #000;
            margin: 10px 0 20px;
        }
        .judul {
            text-align: center;
            margin-bottom: 15px;
        }
        .judul h2 {
            margin: 0;
            font-size: 14pt;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            text-align: center;
            background: #eee;
        }
        td {
            text-align: center;
        }
        td.text-left {
            text-align: left;
        }
        .footer {
            margin-top: 30px;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
        }
    </style>
</head>

<body>
<div class="container">

    {{-- KOP --}}
    <div class="kop-surat">
        <h1>Botol Plastik Riau</h1>
        <p>Jl. Paus, Tengkerang Tengah, Kec. Marpoyan Damai, Kota Pekanbaru, Riau</p>
        <p>Telp: 081371209486</p>
    </div>

    <div class="line"></div>

    {{-- JUDUL --}}
    <div class="judul">
        <h2>Laporan Mutasi Stok</h2>
        <p>{{ $periodeLabel }}</p>
    </div>

    {{-- TABEL --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Stok Awal</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Stok Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataMutasi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-left">{{ $item->nama_produk }}</td>
                <td>{{ $item->stok_awal }}</td>
                <td>{{ $item->masuk }}</td>
                <td>{{ $item->keluar }}</td>
                <td>{{ $item->stok_akhir }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        <p>Riau, {{ $tanggalCetak }}</p>
    </div>

    <div class="signature">
        <p>Mengetahui,</p>
        <p><strong>Pemilik Toko</strong></p>
        <br><br><br>
        <p>(______________________)</p>
    </div>

</div>
</body>
</html>