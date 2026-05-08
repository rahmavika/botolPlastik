@extends('landingpage.layouts.main')
@section('content')

<section class="mt-5">
    <div class="container" style="max-width: 900px;">
        <div class="mb-3 text-end no-print">
            <button onclick="window.print()" class="btn btn-blue btn-sm">
                🖨 Cetak Invoice
            </button>
        </div>
        <div id="invoiceArea" class="invoice-box">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <h3 class="logo-text mb-1">Botol Plastik Riau</h3>
                    <small class="text-muted d-block">
                        Jl. Paus, Tangkerang Tengah, Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28282 <br>
                        Telp: 081371209486
                    </small>
                </div>
                <div class="text-end">
                    <h6 class="fw-bold mb-1">INVOICE</h6>
                    <small class="text-muted">
                        No: {{ $checkout->id }} <br>
                        {{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d M Y') }}
                    </small>
                </div>
            </div>
            <hr>
            <div class="mb-3">
                <h6 class="section-title">Data Pelanggan</h6>
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th>Nama</th>
                        <td>{{ $checkout->user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No HP</th>
                        <td>{{ $checkout->user->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $checkout->alamat_pengiriman }}</td>
                    </tr>
                </table>
            </div>
            <div class="mb-3">
                <h6 class="section-title">Detail Pesanan</h6>
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produkDetails as $produk)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @php
                                        $gambar = $produk['gambar'] ?? null;
                                        if (!$gambar && isset($produk['produk_id'])) {
                                            $p = \App\Models\Produk::find($produk['produk_id']);
                                            $gambar = $p->gambar ?? null;
                                        }
                                        $urlGambar = $gambar
                                            ? asset('storage/' . $gambar)
                                            : asset('images/no-image.png');
                                    @endphp
                                    <img src="{{ $urlGambar }}">
                                    <span>{{ $produk['nama'] }}</span>
                                </div>
                            </td>
                            <td class="text-center">{{ $produk['jumlah'] }}</td>
                            <td class="text-end">Rp {{ number_format($produk['harga'], 0, ',', '.') }}</td>
                            <td class="text-end fw-semibold">Rp {{ number_format($produk['total'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="total-box ms-auto mb-3">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th>Subtotal</th>
                        <td class="text-end">
                            Rp {{ number_format($totalHargaAkhir, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Ongkir
                            @if($checkout->courier)
                                ({{ strtoupper($checkout->courier) }} - {{ $checkout->service }})
                            @endif
                        </th>
                        <td class="text-end">
                            Rp {{ number_format($checkout->ongkir ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="table-light">
                        <th class="grand-total">Total Bayar</th>
                        <td class="text-end grand-total">
                            Rp {{ number_format(($totalHargaAkhir + ($checkout->ongkir ?? 0)), 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="shipping-box">
                <h6 class="section-title">Pengiriman & Pembayaran</h6>
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th>Status Pesanan</th>
                        <td>
                            <span class="badge-status">
                                {{ ucfirst(str_replace('_',' ', $checkout->status)) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Status Pembayaran</th>
                        <td>
                            <span class="badge-bayar">
                                {{ ucfirst($checkout->status_pembayaran) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Metode</th>
                        <td>{{ ucfirst($checkout->metode_pembayaran) }}</td>
                    </tr>
                    <tr>
                        <th>Kurir</th>
                        <td>{{ strtoupper($checkout->courier) }} - {{ $checkout->service }}</td>
                    </tr>
                    @if(in_array(strtolower($checkout->status), ['dikirim','shipped']) && $checkout->no_resi)
                    <tr>
                        <th>No Resi</th>
                        <td>
                            <span class="badge-status">
                                {{ $checkout->no_resi }}
                            </span>
                        </td>
                    </tr>
                    @endif

                </table>
            </div>
            @if(strtolower($checkout->metode_pembayaran) === 'transfer')
            <div class="rekening-box mb-3">
                <div class="rekening-title">Transfer ke Rekening</div>
                <div class="rekening-item">
                    <span>Bank</span>
                    <strong>Mandiri</strong>
                </div>
                <div class="rekening-item">
                    <span>No Rekening</span>
                    <strong>1120290091890</strong>
                </div>
            </div>
            @endif

            <p class="text-center mt-3 small">
                Terima kasih atas kepercayaan Anda
            </p>

        </div>
    </div>
</section>

<style>
    .invoice-box {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 20px;
        font-size: 12px;
    }
    .logo-text {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a42c8;
    }
    .section-title {
        font-size: 13px;
        font-weight: 600;
        color: #1a42c8;
    }
    .table th {
        font-size: 12px;
        background: #f8fafc;
    }
    .table td, .table th {
        padding: 6px !important;
    }
    .table img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 5px;
        border: 1px solid #ddd;
    }
    .total-box {
        width: 40%;
        background: #f8fafc;
        padding: 8px;
        border-radius: 8px;
    }
    .grand-total {
        font-weight: 700;
        color: #1a42c8;
    }
    .rekening-box {
        background: #eef2ff;
        border: 1px dashed #1a42c8;
        padding: 8px;
        border-radius: 8px;
    }
    .rekening-title {
        font-size: 11px;
        font-weight: 600;
        color: #1a42c8;
    }
    .rekening-item {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
    }
    .shipping-box {
        background: #f8fafc;
        padding: 8px;
        border-radius: 8px;
    }
    .badge-status {
        background: #1a42c8;
        color: #fff;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 10px;
    }
    .badge-bayar {
        background: #16a34a;
        color: #fff;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 10px;
    }
    .btn-blue {
        background: #1a42c8;
        color: #fff;
        font-size: 12px;
        padding: 4px 10px;
    }
    @media print {
        body * { visibility: hidden; }
        #invoiceArea, #invoiceArea * { visibility: visible; }
        #invoiceArea {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }
        .no-print { display: none; }
    }
</style>

@endsection