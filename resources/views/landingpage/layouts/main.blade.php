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

    @if(session('success_profile'))
        <script>
        Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#1b2a41'
        });
        </script>
    @endif

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