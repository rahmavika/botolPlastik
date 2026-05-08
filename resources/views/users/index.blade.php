@extends('layouts.main')
@section('title', 'Data Pengguna')
@section('navUser', 'active')
@section('content')

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1">Data Pengguna</h3>
            <small class="text-muted">Kelola akun dan hak akses pengguna sistem</small>
        </div>

        <div>
            <i class="bi bi-people-fill fs-2 text-info"></i>
        </div>
    </div>
</div>
<a href="/dashboard-pengguna/create"class="btn mb-3"
   style="background:linear-gradient(90deg, #365fcf, #4f7df0); color:white; border:none; border-radius:14px; padding:10px 20px; font-weight:600;">
   + Pengguna
</a>
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
                    class="btn btn-info btn-sm btn-detail border-0"
                    style="border-radius:10px;"
                    data-name="{{ $user->name }}"
                    data-email="{{ $user->email }}"
                    data-phone="{{ $user->phone }}"
                    data-role="{{ $user->role }}">
                    <i class="bi bi-eye"></i>
                </button>
                <a href="/dashboard-pengguna/{{ $user->id }}/edit"
                    class="btn btn-sm btn-primary border-0"
                    style="border-radius:10px;"
                    title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button"
                    class="btn btn-danger btn-sm btn-delete border-0"
                    style="border-radius:10px;"
                    data-id="{{ $user->id }}">
                    <i class="bi bi-trash-fill"></i>
                </button>
                <form id="form-delete-{{ $user->id }}"
                    action="/dashboard-pengguna/{{ $user->id }}"
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

<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content dark-modal">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-person-badge-fill me-2"></i>
                    Detail Pengguna
                </h5>
                <button type="button"class="btn-close btn-close-white"data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="detail-box">
                    <div class="detail-label">
                        <i class="bi bi-person-fill"></i>
                        Nama Lengkap
                    </div>
                    <div class="detail-value" id="detailNama"></div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">
                        <i class="bi bi-envelope-fill"></i>
                        Email
                    </div>
                    <div class="detail-value" id="detailEmail"></div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">
                        <i class="bi bi-telephone-fill"></i>
                        No HP
                    </div>
                    <div class="detail-value" id="detailPhone"></div>
                </div>
                <div class="detail-box">
                    <div class="detail-label">
                        <i class="bi bi-shield-lock-fill"></i>
                        Role
                    </div>
                    <div class="detail-value" id="detailRole"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-dark-modern" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>
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
<style>
    .dark-modal {
        border: none;
        border-radius: 22px;
        overflow: hidden;
        background: #ffffff;
        color: #1e293b;
        box-shadow: 0 10px 35px rgba(79,111,230,0.20);
    }
    .dark-modal .modal-header {
        background: linear-gradient(135deg, #4f6fe6, #5d7cf0);
        border-bottom: none;
        padding: 18px 24px;
    }
    .dark-modal .modal-title {
        color: white;
        font-weight: 700;
    }
    .detail-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        transition: 0.3s ease;
    }
    .detail-box:hover {
        transform: translateY(-2px);
        border-color: #5d7cf0;
    }
    .detail-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 6px;
        font-weight: 600;
    }
    .detail-value {
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
    }
    .dark-modal .modal-footer {
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
    }
    .btn-dark-modern {
        border: none;
        border-radius: 12px;
        padding: 10px 18px;
        background: linear-gradient(135deg, #4f6fe6, #5d7cf0);
        color: white;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-dark-modern:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #5675ea, #6f8cff);
    }
</style>
@endsection
