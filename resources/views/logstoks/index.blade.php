@extends('layouts.main')

@section('content')

<style>
    body {
        background: #f6f8fb;
    }

    .card-custom {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }

    .card-header-custom {
        background: #1f2937;
        color: #fff;
        border-radius: 10px 10px 0 0;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-clean {
        border-radius: 6px;
        font-size: 13px;
        padding: 6px 12px;
    }

    .btn-outline-danger-clean {
        background: #fff;
        border: 1px solid #dc2626;
        color: #dc2626;
    }

    .btn-outline-danger-clean:hover {
        background: #dc2626;
        color: #fff;
    }

    .table-clean thead th {
        font-size: 12px;
        text-transform: uppercase;
        background: #f9fafb;
        color: #6b7280;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-clean td {
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-clean tbody tr:hover {
        background: #f9fafb;
    }

    .btn-detail {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 6px;
        background: #2563eb;
        color: white;
        border: none;
    }

    .btn-detail:hover {
        background: #1e40af;
    }

    .modal-content {
        border-radius: 10px;
        border: none;
    }

    .nav-tabs .nav-link {
        font-size: 13px;
        color: #6b7280;
    }

    .nav-tabs .nav-link.active {
        color: #111827;
        font-weight: 600;
        border-color: transparent transparent #2563eb;
    }

</style>

<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h5 class="fw-semibold mb-0">📊 Laporan Rekap Mutasi Stok</h5>
</div>

<div class="container">

    <div class="card card-custom">

        {{-- HEADER --}}
        <div class="card-header-custom">
            Laporan Mutasi Stok
        </div>

        <div class="card-body">

            {{-- BUTTON --}}
            <div class="mb-3">
                <button class="btn btn-clean btn-outline-danger-clean"
                        data-bs-toggle="modal"
                        data-bs-target="#modalCetakMutasi">
                    <i class="bi bi-printer me-1"></i>
                    Cetak Laporan
                </button>
            </div>

            {{-- MODAL (TIDAK DIUBAH FUNGSI) --}}
            <div class="modal fade" id="modalCetakMutasi" tabindex="-1">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content p-3">

                        <form action="{{ route('logstoks.cetak') }}" method="GET" target="_blank">
                        <input type="hidden" name="filter" id="filterTypeMutasi" value="bulan">

                            <div class="modal-header border-0">
                                <h6 class="modal-title fw-semibold">
                                    Cetak Laporan Mutasi Stok
                                </h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <ul class="nav nav-tabs mb-3" id="filterTabMutasi">
                                    <li class="nav-item">
                                        <button class="nav-link active"
                                            data-bs-toggle="tab"
                                            data-bs-target="#bulan-mutasi">
                                            Per Bulan
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link"
                                            data-bs-toggle="tab"
                                            data-bs-target="#tanggal-mutasi">
                                            Rentang Tanggal
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content">

                                    <div class="tab-pane fade show active" id="bulan-mutasi">
                                        <label class="form-label">Pilih Bulan</label>
                                        <input type="month" name="bulan" class="form-control">
                                    </div>

                                    <div class="tab-pane fade" id="tanggal-mutasi">
                                        <div class="mb-2">
                                            <label class="form-label">Dari</label>
                                            <input type="text" id="fromMutasi" name="from" class="form-control">
                                        </div>
                                        <div>
                                            <label class="form-label">Sampai</label>
                                            <input type="text" id="toMutasi" name="to" class="form-control">
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Cetak
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-clean text-center">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bulan</th>
                            <th>Produk</th>
                            <th>Awal</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($periodeList as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_bulan }}</td>
                            <td>{{ $item->jumlah_produk }}</td>
                            <td>{{ $item->stok_awal }}</td>
                            <td>{{ $item->stok_masuk }}</td>
                            <td>{{ $item->stok_keluar }}</td>
                            <td>{{ $item->stok_akhir }}</td>
                            <td>
                                <a href="{{ route('logstoks.show', [$item->bulan, $item->tahun]) }}"
                                   class="btn-detail">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-muted">
                                Tidak ada data
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