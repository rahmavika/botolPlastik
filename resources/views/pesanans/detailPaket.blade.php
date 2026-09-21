<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Label Pengiriman</title>

    <style>
        @page {
            margin: 8px;
        }

        body{
            font-family: Arial, sans-serif;
            font-size:10px;
            margin:0;
            padding:0;
            color:#000;
        }

        .label{
            border:1.5px solid #000;
            padding:8px;
        }

        .top{
            border-bottom:1.5px solid #000;
            padding-bottom:6px;
            margin-bottom:6px;
        }

        .shop-name{
            font-size:15px;
            font-weight:bold;
            text-transform:uppercase;
            line-height:1.1;
        }

        .small{
            font-size:9px;
            line-height:1.3;
        }

        .section{
            border:1px solid #000;
            margin-bottom:6px;
        }

        .section-title{
            background:#000;
            color:#fff;
            padding:4px 6px;
            font-size:9px;
            font-weight:bold;
            text-transform:uppercase;
        }

        .section-body{
            padding:6px;
        }

        .receiver-name{
            font-size:15px;
            font-weight:bold;
            text-transform:uppercase;
        }

        .phone{
            font-size:12px;
            font-weight:bold;
            margin:3px 0;
        }

        .address{
            font-size:11px;
            line-height:1.4;
        }

        .info-table{
            width:100%;
            border-collapse:collapse;
        }

        .info-table td{
            padding:4px 0;
            border-bottom:1px solid #ddd;
            font-size:10px;
        }

        .produk-table{
            width:100%;
            border-collapse:collapse;
        }

        .produk-table th,
        .produk-table td{
            border:1px solid #000;
            padding:4px;
            font-size:9px;
        }

        .produk-table th{
            background:#eee;
        }

        .text-center{
            text-align:center;
        }

        .text-end{
            text-align:right;
        }

        .big-total{
            font-size:13px;
            font-weight:bold;
        }

        .barcode-area{
            border-top:1px dashed #000;
            margin-top:8px;
            padding-top:6px;
            text-align:center;
        }

        .tracking{
            font-size:16px;
            font-weight:bold;
            letter-spacing:1px;
        }
    </style>
</head>
<body>

<div class="label">

    <!-- HEADER -->
    <div class="top">
        <table class="flex" width="100%">
            <tr>
                <td width="65%">
                    <div class="shop-name">
                        Botol Plastik Riau
                    </div>

                    <div class="small">
                        Jl. Paus, Tangkerang Tengah, Pekanbaru <br>
                        081371209486
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- PENERIMA -->
    <div class="section">
        <div class="section-title">
            Penerima
        </div>

        <div class="section-body">
            <div class="receiver-name">
                {{ $checkout->nama_pelanggan ?? $checkout->user->name ?? '-' }}
            </div>

            <div class="phone">
                {{ $checkout->phone
                    ?? $checkout->no_hp
                    ?? $checkout->user->phone
                    ?? '-' }}
            </div>

            <div class="address">
                {{ $checkout->alamat_pengiriman }}
            </div>
        </div>
    </div>

    <!-- INFORMASI -->
    <div class="section">
        <div class="section-title">
            Informasi Pengiriman
        </div>

        <div class="section-body">
            <table class="info-table">
                <tr>
                    <td width="40%">Tanggal</td>
                    <td>
                        {{ \Carbon\Carbon::parse($checkout->created_at)->format('d M Y H:i') }}
                    </td>
                </tr>

                <tr>
                    <td>Pengiriman</td>
                    <td>
                        {{ $checkout->metode_pengiriman == 'ditoko'
                            ? 'Ambil di Toko'
                            : 'Delivery Toko' }}
                    </td>
                </tr>

                <tr>
                    <td>Pembayaran</td>
                    <td>
                        {{ ucfirst($checkout->metode_pembayaran) }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- PRODUK -->
    <div class="section">
        <div class="section-title">
            Isi Paket
        </div>

        <div class="section-body">

            @php
                $subtotal = 0;
                $ongkir = $checkout->ongkir ?? 0;
            @endphp

            <table class="produk-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th width="60">Qty</th>
                        <th width="110">Harga</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($produkDetails as $produk)

                    @php
                        $total = $produk['jumlah'] * $produk['harga'];
                        $subtotal += $total;
                    @endphp

                    <tr>
                        <td>{{ $produk['nama'] }}</td>

                        <td class="text-center">
                            {{ $produk['jumlah'] }}
                        </td>

                        <td class="text-end">
                            Rp {{ number_format($total,0,',','.') }}
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

            <table width="100%" style="margin-top:10px;">
                <tr>
                    <td class="big-total">
                        Total:
                    </td>

                    <td class="text-end big-total">
                        Rp {{ number_format($subtotal + $ongkir,0,',','.') }}
                    </td>
                </tr>
            </table>

        </div>
    </div>

    <!-- TRACKING STYLE -->
    <div class="barcode-area">
        <div class="tracking">
            INV{{ str_pad($checkout->id, 6, '0', STR_PAD_LEFT) }}
        </div>

        <div class="small">
            Tempel pada paket
        </div>
    </div>

</div>

</body>
</html>