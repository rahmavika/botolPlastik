<!DOCTYPE html>
<html lang="en">
<head>
    <title>Botol Plastik Riau</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">
    <link rel="icon" href="https://your-domain.com/assets/images/favicon.svg" type="image/x-icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/material.css') }}">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('css/style-preset.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .sidebar-hidden .pc-sidebar {
        transform: translateX(-100%);
        visibility: hidden;
        position: absolute;
        }

        .sidebar-hidden main {
        margin-left: 0 !important;
        width: 100% !important;
        }

        .sidebar-hidden .pc-header {
        left: 0 !important;
        width: 100% !important;
        }
        .pc-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        width: 250px;
        background-color: #fff;
        transform: translateX(0);
        visibility: visible;
        z-index: 1000;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const sidebarHide = document.getElementById("sidebar-hide");
        const mobileCollapse = document.getElementById("mobile-collapse");

        function toggleSidebar() {
            document.body.classList.toggle("sidebar-hidden");
        }

        sidebarHide?.addEventListener("click", function (e) {
            e.preventDefault();
            toggleSidebar();
        });

        mobileCollapse?.addEventListener("click", function (e) {
            e.preventDefault();
            toggleSidebar();
        });
        });
    </script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>

<body>
    @include('layouts.header')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 100px;">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/dashboard-default.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/simplebar.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/custom-font.js') }}"></script>
    <script src="{{ asset('js/pcoded.js') }}"></script>
    <script src="{{ asset('js/feather.min.js') }}"></script>

    <script>
        feather.replace();
    </script>
    @stack('scripts')
</body>
</html>
