@extends('layouts.main')
@section('title', 'Data Penjualan')
@section('navAdm', 'active')

@section('content')

<div class="pb-3 mb-3 border-bottom text-center">
    <h3 class="fw-bold" style="font-size: 24px;">Laporan Data Penjualan</h3>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body d-flex align-items-center">
        <form action="/cetak-pdf/penjualan" method="GET" target="_blank" class="d-flex align-items-center w-100 flex-wrap gap-2">
            <label class="mb-0 fw-semibold me-2">Cetak PDF:</label>

            <select name="tahun" class="form-select w-auto" required>
                <option value="" disabled selected>Pilih Tahun</option>
                @foreach(range(date('Y'), date('Y') - 5) as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>

            <select name="bulan" class="form-select w-auto" required>
                <option value="" disabled selected>Pilih Bulan</option>
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ sprintf('%02d',$m) }}">{{ date('F', mktime(0,0,0,$m,1)) }}</option>
                @endfor
            </select>

            <button type="submit" class="btn btn-primary ms-2">
                <i class="bi bi-printer"></i> Cetak
            </button>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white fw-semibold">Data Penjualan</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="text-center align-middle">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 18%">
                            <form action="{{ route('dashboard-penjualan.index') }}" method="GET" id="filterForm">
                                <div class="d-flex justify-content-center gap-1">
                                    <select name="tahun" class="form-select form-select-sm"
                                            onchange="this.form.submit();">
                                        <option value="">Tahun</option>
                                        @foreach(range(date('Y'), date('Y') - 10) as $year)
                                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="bulan" class="form-select form-select-sm"
                                            onchange="this.form.submit();">
                                        <option value="">Bulan</option>
                                        @for($m = 1; $m <= 12; $m++)
                                            <option value="{{ sprintf('%02d', $m) }}"
                                                {{ request('bulan') == sprintf('%02d', $m) ? 'selected' : '' }}>
                                                {{ date('F', mktime(0,0,0,$m,1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </form>
                        </th>
                        <th>User ID</th>
                        <th>Total Harga</th>
                        <th>Alamat Pengiriman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($checkouts as $checkout)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d-m-Y') }}</td>
                            <td>{{ $checkout->user_id }}</td>
                            <td>Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                            <td>{{ $checkout->alamat_pengiriman }}</td>
                            <td>
                                <a href="/dashboard-penjualan/{{ $checkout->id }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Data penjualan tidak tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $checkouts->links('pagination::bootstrap-5') }}
</div>
<style>
    .form-select-sm {
        font-size: 13px;
        height: auto;
        padding: 0.25rem 0.5rem;
    }
</style>

@endsection
