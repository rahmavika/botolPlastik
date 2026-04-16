@extends('layouts.main')
@section('title', 'Data Produk')
@section('navProduk', 'active')
@section('content')

<div class="d-flex justify-content-between flex-wrap flex--md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Produk</h1>
</div>

<a href="/dashboard-produk/create" class="btn btn-primary mb-3">+Produk</a>
<a href="/cetak/produk" target="_blank" class="btn btn-success mb-3">Cetak PDF</a>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content shadow-lg">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">
            <i class="bi bi-box-seam"></i> Detail Produk
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="row g-4">
            <div class="col-md-4 text-center">
              <img id="detailGambar" src="" class="img-fluid rounded shadow-sm border mb-2" style="max-height: 220px; object-fit: cover;">
              <div class="small text-muted">Gambar Produk</div>
            </div>
            <div class="col-md-8">
              <div class="card border-0">
                <div class="card-body p-0">
                  <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Nama Produk</label>
                    <div class="p-2 border rounded bg-light" id="detailNama"></div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Keterangan</label>
                    <div class="p-2 border rounded bg-light" id="detailKeterangan"></div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold text-muted">Harga</label>
                      <div class="p-2 border rounded bg-light" id="detailHarga"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle"></i> Tutup
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
