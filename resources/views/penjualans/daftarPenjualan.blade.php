@extends('layouts.main')
@section('title', 'Data Penjualan')
@section('navAdm', 'active')
@section('content')

<div class="pb-2 mb-3 border-bottom text-center">
    <h6 class="fw-bold mb-0" style="font-size:18px;">Laporan Data Penjualan</h6>
</div>
<div class="card border mb-3" style="border-radius:0;">
    <div class="card-body py-2 px-3">
        <form action="/cetak-pdf/penjualan" method="GET" target="_blank" class="d-flex align-items-center flex-wrap gap-2">
            <span class="fw-semibold text-muted">Cetak PDF:</span>
            <select name="tahun" class="form-select form-select-sm w-auto" required>
                <option value="" disabled selected>Tahun</option>
                @foreach(range(date('Y'), date('Y') - 5) as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            <select name="bulan" class="form-select form-select-sm w-auto" required>
                <option value="" disabled selected>Bulan</option>
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ sprintf('%02d',$m) }}">
                        {{ date('F', mktime(0,0,0,$m,1)) }}
                    </option>
                @endfor
            </select>
            <button type="submit" class="btn btn-sm"style="background:#4e73df; color:white;">
                <i class="bi bi-printer"></i>
            </button>
        </form>
    </div>
</div>
<div class="card border" style="border-radius:0;">
    <div class="card-header py-2 px-3"style="background:#f8f9fc; border-bottom:2px solid #4e73df;">
        <span class="fw-semibold" style="font-size:14px;">Data Penjualan</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-sm mb-0 align-middle" style="font-size:13px;">
                <thead style="background:#eef2ff;" class="text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="18%">
                            <form action="{{ route('dashboard-penjualan.index') }}" method="GET">
                                <div class="d-flex justify-content-center gap-1">
                                    <select name="tahun" class="form-select form-select-sm"onchange="this.form.submit();">
                                        <option value="">Thn</option>
                                        @foreach(range(date('Y'), date('Y') - 10) as $year)
                                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select name="bulan" class="form-select form-select-sm"onchange="this.form.submit();">
                                        <option value="">Bln</option>
                                        @for($m = 1; $m <= 12; $m++)
                                            <option value="{{ sprintf('%02d', $m) }}"
                                                {{ request('bulan') == sprintf('%02d', $m) ? 'selected' : '' }}>
                                                {{ $m }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </form>
                        </th>
                        <th>Nama</th>
                        <th>Total</th>
                        <th>Alamat</th>
                        <th width="8%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($checkouts as $checkout)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d-m-Y') }}
                            </td>
                            <td>{{ $checkout->user->name }}</td>
                            <td class="text-end fw-semibold">
                                Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}
                            </td>
                            <td style="white-space: normal;">{{ $checkout->alamat_pengiriman }}</td>
                            <td class="text-center">
                                <a href="/dashboard-penjualan/{{ $checkout->id }}"class="btn btn-sm"style="border:1px solid #4e73df; color:#4e73df;">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-2">
                                Data tidak tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-2">
    {{ $checkouts->links('pagination::bootstrap-5') }}
</div>

<style>
    .form-select-sm {
        font-size: 12px;
        padding: 2px 6px;
        height: auto;
    }
</style>

@endsection