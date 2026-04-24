@extends('layouts.main')

@section('content')
<div class="container mt-4">

    {{-- TITLE --}}
    <div class="mb-4">
        <h4 class="mb-1">Input Data Pengguna</h4>
        <small class="text-muted">Form penambahan data pengguna sistem</small>
        <hr>
    </div>

    <div class="row">
        <div class="col-md-8">

            <div class="card border">
                <div class="card-body">

                    <form action="/dashboard-pengguna" method="post">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label class="form-label">No Handphone</label>
                            <input type="text"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   name="phone"
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="mb-3">
                            <label class="form-label">Role</label>

                            @if(auth()->user()->role === 'admin')
                                <input type="text" class="form-control" value="Pelanggan" readonly>
                                <input type="hidden" name="role" value="pelanggan">
                            @else
                                <select class="form-select @error('role') is-invalid @enderror" name="role">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="pelanggan" {{ old('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label">Kata Sandi</label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       id="password">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-eye-slash toggle-password"
                                       toggle="#password"
                                       style="cursor:pointer;"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi --}}
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Kata Sandi</label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       name="password_confirmation"
                                       id="password_confirmation">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-eye-slash toggle-password"
                                       toggle="#password_confirmation"
                                       style="cursor:pointer;"></i>
                                </span>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BUTTON --}}
                        <button type="submit" class="btn btn-primary">
                            Simpan
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