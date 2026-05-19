@extends('layouts.main')
@section('content')

<div class="container mt-4">
    <div class="mb-4">
        <h4 class="mb-1">Edit Data Pengguna</h4>
        <small class="text-muted">Perbarui informasi pengguna</small>
        <hr>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card border">
                <div class="card-body">
                    <form action="/dashboard-pengguna/{{ $user->id }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Handphone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>

                            <select class="form-select @error('role') is-invalid @enderror" name="role">
                                <option value="">-- Pilih Role --</option>

                                <option value="admin"
                                    {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>

                                <option value="pelanggan"
                                    {{ old('role', $user->role) == 'pelanggan' ? 'selected' : '' }}>
                                    Pelanggan
                                </option>
                            </select>

                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Password Lama</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" id="old_password">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-eye-slash toggle-password" toggle="#old_password"></i>
                                </span>
                            </div>
                            @error('old_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn" style="background: linear-gradient(90deg, #3557c7, #4f7df0); color: white; border: none;">
                            Update Data
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
    document.querySelectorAll('.toggle-password').forEach(function (icon) {
        icon.addEventListener('click', function () {
            const input = document.querySelector(icon.getAttribute('toggle'));
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    });
    </script>
@endpush