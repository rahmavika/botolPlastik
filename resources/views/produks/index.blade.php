@extends('layouts.main')
@section('title', 'Data Produk')
@section('navProduk', 'active')
@section('content')

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1">Data Produk</h3>
            <small class="text-muted">Manajemen produk toko</small>
        </div>

        <div>
            <i class="bi bi-box-seam fs-2 text-primary"></i>
        </div>
    </div>
</div>
<a href="/dashboard-produk/create"
   class="btn mb-3"
   style="background:linear-gradient(90deg, #365fcf, #4f7df0); color:white; border:none; border-radius:14px; padding:10px 20px; font-weight:600;">
   + Tambah Produk
</a>

<table id=produkTable class="table table-dashboard">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Gambar</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produks as $produk)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $produk->nama_produk }}</td>
            <td>Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
            <td>
                @if($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}"class="tab-image rounded"style="width:60px; height:auto;">
                @else
                    <span class="text-muted">Tidak ada gambar</span>
                @endif
            </td>
            <td>{{ $produk->keterangan }}</td>
            <td class="text-nowrap">
                <button type="button"
                    class="btn btn-info btn-sm btn-detail border-0"
                    style="border-radius:10px;"
                    data-nama="{{ $produk->nama_produk }}"
                    data-harga="Rp{{ number_format($produk->harga, 0, ',', '.') }}"
                    data-gambar="{{ asset('storage/' . $produk->gambar) }}"
                    data-keterangan="{{ $produk->keterangan }}">
                    <i class="bi bi-eye"></i>
                </button>
                <a href="/dashboard-produk/{{ $produk->id }}/edit"
                    class="btn btn-sm btn-primary border-0"
                    style="border-radius:10px;">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button"
                    class="btn btn-danger btn-sm btn-delete border-0"
                    style="border-radius:10px;"
                    data-id="{{ $produk->id }}">
                    <i class="bi bi-trash-fill"></i>
                </button>
                <form id="form-delete-{{ $produk->id }}"
                    action="/dashboard-produk/{{ $produk->id }}"
                    method="POST"
                    class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modern-detail-modal border-0">
            <div class="modal-header-custom">
                <div>
                    <span class="badge-detail">Produk</span>
                    <h4 class="modal-title-detail mb-0">Detail Produk</h4>
                </div>
                <button type="button"class="btn-close shadow-none"data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div class="row align-items-center g-4">
                    <div class="col-md-5">
                        <div class="detail-image-box">
                            <img id="detailGambar"src=""class="img-fluid detail-image">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h3 class="detail-title mb-3" id="detailNama"></h3>
                        <p class="detail-desc mb-4" id="detailKeterangan"></p>
                        <div class="price-box">
                            <span class="price-label">Harga</span>
                            <div class="price-value" id="detailHarga"></div>
                        </div>
                        <button class="modern-close-btn mt-4 w-100" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function () {
                const produkId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-delete-' + produkId).submit();
                    }
                });
            });
        });
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function () {
                let nama = this.dataset.nama;
                let harga = this.dataset.harga;
                let gambar = this.dataset.gambar;
                let keterangan = this.dataset.keterangan;

                document.getElementById('detailNama').innerText = nama;
                document.getElementById('detailHarga').innerText = harga;
                document.getElementById('detailGambar').src = gambar;
                document.getElementById('detailKeterangan').innerText = keterangan;

                let modal = new bootstrap.Modal(document.getElementById('detailModal'));
                modal.show();
            });
        });
        @if (session('pesan'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('pesan') }}",
                icon: 'success',
                confirmButtonColor: '#0B773D'
            });
        @endif
    });
</script>
<script>
    $(document).ready(function() {
        $('#produkTable').DataTable({
            paging: true,
            searching: true,
            ordering:  true,
            lengthChange: true,
            language: {
                "sSearch": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
@endpush

<style>
    .modern-close-btn{
        height: 42px;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        margin-top: 14px !important;
        background: linear-gradient(135deg, #284b9b, #4f79e3);
        color: #fff;
        box-shadow: 0 4px 14px rgba(79,121,227,0.25);
        transition: 0.25s ease;
    }
    .modern-close-btn:hover{
        background: linear-gradient(135deg, #1f3f88, #4269d4);
        transform: translateY(-1px);
    }
    #detailModal .modal-dialog{
        max-width: 500px;
    }
    .modern-detail-modal{
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }
    .modal-header-custom{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 18px 4px;
    }
    .badge-detail{
        background: #f3f4f6;
        color: #6b7280;
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 600;
        margin-bottom: 6px;
    }
    .modal-title-detail{
        font-size: 20px;
        font-weight: 700;
        color: #111827;
    }
    #detailModal .modal-body{
        padding: 14px 18px 18px !important;
    }
    #detailModal .row{
        align-items: start !important;
    }
    .detail-image-box{
        background: #f9fafb;
        border-radius: 14px;
        padding: 10px;
        text-align: center;
    }
    .detail-image{
        max-height: 140px;
        width: auto;
        object-fit: contain;
    }
    .detail-title{
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px !important;
        line-height: 1.3;
    }
    .detail-desc{
        font-size: 13px;
        color: #6b7280;
        line-height: 1.5;
        margin-bottom: 14px !important;
    }
    .price-box{
        background: #f9fafb;
        border-radius: 12px;
        padding: 12px 14px;
    }
    .price-label{
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 4px;
    }
    .price-value{
        font-size: 22px;
        font-weight: 700;
        color: #111827;
    }
    @media(max-width:768px){
        #detailModal .modal-dialog{
            max-width: 92%;
            margin: 10px auto;
        }
        .detail-image{
            max-height: 110px;
        }
        .detail-title{
            font-size: 18px;
        }
        .price-value{
            font-size: 18px;
        }
    }
</style>
@endsection
