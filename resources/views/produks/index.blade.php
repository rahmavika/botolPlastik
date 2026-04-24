@extends('layouts.main')
@section('title', 'Data Produk')
@section('navProduk', 'active')
@section('content')

<div class="d-flex justify-content-between flex-wrap flex--md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Produk</h1>
</div>

<a href="/dashboard-produk/create" class="btn btn-primary mb-3">+Produk</a>
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
                    <img src="{{ asset('storage/' . $produk->gambar) }}"
                         class="tab-image rounded"
                         style="width:60px; height:auto;">
                @else
                    <span class="text-muted">Tidak ada gambar</span>
                @endif
            </td>
            <td>{{ $produk->keterangan }}</td>
            <td class="text-nowrap">
                <button type="button"
                        class="btn btn-info btn-sm btn-detail"
                        data-nama="{{ $produk->nama_produk }}"
                        data-harga="Rp{{ number_format($produk->harga, 0, ',', '.') }}"
                        data-gambar="{{ asset('storage/' . $produk->gambar) }}"
                        data-keterangan="{{ $produk->keterangan }}">
                    <i class="bi bi-eye"></i>
                </button>
                <a href="/dashboard-produk/{{ $produk->id }}/edit" class="btn btn-sm btn-primary">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $produk->id }}">
                    <i class="bi bi-trash-fill"></i>
                </button>
                <form id="form-delete-{{ $produk->id }}" action="/dashboard-produk/{{ $produk->id }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Detail Produk -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border">

        {{-- HEADER --}}
        <div class="modal-header">
          <h5 class="modal-title">Detail Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        {{-- BODY --}}
        <div class="modal-body">

          <div class="row">

            {{-- Gambar --}}
            <div class="col-md-4 text-center mb-3">
              <img id="detailGambar"
                   src=""
                   class="img-fluid border"
                   style="max-height:160px; object-fit:cover;">
            </div>

            {{-- Detail --}}
            <div class="col-md-8">

              <div class="mb-2">
                <label class="form-label">Nama Produk</label>
                <div class="form-control" id="detailNama"></div>
              </div>

              <div class="mb-2">
                <label class="form-label">Keterangan</label>
                <div class="form-control" id="detailKeterangan"></div>
              </div>

              <div class="mb-2">
                <label class="form-label">Harga</label>
                <div class="form-control" id="detailHarga"></div>
              </div>

            </div>

          </div>

        </div>

        {{-- FOOTER --}}
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">
            Tutup
          </button>
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
@endsection
