@extends('landingpage.layouts.main')

@section('content')
<section class="py-5" style="background:#f1f5f9; min-height:100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <div class="card border-0 shadow-sm rounded-4" style="background:#ffffff;">
                    <div class="card-body p-4">

                        <h4 class="text-center fw-semibold mb-3" style="color:#6383e5;">
                            🧾 Checkout
                        </h4>
                        <hr>

                        <!-- DATA USER -->
                        <div class="mb-3 rounded-3 data-pelanggan" style="background:#f8fafc;">
                            <h6 class="mb-2" style="color:#6383e5;">Data Pelanggan</h6>
                            <p class="mb-1"><strong>Username:</strong> {{ $user->name }}</p>
                            <p class="mb-0"><strong>No HP:</strong> {{ $user->phone ?? '-' }}</p>
                        </div>

                        <!-- TABLE -->
                        <div class="table-responsive mb-4">
                            <table class="table align-middle text-center">
                                <thead style="background:#f1f5f9;">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($keranjangs as $item)
                                    <tr>
                                        <td class="text-start">
                                            <div class="d-flex align-items-center gap-2">
                                                @php
                                                    $gambar = $item->produk->gambar
                                                        ? asset('storage/' . $item->produk->gambar)
                                                        : asset('images/no-image.png');
                                                @endphp

                                                <img src="{{ $gambar }}"
                                                    width="50"
                                                    height="50"
                                                    style="object-fit:cover; border-radius:6px; border:1px solid #ddd;">

                                                <span>{{ $item->produk->nama_produk }}</span>
                                            </div>
                                        </td>

                                        <td>{{ $item->jumlah }}</td>

                                        <td>
                                            Rp {{ number_format($item->harga,0,',','.') }}
                                        </td>

                                        <td class="fw-semibold" style="color:#6383e5;">
                                            Rp {{ number_format($item->jumlah * $item->harga,0,',','.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- FORM -->
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf

                            @foreach(request('selected_items') as $id)
                                <input type="hidden" name="selected_items[]" value="{{ $id }}">
                            @endforeach

                            <!-- ALAMAT -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Alamat Pengiriman
                                </label>

                                <textarea
                                    name="alamat_pengiriman"
                                    class="form-control border-0 shadow-sm"
                                    style="background:#f8fafc;"
                                    required
                                    placeholder="Masukkan alamat lengkap..."></textarea>
                            </div>

                            <!-- INFO -->
                            <div class="alert border-0 rounded-3 mb-4"
                                style="background:#eef4ff; color:#6383e5; font-size:13px;">
                                🚚 Gratis ongkir area Pekanbaru karena pengiriman langsung dari toko.
                            </div>

                            <!-- METODE PEMBAYARAN -->
                            <div class="mb-3 metode-box">
                                <label class="form-label fw-semibold">
                                    Metode Pembayaran
                                </label>

                                <div class="d-flex gap-2">
                                    <label class="rounded-3 w-100 text-center border metode-item">
                                        <input type="radio"
                                            name="metode_pembayaran"
                                            value="cod"
                                            required>
                                        COD
                                    </label>

                                    <label class="rounded-3 w-100 text-center border metode-item">
                                        <input type="radio"
                                            name="metode_pembayaran"
                                            value="transfer"
                                            required>
                                        Transfer
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3 metode-box">
                                <label class="form-label fw-semibold">
                                    Metode Pengiriman
                                </label>

                                <div class="d-flex gap-2">

                                    <label class="rounded-3 w-100 text-center border metode-item">
                                        <input type="radio"
                                            name="metode_pengiriman"
                                            value="ditoko"
                                            required>
                                        Ambil di Toko
                                    </label>

                                    <label class="rounded-3 w-100 text-center border metode-item">
                                        <input type="radio"
                                            name="metode_pengiriman"
                                            value="delivery"
                                            required>
                                        Delivery Toko
                                    </label>

                                </div>

                                <small class="text-muted d-block mt-2">
                                    Delivery dilakukan langsung oleh pihak toko untuk area Pekanbaru.
                                </small>
                            </div>

                            <!-- TOTAL -->
                            <div class="mb-3 rounded-3 total-box" style="background:#f8fafc;">
                                <p>
                                    Belanja:
                                    <b>
                                        Rp {{ number_format($totalHargaProduk,0,',','.') }}
                                    </b>
                                </p>
                                <h5>
                                    Total Bayar:
                                    <span style="color:#6383e5;">
                                        Rp {{ number_format($totalHargaProduk,0,',','.') }}
                                    </span>
                                </h5>
                            </div>

                            <!-- BUTTON -->
                            <div class="mt-2 text-center">
                                <button type="submit"
                                    id="btnPesan"
                                    class="btn w-100"
                                    style="background-color:#6383e5; border-color:#6383e5; color:white;">
                                    Pesan Sekarang
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
    .data-pelanggan{
        padding:10px 12px !important;
    }

    .data-pelanggan h6{
        font-size:14px;
        margin-bottom:6px;
    }

    .data-pelanggan p{
        font-size:13px;
        margin-bottom:4px;
    }

    .data-pelanggan p:last-child{
        margin-bottom:0;
    }

    .metode-box{
        padding:8px !important;
        font-size:13px;
    }

    .metode-item{
        padding:10px !important;
        font-size:13px;
        cursor:pointer;
        transition:0.2s;
        background:#fff;
    }

    .metode-item:hover{
        background:#f8fafc;
        border-color:#6383e5 !important;
    }

    .total-box{
        padding:10px 12px !important;
    }

    .total-box p{
        font-size:13px;
        margin-bottom:4px;
    }

    .total-box h5{
        font-size:15px;
        margin-bottom:0;
    }

    #btnPesan{
        font-size:14px;
        padding:8px !important;
    }

    .table{
        font-size:13px;
    }

    .table th{
        font-size:13px;
        font-weight:600;
        padding:8px 6px;
    }

    .table td{
        padding:8px 6px;
    }

    .table img{
        width:40px !important;
        height:40px !important;
        border-radius:5px;
    }

    .table td span{
        font-size:13px;
    }

    .form-control,
    textarea.form-control{
        border:1.5px solid #6383e5 !important;
        border-radius:5px;
        font-size:0.875rem;
    }

    .form-control:focus,
    textarea.form-control:focus{
        border-color:#6383e5 !important;
        box-shadow:0 0 4px rgba(99,131,229,0.4);
    }

    label{
        font-weight:500;
        color:#6383e5;
    }

    input[type="radio"]{
        accent-color:#6383e5;
        margin-right:5px;
    }
</style>

<script>
    document.getElementById('btnPesan').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            text: 'Yakin ingin membuat pesanan?',
            width: 260,
            padding: '1.2em',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-3',
                htmlContainer: 'small text-dark text-center',
                actions: 'd-flex justify-content-center gap-2 mt-3',
                confirmButton: 'btn btn-sm btn-dark',
                cancelButton: 'btn btn-sm btn-outline-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest('form').submit();
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('error_checkout'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: "{{ session('error_checkout') }}",
        width: 300,
        padding: '1em',
        confirmButtonText: 'OK',
        buttonsStyling: false,
        customClass: {
            popup: 'rounded-3',
            title: 'fs-6',
            htmlContainer: 'small',
            confirmButton: 'btn btn-sm btn-danger'
        }
    });
});
</script>

@elseif(session('success_checkout'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success_checkout') }}",
        width: 300,
        padding: '1em',
        confirmButtonText: 'OK',
        buttonsStyling: false,
        customClass: {
            popup: 'rounded-3',
            title: 'fs-6',
            htmlContainer: 'small',
            confirmButton: 'btn btn-sm btn-primary'
        }
    });
});
</script>
@endif

@endsection