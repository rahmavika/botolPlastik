<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Botol Plastik Riau')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ICON -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- STYLE -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stylenew.css') }}" rel="stylesheet">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .btn-logout {
            background-color: #1b2a41;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
        }

        .btn-logout:hover {
            background-color: #162036;
        }

        /* ANIMASI MODAL */
        .modal-content {
            animation: fadeInUp 0.3s ease;
        }

        @keyframes fadeInUp {
            from {opacity:0; transform: translateY(20px);}
            to {opacity:1; transform: translateY(0);}
        }
        a.rounded-circle:hover {
        transform: scale(1.1);
        transition: 0.2s;
        }
        .form-soft {
            background: #f8fafc;
            border: 1px solid #dce3ea;
            border-radius: 10px;
        }

        .form-soft:focus {
            border-color: #5dade2;
            box-shadow: 0 0 0 0.15rem rgba(93, 173, 226, 0.25);
        }
    </style>
</head>

<body class="d-flex flex-column h-100">

    {{-- HEADER --}}
    @include('landingpage.layouts.header')

    {{-- CONTENT --}}
    <main class="flex-shrink-0">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- FOOTER --}}
    @include('landingpage.layouts.footer')
    @include('login-modal')
    @include('register-modal')
    @include('landingpage.pelanggan.detailpelanggan')
    @include('landingpage.pelanggan.editprofile')

    @if(session('success'))
        <script>
        Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#1b2a41'
        });
        </script>
    @endif

{{-- <!-- ================= LOGIN MODAL ================= -->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-body p-4">

                <h5 class="text-center fw-bold mb-4" style="color:#1b2a41;">
                    Masuk ke Akun
                </h5>

                <form method="POST" action="/login">
                    @csrf

                    <!-- EMAIL -->
                    <div class="mb-3">
                        <input type="email" name="email"
                               class="form-control rounded-3"
                               placeholder="Email" required>
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-3 position-relative">
                        <input type="password" name="password" id="loginPass"
                               class="form-control rounded-3"
                               placeholder="Password" required>
                        <i class="bi bi-eye position-absolute"
                           style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer;"
                           onclick="togglePassword('loginPass', this)"></i>
                    </div>

                    <!-- BUTTON LOGIN -->
                    <button class="btn w-100 rounded-pill text-white mb-3"
                            style="background:#1b2a41;">
                        Masuk
                    </button>

                    <!-- DIVIDER -->
                    <div class="text-center my-3 position-relative">
                        <hr>
                        <span class="position-absolute top-50 start-50 translate-middle px-2 bg-white text-muted small">
                            atau
                        </span>
                    </div>

                    <div class="text-center my-3">

                        <div class="d-flex justify-content-center gap-3">

                            <!-- GOOGLE -->
                            <a href="{{ url('/auth/google') }}"
                               class="d-flex align-items-center justify-content-center rounded-circle border"
                               style="width:45px; height:45px;">
                                <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png" width="20">
                            </a>

                            <!-- FACEBOOK -->
                            <a href="{{ url('/auth/facebook') }}"
                               class="d-flex align-items-center justify-content-center rounded-circle text-white"
                               style="width:45px; height:45px; background:#1877f2;">
                                <i class="bi bi-facebook"></i>
                            </a>

                        </div>

                    </div>

                    <!-- LINK REGISTER -->
                    <p class="text-center small mt-3">
                        Belum punya akun?
                        <a href="#"
                           data-bs-toggle="modal"
                           data-bs-target="#registerModal"
                           data-bs-dismiss="modal"
                           style="color:#1b2a41;">
                            Daftar
                        </a>
                    </p>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- ================= REGISTER MODAL ================= -->
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-body p-4">

                <h5 class="text-center fw-bold mb-4" style="color:#1b2a41;">
                    Daftar Akun
                </h5>

                <form method="POST" action="/register">
                    @csrf

                    <!-- INPUT -->
                    <div class="mb-3">
                        <input type="text" name="name"
                               class="form-control rounded-3"
                               placeholder="Nama">
                    </div>

                    <div class="mb-3">
                        <input type="email" name="email"
                               class="form-control rounded-3"
                               placeholder="Email">
                    </div>

                    <div class="mb-3">
                        <input type="text" name="phone"
                               class="form-control rounded-3"
                               placeholder="No HP">
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="password" name="password" id="regPass"
                               class="form-control rounded-3"
                               placeholder="Password">
                        <i class="bi bi-eye position-absolute"
                           style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer;"
                           onclick="togglePassword('regPass', this)"></i>
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="password" name="password_confirmation" id="regPass2"
                               class="form-control rounded-3"
                               placeholder="Konfirmasi Password">
                        <i class="bi bi-eye position-absolute"
                           style="right:15px; top:50%; transform:translateY(-50%); cursor:pointer;"
                           onclick="togglePassword('regPass2', this)"></i>
                    </div>

                    <!-- BUTTON DAFTAR -->
                    <button class="btn w-100 rounded-pill text-white mb-3"
                            style="background:#1b2a41;">
                        Daftar
                    </button>

                    <!-- DIVIDER -->
                    <div class="text-center my-3 position-relative">
                        <hr>
                        <span class="position-absolute top-50 start-50 translate-middle px-2 bg-white text-muted small">
                            atau
                        </span>
                    </div>

                    <div class="text-center my-3">

                        <div class="d-flex justify-content-center gap-3">

                            <!-- GOOGLE -->
                            <a href="{{ url('/auth/google') }}"
                               class="d-flex align-items-center justify-content-center rounded-circle border"
                               style="width:45px; height:45px;">
                                <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png" width="20">
                            </a>

                            <!-- FACEBOOK -->
                            <a href="{{ url('/auth/facebook') }}"
                               class="d-flex align-items-center justify-content-center rounded-circle text-white"
                               style="width:45px; height:45px; background:#1877f2;">
                                <i class="bi bi-facebook"></i>
                            </a>

                        </div>

                    </div>

                    <!-- LINK LOGIN -->
                    <p class="text-center small mt-3">
                        Sudah punya akun?
                        <a href="#"
                           data-bs-toggle="modal"
                           data-bs-target="#loginModal"
                           data-bs-dismiss="modal"
                           style="color:#1b2a41;">
                            Masuk
                        </a>
                    </p>

                </form>
            </div>
        </div>
    </div>
</div> --}}

    <!-- SCRIPT -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            input.type = input.type === "password" ? "text" : "password";
            el.classList.toggle("bi-eye");
            el.classList.toggle("bi-eye-slash");
        }
    </script>
    @if(session('success_register'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                Swal.fire({
                    icon: 'success',
                    title: 'Registrasi Berhasil!',
                    text: 'Silakan login untuk melanjutkan',
                    confirmButtonText: 'Login Sekarang',
                    confirmButtonColor: '#1b2a41',
                    background: '#fff',
                    backdrop: 'rgba(0,0,0,0.4)',
                }).then(() => {
                    var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    loginModal.show();
                });

            });
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle-password').forEach(function (icon) {
                icon.addEventListener('click', function () {
                    const input = document.getElementById(this.dataset.target);

                    if (input.type === "password") {
                        input.type = "text";
                        this.classList.remove('bi-eye');
                        this.classList.add('bi-eye-slash');
                    } else {
                        input.type = "password";
                        this.classList.remove('bi-eye-slash');
                        this.classList.add('bi-eye');
                    }
                });
            });
        });
        </script>
</body>
</html>