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
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h3 class="logo-text m-0">Botol Plastik Riau</h3>
                    <small class="text-muted">
                        Jl. Paus, Tangkerang Tengah, Kec. Marpoyan Damai,<br>
                        Kota Pekanbaru, Riau 28282<br>
                        Telp: 081371209486
                    </small>
                </div>
                <div class="text-end">
                    <h5 class="fw-bold m-0">INVOICE</h5>
                    <small class="text-muted">
                        No: {{ $checkout->id }} <br>
                        Tanggal: {{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d F Y') }}
                    </small>
                </div>
            </div>

            <hr>

            {{-- DATA CUSTOMER --}}
            <table class="table table-borderless small mb-4">
                <tr>
                    <th style="width: 25%">Nama</th>
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

            {{-- TABEL PRODUK --}}
            <table class="table table-bordered small align-middle">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th class="text-center" style="width: 12%">Jumlah</th>
                        <th class="text-end" style="width: 15%">Harga</th>
                        <th class="text-end" style="width: 15%">Total</th>
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

                    {{-- ONGKIR --}}
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

            {{-- TOTAL --}}
            <div class="ms-auto total-box" style="width: 40%;">
                <table class="table table-sm table-borderless small mb-0">
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
                                ({{ strtoupper($checkout->courier) }} - {{ $checkout->service ?? '-' }})
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

            {{-- METODE PEMBAYARAN --}}
            @if(strtolower($checkout->metode_pembayaran) === 'transfer')
            <div class="border rounded p-3 small mt-3 bg-light">
                <strong>Pembayaran Transfer:</strong><br>
                Bank Mandiri <br>
                No Rekening: <strong>1120290091890</strong>
            </div>
            @endif
            {{-- CATATAN --}}
            <div class="small mt-4 text-muted">
                <strong>Catatan:</strong>
                <ul class="mb-4">
                    @if ($checkout->metode_pembayaran === 'transfer')
                        <li>Pesanan diproses setelah pembayaran terkonfirmasi.</li>
                    @endif
                    <li>Pastikan pembayaran sesuai total.</li>
                    <li>Simpan bukti pembayaran.</li>
                </ul>

                <div class="d-flex justify-content-between mt-5">
                    <div class="text-center">
                        <p>Penerima</p>
                        <br><br>
                        <p>_________________</p>
                    </div>
                    <div class="text-center">
                        <p>Hormat Kami</p>
                        <br><br>
                        <p>_________________</p>
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            <p class="text-center mt-4 fw-bold small mb-0">
                Terima kasih atas kepercayaan Anda berbelanja di Botol Plastik Riau.
            </p>
            <p class="text-center fst-italic text-muted small">
                Kami berkomitmen memberikan pelayanan terbaik untuk Anda.
            </p>

        </div>
    </div>
</section>

<style>
.logo-text {
    font-weight: 700;
    font-size: 2rem;
    color: #1a42c8;
}

.invoice-box {
    border: 1px solid #e5e7eb;
    background: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    padding: 25px;
    border-radius: 12px;
}

hr {
    border-top: 2px solid #1a42c8;
}

.table th {
    background-color: #f8fafc;
    font-weight: 600;
}

.table td, .table th {
    padding: 12px !important;
}

.table tbody tr:hover {
    background-color: #f9fafb;
}

.ongkir-row td {
    background: #f8fafc;
    font-weight: 600;
}

.total-box {
    background: #f8fafc;
    border-radius: 10px;
    padding: 12px 15px;
}

.grand-total {
    font-size: 15px;
    font-weight: 700;
    color: #1a42c8;
}

.btn-blue {
    background-color: #1a42c8;
    border-color: #1a42c8;
    color: #fff;
}

.btn-blue:hover {
    background-color: #1635a3;
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