@extends('layouts.main')
@section('title', 'Detail Penjualan')

@section('content')
<div class="card">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">Detail Penjualan</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-sm">
                    <tbody>
                        <tr>
                            <th>Tanggal Pemesanan</th>
                            <td>{{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>User ID</th>
                            <td>{{ $checkout->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Total Pembayaran</th>
                            <td>Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi Pengiriman</th>
                            <td>{{ $checkout->alamat_pengiriman }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <h5>Produk Details</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $details = $checkout->produk_details;
                            $total = 0;
                        @endphp
                        @foreach ($details as $index => $detail)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $detail['nama'] }}</td>
                                <td class="text-center">{{ $detail['jumlah'] }}</td>
                                <td class="text-end">Rp {{ number_format($detail['harga'], 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($detail['jumlah'] * $detail['harga'], 0, ',', '.') }}</td>
                                @php
                                    $total += $detail['jumlah'] * $detail['harga'];
                                @endphp
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Belanja</th>
                            <th class="text-end">Rp {{ number_format($total, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
