@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h3 text-center">Edit Data Pengguna</h2>
</div>

<div class="row">
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="/dashboard-pengguna/{{ $user->id }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                    name="name" id="name" value="{{ old('name', $user->name) }}" placeholder="Nama Lengkap">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" id="email" value="{{ old('email', $user->email) }}" placeholder="name@example.com">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">No Handphone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                    name="phone" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>

                    @if(auth()->user()->role === 'admin')
                        <input type="text" class="form-control" value="Pelanggan" readonly>
                        <input type="hidden" name="role" value="pelanggan">
                    @else
                        <select class="form-select @error('role') is-invalid @enderror" name="role" id="role">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="pelanggan" {{ old('role', $user->role) == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    @endif
                </div>

                <div class="mb-3">
                    <label for="old_password" class="form-label">Password Lama</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                               name="old_password" id="old_password" placeholder="Masukkan Password Lama">
                        <span class="input-group-text">
                            <i class="bi bi-eye-slash toggle-password" toggle="#old_password" style="cursor: pointer;"></i>
                        </span>
                    </div>
                    @error('old_password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi Baru (Opsional)</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               name="password" id="password" placeholder="Kata Sandi">
                        <span class="input-group-text">
                            <i class="bi bi-eye-slash toggle-password" toggle="#password" style="cursor: pointer;"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                               name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Kata Sandi">
                        <span class="input-group-text">
                            <i class="bi bi-eye-slash toggle-password" toggle="#password_confirmation" style="cursor: pointer;"></i>
                        </span>
                    </div>
                    @error('password_confirmation')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
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
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });
</script>
@endpush
