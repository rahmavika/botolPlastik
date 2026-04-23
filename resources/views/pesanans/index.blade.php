@extends('layouts.main')
@section('title', 'Data Pesanan')
@section('navAdm', 'active')

@section('content')
<div class="container-fluid container-custom mt-4">
    <div class="card shadow-sm card-custom">

        @php
            $statusBadge = [
                'menunggu_konfirmasi' => 'badge bg-secondary',
                'diproses'            => 'badge bg-warning text-dark',
                'dikirim'             => 'badge bg-info text-white',
                'selesai'             => 'badge bg-success text-white',
            ];

            $paymentBadge = [
                'belum_lunas'   => 'badge bg-danger',
                'lunas'         => 'badge bg-success',
            ];

            $currentStatus = request('status', 'menunggu_konfirmasi');

            $statusLabels = [
                'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                'diproses'            => 'Diproses',
                'dikirim'             => 'Dikirim',
                'selesai'             => 'Selesai',
            ];
        @endphp
        <ul class="nav nav-tabs mb-3">
            @foreach ($statusLabels as $statusKey => $label)
                <li class="nav-item">
                    <a href="{{ url()->current() }}?status={{ $statusKey }}" class="nav-link {{ $currentStatus == $statusKey ? 'active' : '' }}">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">📦 Pesanan {{ $statusLabels[$currentStatus] ?? '' }}</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>Alamat Pengiriman</th>
                            <th>Pesanan</th>
                            <th>Total</th>
                            <th>Metode Pembayaran</th>
                            <th>Bukti Transfer</th>
                            <th>Status Pembayaran</th>
                            <th>Ubah Status Pembayaran</th>
                            <th>Ubah Status Pesanan</th>
                            <th>Status Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $hasAny = false; @endphp

                        @foreach ($checkouts as $checkout)
                            @if ($checkout->status == $currentStatus)
                                @php $hasAny = true; @endphp
                                <tr>
                                    <td style="max-width:250px; word-wrap:break-word;">{{ $checkout->alamat_pengiriman }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $checkout->id }}">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    </td>
                                    <td>Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        {{ ucwords(str_replace('_', ' ', $checkout->metode_pembayaran ?? '-')) }}
                                    </td>
                                    <td>
                                        @if ($checkout->bukti_transfer)
                                            <a href="{{ asset($checkout->bukti_transfer) }}" target="_blank">
                                                <img src="{{ asset($checkout->bukti_transfer) }}" alt="Bukti Transfer" width="100">
                                            </a>
                                        @else
                                            <span class="text-danger">Belum ada bukti</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="{{ $paymentBadge[$checkout->status_pembayaran] ?? 'badge bg-secondary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $checkout->status_pembayaran ?? '-')) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('checkouts.updatePembayaran', $checkout->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status_pembayaran" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="belum_lunas" {{ $checkout->status_pembayaran == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                                <option value="lunas" {{ $checkout->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('checkouts.updateStatus', $checkout->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            @if($checkout->status == 'menunggu_konfirmasi')
                                                <button type="submit" name="status" value="diproses" class="btn btn-sm btn-outline-warning" onclick="return confirm('Proses pesanan ini?')">
                                                    <i class="fas fa-spinner"></i> Proses
                                                </button>
                                            @elseif($checkout->status == 'diproses')
                                                <button type="submit" name="status" value="dikirim" class="btn btn-sm btn-outline-info" onclick="return confirm('Kirim pesanan ini?')">
                                                    <i class="fas fa-shipping-fast"></i> Dikirim
                                                </button>
                                            @elseif($checkout->status == 'dikirim')
                                                <button type="submit" name="status" value="selesai" class="btn btn-sm btn-outline-success" onclick="return confirm('Tandai sebagai selesai?')">
                                                    <i class="fas fa-check"></i> Selesai
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <span class="{{ $statusBadge[$checkout->status] ?? 'badge bg-secondary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $checkout->status)) }}
                                        </span>
                                    </td>
                                </tr>

                            {{-- Modal Detail Produk --}}
                            <div class="modal fade" id="detailModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $checkout->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel{{ $checkout->id }}">Detail Pesanan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @php
                                                $details = $checkout->produk_details;
                                                $totalBelanja = 0;
                                            @endphp

                                            <div class="mb-3">
                                                <strong>Nama Pelanggan:</strong><br>
                                                {{ $checkout->nama_pelanggan ?? $checkout->user->name ?? '-' }}
                                            </div>
                                            <div class="mb-3">
                                                <strong>Alamat Pengiriman:</strong><br>
                                                {{ $checkout->alamat_pengiriman ?? '-' }}
                                            </div>
                                            <div class="mb-3">
                                                <strong>No. HP:</strong><br>
                                                {{ $checkout->phone ?? $checkout->user->phone ?? '-' }}
                                            </div>

                                            <hr>

                                            @foreach ($details as $detail)
                                                @php
                                                    $subtotal = ($detail['jumlah'] ?? 0) * ($detail['harga'] ?? 0);
                                                    $totalBelanja += $subtotal;
                                                @endphp
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <span><strong>Nama Produk:</strong> {{ $detail['nama'] ?? '-' }}</span>
                                                        <span><strong>Jumlah:</strong> {{ $detail['jumlah'] ?? 0 }}</span>
                                                        <span><strong>Total:</strong> Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <h5 class="m-0">Total Belanja: <strong>Rp{{ number_format($totalBelanja, 0, ',', '.') }}</strong></h5>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endif
                        @endforeach

                        @if (! $hasAny)
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada pesanan dengan status {{ $statusLabels[$currentStatus] ?? $currentStatus }}.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $checkouts->appends(['status' => $currentStatus])->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
