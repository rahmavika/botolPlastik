@extends('layouts.main')
@section('content')

<style>
    body {
        background: #f8fafc;
    }
    .card-custom {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.05);
    }
    .card-header-custom {
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        border-radius: 12px 12px 0 0;
        padding: 16px;
        font-weight: 600;
        font-size: 16px;
    }
    .table-clean thead th {
        font-size: 12px;
        text-transform: uppercase;
        background: #f1f5f9;
        color: #64748b;
        border-bottom: 1px solid #e5e7eb;
    }
    .table-clean td {
        font-size: 13px;
        color: #334155;
        vertical-align: middle;
    }
    .badge-masuk {
        background: #22c55e;
        color: white;
        font-size: 11px;
        padding: 5px 10px;
        border-radius: 999px;
    }
    .badge-keluar {
        background: #ef4444;
        color: white;
        font-size: 11px;
        padding: 5px 10px;
        border-radius: 999px;
    }
    .filter-box {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .info-box {
        font-size: 13px;
        color: #64748b;
    }
</style>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">📦 Log Stok Barang</h4>
            <small class="text-muted">Riwayat keluar masuk stok produk</small>
        </div>

        <div>
            <i class="bi bi-clock-history fs-2 text-warning"></i>
        </div>
    </div>
</div>
<div class="container">
    <div class="card card-custom">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <span>Riwayat Pergerakan Stok</span>
            <span class="info-box">
                Total Data: <strong>{{ count($logStok) }}</strong>
            </span>
        </div>
        <div class="card-body">
            <form method="GET" action="" class="filter-box">
                <div class="row g-2">
                    <div class="col-md-3">
                        <label>Dari Tanggal</label>
                        <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Bulan</label>
                        <input type="month" name="bulan" value="{{ request('bulan') }}" class="form-control">
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button class="btn btn-primary w-100">
                            🔍 Filter
                        </button>
                        <a href="" class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-clean table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>User</th>
                            <th>Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logStok as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </td>
                            <td class="text-start">
                                <strong>
                                    {{ $item->produk->nama_produk ?? '-' }}
                                </strong>
                            </td>
                            <td>
                                @if($item->tipe == 'masuk')
                                    <span class="badge-masuk">+ Masuk</span>
                                @else
                                    <span class="badge-keluar">- Keluar</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->jumlah }}</strong>
                            </td>
                            <td class="text-start">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                            <td>
                                {{ $item->user->name ?? $item->created_by }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-muted py-4">
                                🚫 Belum ada data log stok
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection