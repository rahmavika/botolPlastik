@extends('layouts.main')
@section('title', 'Data Pesanan')
@section('navAdm', 'active')

@section('content')

<div class="pb-2 mb-3 border-bottom text-center">
    <h6 class="fw-bold mb-0" style="font-size:18px;">
        Kelola Pesanan
    </h6>
</div>

<div class="container-fluid mt-3">

    <div class="card card-custom">

        @php
            $statusBadge = [
                'menunggu_konfirmasi' => 'badge bg-secondary',
                'diproses' => 'badge bg-warning text-dark',
                'dikirim' => 'badge bg-info text-white',
                'selesai' => 'badge bg-success text-white',
            ];

            $paymentBadge = [
                'belum_lunas' => 'badge bg-danger',
                'lunas' => 'badge bg-success',
            ];

            $currentStatus = request('status', 'menunggu_konfirmasi');

            $statusLabels = [
                'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                'diproses' => 'Diproses',
                'dikirim' => 'Dikirim',
                'selesai' => 'Selesai',
            ];
        @endphp

        <ul class="nav nav-tabs px-3 pt-2">
            @foreach ($statusLabels as $key => $label)
                <li class="nav-item">
                    <a href="{{ url()->current() }}?status={{ $key }}"
                        class="nav-link {{ $currentStatus == $key ? 'active' : '' }}">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="card-header">
            <h6 class="mb-0 fw-semibold">
                Pesanan {{ $statusLabels[$currentStatus] ?? '' }}
            </h6>
        </div>

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr class="text-center">
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Detail</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Pengiriman</th>
                            <th>Bukti</th>
                            <th>Status Bayar</th>
                            <th>Ubah Bayar</th>
                            <th>Aksi</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $hasAny = false; @endphp

                        @foreach ($checkouts as $checkout)
                            @if ($checkout->status == $currentStatus)

                                @php $hasAny = true; @endphp

                                <tr>

                                    <td style="max-width:200px;">
                                        {{ $checkout->nama_pelanggan ?? $checkout->user->name ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $checkout->phone
                                            ?? $checkout->no_hp
                                            ?? $checkout->user->phone
                                            ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($checkout->created_at)->format('d M Y') }}
                                        <br>

                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($checkout->created_at)->format('H:i') }}
                                        </small>
                                    </td>

                                    <td class="text-center align-middle">

                                        <div class="d-flex justify-content-center">

                                            <button type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $checkout->id }}"
                                                style="
                                                    width:30px;
                                                    height:30px;
                                                    border:1px solid #5a6ff0;
                                                    border-radius:4px;
                                                    background:#fff;
                                                    color:#5a6ff0;
                                                    display:flex;
                                                    align-items:center;
                                                    justify-content:center;
                                                    padding:0;
                                                ">

                                                <i class="bi bi-eye"
                                                    style="
                                                        font-size:16px;
                                                        line-height:1;
                                                    ">
                                                </i>

                                            </button>

                                        </div>

                                    </td>

                                    <td class="text-end">
                                        Rp {{ number_format($checkout->total_harga,0,',','.') }}
                                    </td>

                                    <td class="text-center">
                                        {{ ucwords(str_replace('_',' ',$checkout->metode_pembayaran)) }}
                                    </td>

                                    <td class="text-center">

                                        @if($checkout->metode_pengiriman == 'ditoko')

                                            <span class="badge bg-secondary">
                                                Ambil di Toko
                                            </span>

                                        @else

                                            <span class="badge bg-info text-white">
                                                Delivery Toko
                                            </span>

                                        @endif

                                    </td>

                                    <td class="text-center">

                                        @if ($checkout->bukti_transfer)

                                            <img src="{{ asset($checkout->bukti_transfer) }}"
                                                width="70"
                                                class="img-thumbnail"
                                                style="cursor:pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal{{ $checkout->id }}">

                                        @else

                                            <small class="text-muted">-</small>

                                        @endif

                                    </td>

                                    <td class="text-center">

                                        <span class="{{ $paymentBadge[$checkout->status_pembayaran] }}">
                                            {{ ucfirst($checkout->status_pembayaran) }}
                                        </span>

                                    </td>

                                    <td>

                                        <form action="{{ route('checkouts.updatePembayaran',$checkout->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('PUT')

                                            <select name="status_pembayaran"
                                                class="form-select form-select-sm"
                                                onchange="this.form.submit()">

                                                <option value="belum_lunas"
                                                    {{ $checkout->status_pembayaran=='belum_lunas'?'selected':'' }}>
                                                    Belum
                                                </option>

                                                <option value="lunas"
                                                    {{ $checkout->status_pembayaran=='lunas'?'selected':'' }}>
                                                    Lunas
                                                </option>

                                            </select>

                                        </form>

                                    </td>

                                    <td class="text-center">

                                        <form action="{{ route('checkouts.updateStatus',$checkout->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('PUT')

                                            @if($checkout->status == 'menunggu_konfirmasi')

                                                @if($checkout->metode_pembayaran == 'cod')

                                                    <button type="submit"
                                                        name="status"
                                                        value="diproses"
                                                        class="btn btn-sm btn-outline-warning"
                                                        onclick="return confirm('Apakah Anda yakin ingin mengubah status dan mengirim WhatsApp ke customer?')">

                                                        Proses

                                                    </button>

                                                    <small class="d-block text-info">
                                                        COD
                                                    </small>

                                                @else

                                                    @if($checkout->status_pembayaran == 'lunas')

                                                        <button type="submit"
                                                            name="status"
                                                            value="diproses"
                                                            class="btn btn-sm btn-outline-warning"
                                                            onclick="return confirm('Apakah Anda yakin ingin mengubah status dan mengirim WhatsApp ke customer?')">

                                                            Proses

                                                        </button>

                                                    @else

                                                        <button class="btn btn-sm btn-secondary"
                                                            disabled>

                                                            Menunggu Bayar

                                                        </button>

                                                        <small class="d-block text-danger">
                                                            Belum diverifikasi
                                                        </small>

                                                    @endif

                                                @endif

                                            @elseif($checkout->status == 'diproses')

                                                @if($checkout->metode_pengiriman == 'delivery')

                                                    <button type="submit"
                                                        name="status"
                                                        value="dikirim"
                                                        class="btn btn-sm btn-outline-primary"
                                                        onclick="return confirm('Apakah Anda yakin ingin mengubah status dan mengirim WhatsApp ke customer?')">

                                                        Kirim

                                                    </button>

                                                @else

                                                    <button type="submit"
                                                        name="status"
                                                        value="selesai"
                                                        class="btn btn-sm btn-outline-success"
                                                        onclick="return confirm('Apakah Anda yakin ingin mengubah status dan mengirim WhatsApp ke customer?')">

                                                        Selesai

                                                    </button>

                                                @endif

                                            @elseif($checkout->status == 'dikirim')

                                                <button type="submit"
                                                    name="status"
                                                    value="selesai"
                                                    class="btn btn-sm btn-outline-success"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengubah status dan mengirim WhatsApp ke customer?')">

                                                    Selesai

                                                </button>

                                            @endif

                                        </form>

                                    </td>

                                    <td class="text-center">

                                        <span class="{{ $statusBadge[$checkout->status] }}">
                                            {{ ucfirst(str_replace('_',' ', $checkout->status)) }}
                                        </span>

                                    </td>

                                </tr>

                                <div class="modal fade" id="detailModal{{ $checkout->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-md modal-dialog-centered">
                                        <div class="modal-content border-0 shadow"
                                            style="border-radius:20px; overflow:hidden;">

                                            <!-- Header -->
                                            <div class="modal-header border-0 px-4 py-3"
                                                style="background: linear-gradient(90deg, #3f5fbf, #4f8df7);">

                                                <h5 class="modal-title text-white fw-semibold mb-0"
                                                    style="font-size:17px;">
                                                    <i class="bi bi-receipt-cutoff me-2"></i>
                                                    Detail Pesanan
                                                </h5>

                                                <button type="button"
                                                    class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Body -->
                                            <div class="modal-body px-4 py-4"
                                                style="background:#f8faff;">

                                                @php
                                                    $details = $checkout->produk_details;
                                                    $subtotal = 0;
                                                    $ongkir = $checkout->ongkir ?? 0;
                                                @endphp

                                                <!-- Customer -->
                                                <div class="p-3 mb-4"
                                                    style="
                                                        background:white;
                                                        border-radius:16px;
                                                        box-shadow:0 2px 10px rgba(0,0,0,0.04);
                                                    ">

                                                    <div class="mb-3">
                                                        <small class="text-muted d-block mb-1">
                                                            Nama Pelanggan
                                                        </small>

                                                        <div class="fw-semibold">
                                                            {{ $checkout->nama_pelanggan ?? $checkout->user->name ?? '-' }}
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <small class="text-muted d-block mb-1">
                                                            Nomor HP
                                                        </small>

                                                        <div class="fw-semibold">
                                                            {{ $checkout->phone
                                                                ?? $checkout->no_hp
                                                                ?? $checkout->user->phone
                                                                ?? $checkout->user->no_hp
                                                                ?? '-' }}
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <small class="text-muted d-block mb-1">
                                                            Alamat Pengiriman
                                                        </small>

                                                        <div class="fw-semibold">
                                                            {{ $checkout->alamat_pengiriman }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Produk -->
                                                <div class="mb-3">

                                                    <h6 class="fw-bold mb-3">
                                                        Produk Pesanan
                                                    </h6>

                                                    @foreach ($details as $detail)

                                                        @php
                                                            $totalItem = ($detail['jumlah'] ?? 0) * ($detail['harga'] ?? 0);
                                                            $subtotal += $totalItem;

                                                            $gambar = $detail['gambar'] ?? null;

                                                            if (!$gambar && isset($detail['produk_id'])) {
                                                                $produk = \App\Models\Produk::find($detail['produk_id']);
                                                                $gambar = $produk->gambar ?? null;
                                                            }

                                                            $urlGambar = $gambar
                                                                ? asset('storage/' . $gambar)
                                                                : asset('images/no-image.png');
                                                        @endphp

                                                        <div class="d-flex justify-content-between align-items-center p-3 mb-3"
                                                            style="
                                                                background:white;
                                                                border-radius:16px;
                                                                box-shadow:0 2px 10px rgba(0,0,0,0.04);
                                                            ">

                                                            <div class="d-flex align-items-center gap-3">

                                                                <img src="{{ $urlGambar }}"
                                                                    width="60"
                                                                    height="60"
                                                                    style="
                                                                        object-fit:cover;
                                                                        border-radius:12px;
                                                                        border:1px solid #eee;
                                                                    ">

                                                                <div>
                                                                    <div class="fw-semibold mb-1"
                                                                        style="font-size:14px;">
                                                                        {{ $detail['nama'] }}
                                                                    </div>

                                                                    <small class="text-muted">
                                                                        Jumlah : {{ $detail['jumlah'] }}
                                                                    </small>
                                                                </div>

                                                            </div>

                                                            <div class="fw-bold"
                                                                style="color:#4f8df7; font-size:14px;">

                                                                Rp{{ number_format($totalItem,0,',','.') }}

                                                            </div>

                                                        </div>

                                                    @endforeach
                                                </div>

                                                <!-- Total -->
                                                <div class="p-3 mt-4"
                                                    style="
                                                        background:white;
                                                        border-radius:16px;
                                                        box-shadow:0 2px 10px rgba(0,0,0,0.04);
                                                    ">

                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span class="text-muted">
                                                            Subtotal
                                                        </span>

                                                        <span class="fw-semibold">
                                                            Rp{{ number_format($subtotal,0,',','.') }}
                                                        </span>
                                                    </div>

                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span class="text-muted">
                                                            Ongkir
                                                        </span>

                                                        <span class="fw-semibold">
                                                            Rp{{ number_format($ongkir,0,',','.') }}
                                                        </span>
                                                    </div>

                                                    <hr style="opacity:0.1;">

                                                    <div class="d-flex justify-content-between align-items-center">

                                                        <span class="fw-bold fs-5">
                                                            Total
                                                        </span>

                                                        <span class="fw-bold fs-5"
                                                            style="color:#16a34a;">

                                                            Rp{{ number_format($subtotal + $ongkir,0,',','.') }}

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="imageModal{{ $checkout->id }}">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content bg-transparent border-0">
                                            <div class="text-end">
                                                <button class="btn-close bg-white p-2 m-2" data-bs-dismiss="modal"></button>
                                            </div>
                                            <img src="{{ asset($checkout->bukti_transfer) }}"
                                                class="img-fluid rounded shadow">
                                        </div>
                                    </div>
                                </div>

                            @endif
                        @endforeach

                        @if(!$hasAny)

                        <tr>
                            <td colspan="12"
                                class="text-center text-muted">
                                Tidak ada data
                            </td>
                        </tr>

                        @endif

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $checkouts->appends(['status'=>$currentStatus])->links('pagination::bootstrap-5') }}
    </div>

</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    rel="stylesheet">

<style>
    .body{
        background:#f5f5f5;
        font-size:13px;
    }

    .card-custom{
        border:1px solid #dee2e6;
        border-radius:4px;
    }

    .card-header{
        background:#f8f9fa;
    }

    .nav-tabs .nav-link{
        font-size:13px;
        padding:6px 14px;
        color:#555;
    }

    .nav-tabs .nav-link.active{
        background:#e9ecef;
        color:#000;
        border-bottom:2px solid #6c757d;
    }

    .table th{
        background:#f1f3f5;
        font-weight:600;
    }

    .table td{
        padding:8px;
    }

    .btn-sm{
        font-size:12px;
        padding:4px 8px;
    }
</style>

@endsection