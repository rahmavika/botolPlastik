@auth
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden shadow-lg"
            style="border-radius:22px;">

            <!-- Header -->
            <div class="modal-header border-0 px-4 py-3"
                style="background:linear-gradient(135deg,#075080,#0b6aa8);">

                <h5 class="fw-bold text-white mb-0">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Profil
                </h5>

                <!-- Tombol Close -->
                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    onclick="showDetailModal()">
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body bg-white px-4 py-4">

                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm"
                        style="border-radius:14px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('update-profile') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Informasi Profil -->
                    <div class="mb-4">

                        <h6 class="fw-bold mb-3"
                            style="color:#075080;">
                            Informasi Profil
                        </h6>

                        <div class="row g-3">

                            <!-- Username -->
                            <div class="col-md-6">

                                <label class="small fw-semibold text-muted mb-2">
                                    Username
                                </label>

                                <div class="input-group shadow-sm">

                                    <span class="input-group-text border-0"
                                        style="background:#f4f9fc;">
                                        <i class="bi bi-person text-primary"></i>
                                    </span>

                                    <input type="text"
                                        class="form-control border-0 py-2 @error('name') is-invalid @enderror"
                                        style="background:#f4f9fc;"
                                        name="name"
                                        value="{{ Auth::user()->name }}"
                                        required>

                                </div>

                                @error('name')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <!-- Email -->
                            <div class="col-md-6">

                                <label class="small fw-semibold text-muted mb-2">
                                    Email
                                </label>

                                <div class="input-group shadow-sm">

                                    <span class="input-group-text border-0"
                                        style="background:#f4f9fc;">
                                        <i class="bi bi-envelope text-primary"></i>
                                    </span>

                                    <input type="email"
                                        name="email"
                                        class="form-control border-0 py-2"
                                        style="background:#f4f9fc;"
                                        value="{{ Auth::user()->email }}"
                                        readonly>

                                </div>

                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">

                                <label class="small fw-semibold text-muted mb-2">
                                    No HP
                                </label>

                                <div class="input-group shadow-sm">

                                    <span class="input-group-text border-0"
                                        style="background:#f4f9fc;">
                                        <i class="bi bi-telephone text-primary"></i>
                                    </span>

                                    <input type="text"
                                        class="form-control border-0 py-2 @error('phone') is-invalid @enderror"
                                        style="background:#f4f9fc;"
                                        name="phone"
                                        value="{{ Auth::user()->phone }}"
                                        required>

                                </div>

                                @error('phone')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>
                    </div>

                    <!-- Keamanan -->
                    <div class="mb-3">

                        <h6 class="fw-bold mb-3"
                            style="color:#075080;">
                            Keamanan Akun
                        </h6>

                        <div class="row g-3">

                            <!-- Password Lama -->
                            <div class="col-12">

                                <label class="small fw-semibold text-muted mb-2">
                                    Password Lama
                                </label>

                                <div class="position-relative shadow-sm rounded-3 overflow-hidden">

                                    <input type="password"
                                        id="old_password"
                                        name="old_password"
                                        class="form-control border-0 py-2 pe-5 @error('old_password') is-invalid @enderror"
                                        style="background:#f4f9fc;">

                                    <i class="bi bi-eye position-absolute toggle-password"
                                        data-target="old_password"
                                        style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer; color:#075080;">
                                    </i>

                                </div>

                                @error('old_password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <!-- Password Baru -->
                            <div class="col-md-6">

                                <label class="small fw-semibold text-muted mb-2">
                                    Password Baru
                                </label>

                                <div class="position-relative shadow-sm rounded-3 overflow-hidden">

                                    <input type="password"
                                        id="password"
                                        name="password"
                                        class="form-control border-0 py-2 pe-5 @error('password') is-invalid @enderror"
                                        style="background:#f4f9fc;">

                                    <i class="bi bi-eye position-absolute toggle-password"
                                        data-target="password"
                                        style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer; color:#075080;">
                                    </i>

                                </div>

                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="col-md-6">

                                <label class="small fw-semibold text-muted mb-2">
                                    Konfirmasi Password
                                </label>

                                <div class="position-relative shadow-sm rounded-3 overflow-hidden">

                                    <input type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="form-control border-0 py-2 pe-5 @error('password_confirmation') is-invalid @enderror"
                                        style="background:#f4f9fc;">

                                    <i class="bi bi-eye position-absolute toggle-password"
                                        data-target="password_confirmation"
                                        style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer; color:#075080;">
                                    </i>

                                </div>

                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>
                    </div>

                    <!-- Button -->
                    <div class="d-flex justify-content-end mt-4">

                        <!-- Tombol Batal -->
                        <button type="button"
                            class="btn px-4 py-2 me-2"
                            data-bs-dismiss="modal"
                            onclick="showDetailModal()"
                            style="border-radius:12px; background:#e5e7eb; color:#374151;">

                            Batal
                        </button>

                        <!-- Tombol Simpan -->
                        <button type="submit"
                            class="btn px-4 py-2 text-white fw-semibold"
                            style="background:#075080; border-radius:12px;">

                            <i class="bi bi-check-circle me-1"></i>
                            Simpan

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

        // Toggle Password
        document.querySelectorAll(".toggle-password").forEach(icon => {

            icon.addEventListener("click", function() {

                let input = document.getElementById(this.dataset.target);

                if (input.type === "password") {

                    input.type = "text";
                    this.classList.remove("bi-eye");
                    this.classList.add("bi-eye-slash");

                } else {

                    input.type = "password";
                    this.classList.remove("bi-eye-slash");
                    this.classList.add("bi-eye");

                }

            });

        });

        // Alert Success
        @if (session('success'))

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Profil berhasil diperbarui',
                confirmButtonColor: '#075080',
                timer: 2000,
                showConfirmButton: false
            });

        @endif

        // Modal Tetap Terbuka Saat Error
        @if ($errors->any())

            let myModal = new bootstrap.Modal(
                document.getElementById('editProfileModal')
            );

            myModal.show();

        @endif

    });

    // Fungsi kembali ke modal detail pelanggan
    function showDetailModal() {

        setTimeout(() => {

            let detailModal = new bootstrap.Modal(
                document.getElementById('detailPelangganModal')
            );

            detailModal.show();

        }, 300);

    }
</script>