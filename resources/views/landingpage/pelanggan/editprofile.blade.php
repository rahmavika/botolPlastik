@auth
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">

            <!-- HEADER -->
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold" style="color:#1e3f66;">
                    ✏️ Edit Profil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body pt-3 px-4 pb-4">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('update-profile') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <!-- ================= PROFIL ================= -->
                        <div class="col-12">
                            <small class="text-muted fw-semibold">Informasi Profil</small>
                            <hr class="mt-1 mb-2">
                        </div>

                        <!-- Username -->
                        <div class="col-md-6">
                            <label class="small text-muted">Username</label>
                            <input type="text"
                                   class="form-control form-soft @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ Auth::user()->name }}"
                                   required>

                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="small text-muted">Email</label>
                            <input type="email"
                                name="email"
                                class="form-control form-soft"
                                value="{{ Auth::user()->email }}"
                                readonly>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label class="small text-muted">No HP</label>
                            <input type="text"
                                   class="form-control form-soft @error('phone') is-invalid @enderror"
                                   name="phone"
                                   value="{{ Auth::user()->phone }}"
                                   required>

                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ================= PASSWORD ================= -->
                        <div class="col-12 mt-3">
                            <small class="text-muted fw-semibold">Keamanan Akun</small>
                            <hr class="mt-1 mb-2">
                        </div>

                        <!-- Password Lama -->
                        <div class="col-12">
                            <label class="small text-muted">Password Lama</label>

                            <div class="position-relative">
                                <input type="password"
                                       id="old_password"
                                       name="old_password"
                                       class="form-control form-soft pe-5 @error('old_password') is-invalid @enderror">

                                <i class="bi bi-eye position-absolute toggle-password"
                                   data-target="old_password"
                                   style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
                            </div>

                            @error('old_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Baru -->
                        <div class="col-md-6">
                            <label class="small text-muted">Password Baru</label>

                            <div class="position-relative">
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="form-control form-soft pe-5 @error('password') is-invalid @enderror">

                                <i class="bi bi-eye position-absolute toggle-password"
                                   data-target="password"
                                   style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
                            </div>

                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6">
                            <label class="small text-muted">Konfirmasi Password</label>

                            <div class="position-relative">
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       class="form-control form-soft pe-5 @error('password_confirmation') is-invalid @enderror">

                                <i class="bi bi-eye position-absolute toggle-password"
                                   data-target="password_confirmation"
                                   style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
                            </div>

                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button"
                                class="btn btn-outline-secondary rounded-pill px-4 me-2"
                                data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit"
                                class="btn rounded-pill px-4 text-white"
                                style="background:#075080;">
                            💾 Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endauth

<script>
    document.addEventListener("DOMContentLoaded", function() {

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Profil berhasil diperbarui',
                confirmButtonColor: '#075080'
            });
        @endif

        @if ($errors->any())
            var myModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
            myModal.show();
        @endif

    });
</script>