<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pengguna</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
            line-height: 1.5;
        }
        .container {
            width: 100%;
            max-width: 900px;
            margin: auto;
            padding: 20px;
        }
        /* Kop Surat */
        .kop-surat {
            text-align: center;
            margin-bottom: 15px;
        }
        .kop-surat img {
            width: 70px;
            height: auto;
            position: absolute;
            left: 60px;
            top: 20px;
        }
        .kop-surat h1 {
            font-size: 16pt;
            margin: 0;
            text-transform: uppercase;
        }
        .kop-surat p {
            margin: 2px 0;
            font-size: 11pt;
        }
        .line {
            border-top: 3px double #000;
            margin: 10px 0 20px 0;
        }
        .judul {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul h2 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 10px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        .footer {
            text-align: left;
            margin-top: 30px;
            font-size: 11pt;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
        }
        .signature p {
            margin: 3px 0;
        }
        @page {
            size: A4;
            margin: 20mm;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="kop-surat">
            <h1>Toko Bangunan A.W. Karya Bangunan</h1>
            <p>Jl. Mesjid, Sungai Pua, Kec. Sungai Pua, Kabupaten Agam, Sumatera Barat 26181</p>
            <p>Telp. (0761) 123456 | Email: info@awkaryabangunan.com</p>
        </div>
        <div class="line"></div>

        <div class="judul">
            <h2>Laporan Data Pengguna</h2>
            <p>Periode: {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:5%;">No</th>
                    <th style="width:25%;">Nama</th>
                    <th style="width:30%;">Email</th>
                    <th style="width:20%;">No HP</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Sungai Pua, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
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
