@extends('layouts.main')
@section('title', 'Data Produk')
@section('navProduk', 'active')
@section('content')

<div class="d-flex justify-content-between flex-wrap flex--md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Produk</h1>
</div>

<table id=stokTable class="table table-dashboard">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Jumlah Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stoks as $stok)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $stok->nama_produk }}</td>
            <td>{{ $stok->jumlah_stok }}</td>
            <td class="text-nowrap">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambahStok-{{ $stok->produk_id }}">
                    <i class="bi bi-plus-circle"></i>
                </button>
                <button type="button"
                    class="btn btn-danger btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalKurangiStok-{{ $stok->produk_id }}">
                    <i class="bi bi-dash-circle"></i>
                </button>
            </td>
        </tr>
        <div class="modal fade" id="modalTambahStok-{{ $stok->produk_id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('stok.tambah', $stok->produk_id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Tambah Stok - {{ $stok->nama_produk }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" min="1" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalKurangiStok-{{ $stok->produk_id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('stok.kurangi', $stok->produk_id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Kurangi Stok - {{ $stok->nama_produk }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" min="1" required>
                        </div>
                        <div class="modal-body">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Penjualan, Barang rusak, dll" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Kurangi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @endforeach
    </tbody>

</table>

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

        // Detail
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function () {
                let nama = this.dataset.nama;
                let kategori = this.dataset.kategori;
                let satuan = this.dataset.satuan;
                let harga = this.dataset.harga;
                let supplier = this.dataset.supplier;
                let gambar = this.dataset.gambar;

                document.getElementById('detailNama').innerText = nama;
                document.getElementById('detailKategori').innerText = kategori;
                document.getElementById('detailSatuan').innerText = satuan;
                document.getElementById('detailHarga').innerText = harga;
                document.getElementById('detailSupplier').innerText = supplier;
                document.getElementById('detailGambar').src = gambar;

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
        if (!$.fn.DataTable.isDataTable('#stokTable')) {
            $('#stokTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
                stateSave: true,
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
        }
    });
</script>
@endpush
@endsection
