@extends('layouts.main')
@section('title', 'Data Pengguna')
@section('navUser', 'active')
@section('content')

<div class="d-flex justify-content-between flex-wrap flex--md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Pengguna</h1>
</div>

<a href="/dashboard-pengguna/create" class="btn btn-primary mb-3">+Pengguna</a>
@if (Auth::check() && Auth::user()->role === 'super_admin')
    <a href="/cetak/pengguna" target="_blank" class="btn btn-success mb-3">Cetak PDF</a>
@endif


<table id=userTable class="table table-dashboard">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->role }}</td>
            <td class="text-nowrap">
                <button type="button"
                        class="btn btn-info btn-sm btn-detail"
                        data-name="{{ $user->name }}"
                        data-email="{{ $user->email }}"
                        data-phone="{{ $user->phone }}"
                        data-role="{{ $user->role }}">
                    <i class="bi bi-eye"></i>
                </button>
                <a href="/dashboard-pengguna/{{ $user->id }}/edit" class="btn btn-sm btn-primary" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $user->id }}">
                    <i class="bi bi-trash-fill"></i>
                </button>
                <form id="form-delete-{{ $user->id }}" action="/dashboard-pengguna/{{ $user->id }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Detail Pengguna -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-person-badge"></i> Detail Pengguna</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-3">
          <label class="form-label fw-bold text-muted">Nama Lengkap</label>
          <div class="p-2 border rounded bg-light" id="detailNama"></div>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold text-muted">Email</label>
          <div class="p-2 border rounded bg-light" id="detailEmail"></div>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold text-muted">No HP</label>
          <div class="p-2 border rounded bg-light" id="detailPhone"></div>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold text-muted">Role</label>
          <div class="p-2 border rounded bg-light" id="detailRole"></div>
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
                const userId = this.getAttribute('data-id');

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
                        document.getElementById('form-delete-' + userId).submit();
                    }
                });
            });
        });

        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('detailNama').innerText = this.dataset.name;
                document.getElementById('detailEmail').innerText = this.dataset.email;
                document.getElementById('detailPhone').innerText = this.dataset.phone;
                document.getElementById('detailRole').innerText = this.dataset.role;

                var modal = new bootstrap.Modal(document.getElementById('detailModal'));
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
        $('#userTable').DataTable({
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
