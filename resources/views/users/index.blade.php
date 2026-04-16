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
                <button class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editUserModal{{ $user->id }}">
                    <i class="bi bi-pencil-square"></i>
                </button>
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

{{-- Modal Update Pengguna --}}
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 0;">

            <!-- HEADER -->
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-semibold" style="color:#1e3f66;">
                    ✏️ Edit Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body pt-2">

                {{-- ALERT --}}
                @if(session('error'))
                    <div class="alert alert-danger py-2">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success py-2">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="/dashboard-pengguna/{{ $user->id }}" method="post">
                    @method('PUT')
                    @csrf

                    <div class="row g-3">

                        <!-- Nama -->
                        <div class="col-12">
                            <label class="form-label small text-muted">Nama Lengkap</label>
                            <input type="text"
                                   class="form-control"
                                   name="name"
                                   value="{{ $user->name }}">
                        </div>

                        <!-- Email -->
                        <div class="col-12">
                            <label class="form-label small text-muted">Email</label>
                            <input type="email"
                                   class="form-control"
                                   name="email"
                                   value="{{ $user->email }}">
                        </div>

                        <!-- Phone -->
                        <div class="col-12">
                            <label class="form-label small text-muted">No HP</label>
                            <input type="text"
                                   class="form-control"
                                   name="phone"
                                   value="{{ $user->phone }}">
                        </div>

                        <!-- Role -->
                        <div class="col-12">
                            <label class="form-label small text-muted">Role</label>

                            @if(auth()->user()->role === 'admin')
                                <input type="text"
                                       class="form-control bg-light"
                                       value="Pelanggan" readonly>
                                <input type="hidden" name="role" value="pelanggan">
                            @else
                                <select class="form-select" name="role">
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="pelanggan" {{ $user->role == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                                </select>
                            @endif
                        </div>

                        <!-- Password Lama -->
                        <div class="col-12">
                            <label class="form-label small text-muted">Password Lama</label>
                            <div class="position-relative">
                                <input type="password"
                                       class="form-control pe-5"
                                       name="old_password"
                                       id="oldPassword{{ $user->id }}">
                                <i class="bi bi-eye toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                   style="cursor:pointer;"
                                   data-target="oldPassword{{ $user->id }}"></i>
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Password Baru</label>
                            <div class="position-relative">
                                <input type="password"
                                       class="form-control pe-5"
                                       name="password"
                                       id="newPassword{{ $user->id }}">
                                <i class="bi bi-eye toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                   style="cursor:pointer;"
                                   data-target="newPassword{{ $user->id }}"></i>
                            </div>
                        </div>

                        <!-- Konfirmasi -->
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Konfirmasi</label>
                            <div class="position-relative">
                                <input type="password"
                                       class="form-control pe-5"
                                       name="password_confirmation"
                                       id="confirmPassword{{ $user->id }}">
                                <i class="bi bi-eye toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                   style="cursor:pointer;"
                                   data-target="confirmPassword{{ $user->id }}"></i>
                            </div>
                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button"
                                class="btn btn-light border px-3"
                                data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit"
                                class="btn text-white px-4"
                                style="background:#1e3f66;">
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function () {
                const input = document.getElementById(this.dataset.target);

                if (input.type === "password") {
                    input.type = "text";
                    this.classList.replace("bi-eye", "bi-eye-slash");
                } else {
                    input.type = "password";
                    this.classList.replace("bi-eye-slash", "bi-eye");
                }
            });
        });
    });
</script>
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
