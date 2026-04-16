@extends('landingpage.layouts.main')

@section('content')
<section class="vh-80 mt-5">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-10 col-lg-8 mb-4">
                <div class="card shadow-lg rounded" style="border: none;">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4 class="mt-1 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #0B773D; font-size: 1rem;">Checkout</h4>

                            <hr style="border-top: 2px solid #0B773D; margin-bottom: 20px;">
                            <div class="mb-3">
                                <h5 class="font-weight-bold" style="font-size: 0.975rem;">Data Pelanggan</h5>
                                <p style="padding-left: 20px; font-size: 0.875rem;" class="mb-1"><strong>Username:</strong> {{ $user->name }}</p>
                                <p style="padding-left: 20px; font-size: 0.875rem;" class="mb-1"><strong>Nomor HP:</strong> {{ $user->phone ?? 'Nomor HP tidak tersedia' }}</p>
                            </div>

                            <hr style="border-top: 2px solid #0B773D; margin-bottom: 20px;">
                            <div class="mb-3">
                                <h5 class="font-weight-bold" style="font-size: 0.975rem;">Data Produk</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="font-size: 0.875rem;">Produk</th>
                                            <th class="text-center" style="font-size: 0.875rem;">Jumlah</th>
                                            <th class="text-center" style="font-size: 0.875rem;">Harga</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($keranjangs as $keranjang)
                                        <tr>
                                            <td class="text-center" style="font-size: 0.875rem;">{{ $keranjang->produk->nama_produk }}</td>
                                            <td class="text-center" style="font-size: 0.875rem;">{{ $keranjang->jumlah }}</td>
                                            <td class="text-center" style="font-size: 0.875rem;">Rp {{ number_format($keranjang->harga, 2, ',', '.') }}</td>
                                            <td class="text-center" style="font-size: 0.875rem;">Rp {{ number_format($keranjang->jumlah * $keranjang->harga, 2, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-weight-bold" style="font-size: 0.975rem;">Tanggal Pemesanan</h5>
                                <input
                                    type="date"
                                    name="tanggal_pemesanan"
                                    class="form-control"
                                    value="{{ old('tanggal_pemesanan', date('Y-m-d')) }}"
                                    required
                                >
                            </div>

                            <hr style="border-top: 2px solid #0B773D; margin-bottom: 20px;">

                            <form action="{{ route('checkout.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <h5 class="font-weight-bold" style="font-size: 0.975rem;">Alamat Pengiriman</h5>
                                    <textarea name="alamat_pengiriman" class="form-control" rows="3" placeholder="Masukkan alamat lengkap Anda" required>{{ old('alamat_pengiriman') }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <h5 class="font-weight-bold" style="font-size: 0.975rem;">Metode Pembayaran</h5>

                                    <div class="form-check">
                                        <input
                                            class="form-check-input custom-radio"
                                            type="radio"
                                            name="metode_pembayaran"
                                            value="cod"
                                            id="metode_cod"
                                            {{ old('metode_pembayaran') == 'cod' ? 'checked' : '' }}
                                            required
                                        >
                                        <label class="form-check-label" for="metode_cod" style="font-size: 0.875rem;">
                                            Bayar di Tempat (COD)
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input
                                            class="form-check-input custom-radio"
                                            type="radio"
                                            name="metode_pembayaran"
                                            value="transfer"
                                            id="metode_transfer"
                                            {{ old('metode_pembayaran') == 'transfer' ? 'checked' : '' }}
                                            required
                                        >
                                        <label class="form-check-label" for="metode_transfer" style="font-size: 0.875rem;">
                                            Transfer Bank
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h6>Belanja: <span style="color: #0B773D; font-size: 0.85rem;">Rp {{ number_format($totalHargaProduk, 0, ',', '.') }}</span></h6>
                                    <input type="hidden" name="total_harga" value="{{ $totalHargaProduk }}">
                                </div>
                                <div class="form-group" style="border-top: 1px solid #ddd; padding-top: 10px;">
                                    <h5 style="color: #0B773D; font-weight: bold;">Total Pembayaran:
                                        <span id="totalPembayaran" style="color: #0B773D;">
                                            Rp {{ number_format($totalHargaProduk, 0, ',', '.') }}
                                        </span>
                                    </h5>
                                </div>

                                <div class="mt-3 text-center">
                                    <button type="submit" class="btn w-100 py-2" style="background-color: #0B773D; border-color: #0B773D; color: white;"
                                        onclick="return confirm('Apakah Anda yakin ingin membuat pesanan?')">Pesan Sekarang</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .table-bordered {
        border: 1.5px solid #dee2e6 !important;
    }
    .table-bordered th, .table-bordered td {
        border: 1.5px solid #dee2e6 !important;
    }
    .table-bordered th {
        background-color: #f8f9fa;
        color: #0B773D;
    }
    .table-bordered td {
        background-color: #fff;
    }
    .form-control,
    textarea.form-control,
    select.form-select {
        border: 1.5px solid #0B773D !important;
        border-radius: 5px;
        box-shadow: none;
        font-size: 0.875rem;
    }

    .form-control:focus,
    textarea.form-control:focus,
    select.form-select:focus {
        border-color: #0B773D !important;
        box-shadow: 0 0 4px rgba(11, 119, 61, 0.5);
    }

    label {
        font-weight: 500;
        color: #0B773D;
    }

    .custom-radio {
        width: 18px;
        height: 18px;
        border: 1.5px solid #0B773D;
        accent-color: #0B773D;
        cursor: pointer;
    }
    .custom-radio:focus {
        outline: 1.5px solid #0B773D;
        outline-offset: 2px;
    }
</style>

@endsection
