@extends('layouts.main')
@section('title', 'Data Pesanan')
@section('navAdm', 'active')

@section('content')
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

        {{-- NAV --}}
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

        {{-- HEADER --}}
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
                            <th>Alamat</th>
                            <th>Detail</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Bukti</th>
                            <th>Status Bayar</th>
                            <th>Ubah Bayar</th>
                            <th>Aksi</th>
                            <th>Status</th>
                            <th>Resi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $hasAny = false; @endphp

                        @foreach ($checkouts as $checkout)
                        @if ($checkout->status == $currentStatus)
                        @php $hasAny = true; @endphp

                        <tr>

                            <td style="max-width:200px;">
                                {{ $checkout->alamat_pengiriman }}
                            </td>

                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-secondary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $checkout->id }}">
                                    Detail
                                </button>
                            </td>

                            <td class="text-end">
                                Rp {{ number_format($checkout->total_harga,0,',','.') }}
                            </td>

                            <td class="text-center">
                                {{ ucwords(str_replace('_',' ',$checkout->metode_pembayaran)) }}
                            </td>

                            {{-- ✅ BUKTI POPUP --}}
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
                                <form action="{{ route('checkouts.updatePembayaran',$checkout->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <select name="status_pembayaran"
                                        class="form-select form-select-sm"
                                        onchange="this.form.submit()">
                                        <option value="belum_lunas" {{ $checkout->status_pembayaran=='belum_lunas'?'selected':'' }}>Belum</option>
                                        <option value="lunas" {{ $checkout->status_pembayaran=='lunas'?'selected':'' }}>Lunas</option>
                                    </select>
                                </form>
                            </td>

                            <td class="text-center">
                                <form action="{{ route('checkouts.updateStatus',$checkout->id) }}" method="POST">
                                    @csrf @method('PUT')

                                    @if($checkout->status=='menunggu_konfirmasi')
                                        <button name="status" value="diproses" class="btn btn-sm btn-outline-warning">Proses</button>

                                    @elseif($checkout->status=='diproses')
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            onclick="inputResi({{ $checkout->id }})">Kirim</button>

                                    @elseif($checkout->status=='dikirim')
                                        <button name="status" value="selesai" class="btn btn-sm btn-outline-success">Selesai</button>
                                    @endif
                                </form>
                            </td>

                            <td class="text-center">
                                <span class="{{ $statusBadge[$checkout->status] }}">
                                    {{ ucfirst($checkout->status) }}
                                </span>
                            </td>

                            <td>
                                @if(!$checkout->no_resi)
                                    <form action="/input-resi/{{ $checkout->id }}" method="POST" class="d-flex gap-1">
                                        @csrf
                                        <input type="text" name="no_resi"
                                            class="form-control form-control-sm"
                                            placeholder="Resi">
                                    </form>
                                @else
                                    <small>{{ $checkout->no_resi }}</small>
                                @endif
                            </td>

                        </tr>

                        {{-- ✅ MODAL DETAIL --}}
                        <div class="modal fade" id="detailModal{{ $checkout->id }}">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h6 class="modal-title fw-semibold">Detail Pesanan</h6>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        @php
                                            $details = $checkout->produk_details;
                                            $subtotal = 0;
                                            $ongkir = $checkout->ongkir ?? 0;
                                        @endphp

                                        <p><strong>Nama:</strong> {{ $checkout->nama_pelanggan ?? $checkout->user->name ?? '-' }}</p>
                                        <p><strong>No HP:</strong>
                                            {{ $checkout->phone
                                                ?? $checkout->no_hp
                                                ?? $checkout->user->phone
                                                ?? $checkout->user->no_hp
                                                ?? '-' }}
                                        </p>
                                        <p><strong>Alamat:</strong> {{ $checkout->alamat_pengiriman }}</p>

                                        <hr>

                                        @foreach ($details as $detail)
                                            @php
                                                $totalItem = ($detail['jumlah'] ?? 0) * ($detail['harga'] ?? 0);
                                                $subtotal += $totalItem;
                                            @endphp

                                            <div class="d-flex justify-content-between mb-2">
                                                <span>{{ $detail['nama'] }} (x{{ $detail['jumlah'] }})</span>
                                                <span>Rp{{ number_format($totalItem,0,',','.') }}</span>
                                            </div>
                                        @endforeach

                                        <hr>

                                        <div class="d-flex justify-content-between">
                                            <span>Subtotal</span>
                                            <span>Rp{{ number_format($subtotal,0,',','.') }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <span>Ongkir</span>
                                            <span>Rp{{ number_format($ongkir,0,',','.') }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total</span>
                                            <span>Rp{{ number_format($subtotal + $ongkir,0,',','.') }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- ✅ MODAL GAMBAR --}}
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
                            <td colspan="10" class="text-center text-muted">Tidak ada data</td>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function inputResi(id){
    Swal.fire({
        title:'Masukkan No Resi',
        input:'text',
        showCancelButton:true
    }).then((r)=>{
        if(r.isConfirmed){
            let f=document.createElement('form');
            f.method='POST';
            f.action=`/checkouts/${id}`;
            f.innerHTML=`@csrf @method('PUT')
            <input name="status" value="dikirim">
            <input name="no_resi" value="${r.value}">`;
            document.body.appendChild(f);
            f.submit();
        }
    });
}
</script>

<style>
body {
    background:#f5f5f5;
    font-size:13px;
}

.card-custom {
    border:1px solid #dee2e6;
    border-radius:4px;
}

.card-header {
    background:#f8f9fa;
}

.nav-tabs .nav-link {
    font-size:13px;
    padding:6px 14px;
    color:#555;
}

.nav-tabs .nav-link.active {
    background:#e9ecef;
    color:#000;
    border-bottom:2px solid #6c757d;
}

.table th {
    background:#f1f3f5;
    font-weight:600;
}

.table td {
    padding:8px;
}

.btn-sm {
    font-size:12px;
    padding:4px 8px;
}
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection