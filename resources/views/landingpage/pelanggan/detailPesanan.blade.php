@extends('landingpage.layouts.main')

@section('content')
<section class="mt-5">
    <div class="container" style="max-width: 900px;">

        {{-- BUTTON --}}
        <div class="mb-3 text-end no-print">
            <button onclick="window.print()" class="btn btn-blue btn-sm">
                🖨 Cetak Invoice
            </button>
        </div>

        <div id="invoiceArea" class="invoice-box">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <h3 class="logo-text mb-1">Botol Plastik Riau</h3>
                    <small class="text-muted d-block">
                        Jl. Paus, Tangkerang Tengah<br>
                        Pekanbaru, Riau 28282<br>
                        Telp: 081371209486
                    </small>
                </div>
                <div class="text-end">
                    <h5 class="fw-bold mb-1">INVOICE</h5>
                    <small class="text-muted">
                        No: {{ $checkout->id }} <br>
                        {{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d M Y') }}
                    </small>
                </div>
            </div>

            <hr>

            {{-- CUSTOMER --}}
            <div class="mb-4">
                <h6 class="section-title">Data Pelanggan</h6>
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th>Nama</th>
                        <td>{{ $checkout->user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $checkout->user->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $checkout->alamat_pengiriman }}</td>
                    </tr>
                </table>
            </div>

            {{-- PRODUK --}}
            <div class="mb-4">
                <h6 class="section-title">Detail Pesanan</h6>
                <table class="table table-bordered align-middle small">
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
                            <td>{{ $produk['nama'] }}</td>
                            <td class="text-center">{{ $produk['jumlah'] }}</td>
                            <td class="text-end">Rp {{ number_format($produk['harga'], 0, ',', '.') }}</td>
                            <td class="text-end fw-semibold">Rp {{ number_format($produk['total'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach

                        <tr class="ongkir-row">
                            <td colspan="3" class="text-end">
                                Ongkir
                                @if($checkout->courier)
                                    ({{ strtoupper($checkout->courier) }} - {{ $checkout->service ?? '-' }})
                                @endif
                            </td>
                            <td class="text-end">
                                Rp {{ number_format($checkout->ongkir ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- TOTAL --}}
            <div class="total-box ms-auto mb-4">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th>Subtotal</th>
                        <td class="text-end">
                            Rp {{ number_format($totalHargaAkhir, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Ongkir</th>
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
            @if(strtolower($checkout->metode_pembayaran) === 'transfer')
            <tr>
                <td colspan="2">
                    <div class="rekening-box">
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
                </td>
            </tr>
            @endif

            {{-- PENGIRIMAN --}}
            <div class="shipping-box mb-4">
                <h6 class="section-title">Pengiriman & Pembayaran</h6>

                <table class="table table-borderless table-sm mb-0">
                    {{-- STATUS PESANAN --}}
                    <tr>
                        <th style="width: 30%">Status Pesanan</th>
                        <td>
                            <span class="badge-status">
                                {{ ucfirst(str_replace('_',' ', $checkout->status)) }}
                            </span>
                        </td>
                    </tr>

                    {{-- STATUS PEMBAYARAN --}}
                    <tr>
                        <th>Status Pembayaran</th>
                        <td>
                            <span class="badge-bayar">
                                {{ ucfirst($checkout->status_pembayaran ?? 'belum dibayar') }}
                            </span>
                        </td>
                    </tr>

                    {{-- METODE PEMBAYARAN --}}
                    <tr>
                        <th>Metode Pembayaran</th>
                        <td>{{ ucfirst($checkout->metode_pembayaran) }}</td>
                    </tr>

                    {{-- KURIR --}}
                    @if($checkout->courier)
                    <tr>
                        <th>Kurir</th>
                        <td>{{ strtoupper($checkout->courier) }} - {{ $checkout->service }}</td>
                    </tr>
                    @endif

                    {{-- ONGKIR --}}
                    @if($checkout->ongkir)
                    <tr>
                        <th>Ongkir</th>
                        <td>Rp {{ number_format($checkout->ongkir,0,',','.') }}</td>
                    </tr>
                    @endif

                    {{-- RESI --}}
                    @if($checkout->no_resi)
                    <tr>
                        <th>No Resi</th>
                        <td><b>{{ $checkout->no_resi }}</b></td>
                    </tr>

                    <tr>
                        <th>Dikirim</th>
                        <td>{{ \Carbon\Carbon::parse($checkout->tanggal_kirim)->format('d M Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
            {{-- FOOTER --}}
            <p class="text-center mt-4 fw-bold small mb-0">
                Terima kasih atas kepercayaan Anda
            </p>

        </div>
    </div>
</section>

<style>
.rekening-box {
    background: #eef2ff;
    border: 1px dashed #1a42c8;
    border-radius: 10px;
    padding: 12px;
}

.rekening-title {
    font-size: 12px;
    font-weight: 600;
    color: #1a42c8;
    margin-bottom: 8px;
}

.rekening-item {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    margin-bottom: 4px;
}

.rekening-item span {
    color: #6b7280;
}

.rekening-item strong {
    color: #111827;
    letter-spacing: 0.5px;
}

    .badge-bayar {
    background: #16a34a; /* hijau */
    color: #fff;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
}
.shipping-box table th {
    font-weight: 600;
    color: #374151;
}

.shipping-box table td {
    color: #111827;
}


.logo-text {
    font-weight: 700;
    font-size: 1.8rem;
    color: #1a42c8;
}

.invoice-box {
    border: 1px solid #e5e7eb;
    background: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    padding: 30px;
    border-radius: 12px;
}

.section-title {
    font-weight: 600;
    margin-bottom: 10px;
    color: #1a42c8;
}

.table th {
    background-color: #f8fafc;
    font-weight: 600;
}

.table td, .table th {
    padding: 10px !important;
}

.ongkir-row td {
    background: #f1f5f9;
    font-weight: 600;
}

.total-box {
    width: 45%;
    background: #f8fafc;
    border-radius: 10px;
    padding: 12px;
}

.grand-total {
    font-size: 15px;
    font-weight: 700;
    color: #1a42c8;
}

.shipping-box {
    background: #f8fafc;
    padding: 12px;
    border-radius: 10px;
}

.payment-box {
    background: #eef2ff;
    padding: 12px;
    border-radius: 10px;
    font-size: 13px;
}

.badge-status {
    background: #1a42c8;
    color: #fff;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
}

.btn-blue {
    background-color: #1a42c8;
    color: #fff;
}

@media print {
    body * { visibility: hidden; }
    #invoiceArea, #invoiceArea * { visibility: visible; }
    #invoiceArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .no-print { display: none !important; }
}
</style>
@endsection