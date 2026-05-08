@extends('layouts.main')
@section('content')

<div class="container-md mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="mb-0 text-dark fw-semibold">
                Laporan Mutasi Stok -
                {{ \Carbon\Carbon::createFromDate(null, $bulan)->locale('id')->monthName }}
                {{ $tahun }}
            </h6>
        </div>
        <div class="card-body py-3">
            <a href="{{ route('mutasistoks.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
                ← Kembali
            </a>
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th class="text-start">Nama Produk</th>
                            <th style="width: 120px;">Stok Awal</th>
                            <th style="width: 120px;">Stok Masuk</th>
                            <th style="width: 120px;">Stok Keluar</th>
                            <th style="width: 120px;">Stok Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataMutasi as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-start">{{ $item->nama_produk }}</td>
                                <td>{{ $item->stok_awal }}</td>
                                <td>{{ $item->masuk }}</td>
                                <td>{{ $item->keluar }}</td>
                                <td class="fw-semibold">{{ $item->stok_akhir }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3 text-muted">
                                    Tidak ada data mutasi stok untuk periode ini.
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