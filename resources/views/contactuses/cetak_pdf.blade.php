<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pertanyaan Pengguna</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: #000;
            margin: 40px;
        }

        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 25px;
        }

        .kop-surat img {
            width: 80px;
            height: 80px;
            margin-right: 15px;
        }

        .kop-surat .info {
            text-align: left;
        }

        .kop-surat .info h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        .kop-surat .info p {
            margin: 0;
            font-size: 12px;
        }

        h3.judul {
            text-align: center;
            font-size: 16px;
            text-transform: uppercase;
            margin-top: 0;
            margin-bottom: 5px;
        }

        hr.judul-line {
            width: 200px;
            border: 1px solid #000;
            margin: 5px auto 20px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }

        td.text-center {
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <div class="info">
            <h2>TB A.W. Karya Banguna</h2>
            <p>Jl. Mesjid, Sungai Pua, Kec. Sungai Pua, Kabupaten Agam, Sumatera Barat 26181</p>
            <p>Telp: (0752)691374</p>
        </div>
    </div>

    <h3 class="judul">Laporan Data Pertanyaan Pengguna</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
                <th>Status Tampil</th>
                <th>Tanggal Dikirim</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $index => $question)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $question->nama }}</td>
                    <td>{{ $question->email }}</td>
                    <td>{{ $question->pertanyaan }}</td>
                    <td>{{ $question->jawaban ?? '-' }}</td>
                    <td class="text-center">
                        {{ $question->is_published ? 'Tampil' : 'Tidak Tampil' }}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($question->created_at)->translatedFormat('d F Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </div>

</body>
</html>