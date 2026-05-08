<header class="header-modern shadow-sm">
    <div class="main-header-modern">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/" class="brand-modern d-flex align-items-center text-decoration-none">
                <div class="logo-icon me-2">
                    <i class="fas fa-bottle-water"></i>
                </div>

                <span class="fw-bold">Botol Plastik Riau</span>
            </a>
            <nav class="nav-modern d-none d-md-block">
                <ul>
                    <li>
                        <a href="/" class="{{ Request::is('/') ? 'active' : '' }}">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="/semuaproduk"
                           class="{{ Request::is('semuaproduk') ? 'active' : '' }}">
                            Produk
                        </a>
                    </li>
                    <li>
                        <a href="/tentang"
                           class="{{ Request::is('tentang') ? 'active' : '' }}">
                            Tentang
                        </a>
                    </li>
                    <li>
                        <a href="/contactus"
                           class="{{ Request::is('contactus') ? 'active' : '' }}">
                            Kontak
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="icons-modern">
                <button class="btn hamburger-btn d-md-none"data-bs-toggle="offcanvas"data-bs-target="#mobileMenu">
                    <i class="bi bi-list"></i>
                </button>
                @if(session('name'))
                    <a href="{{ url('/keranjang') }}"class="icon-btn">
                        <i class="bi bi-cart-fill"></i>
                    </a>
                    <a href="{{ url('/riwayat-belanja') }}"class="icon-btn {{ Request::is('riwayat-belanja') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i>
                    </a>
                    <a href="#"class="user-name d-none d-md-flex"data-bs-toggle="modal"data-bs-target="#detailPelangganModal">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ session('name') }}</span>
                    </a>
                    <form action="/logout"method="POST"class="d-none d-md-flex m-0">
                        @csrf
                        <button type="submit" class="logout-circle">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                @else
                    <a href="#"class="icon-btn"data-bs-toggle="modal"data-bs-target="#loginModal">
                        <i class="bi bi-cart-fill"></i>
                    </a>
                    <button class="btn-login d-none d-md-flex"
                        data-bs-toggle="modal"
                        data-bs-target="#loginModal">
                        <i class="bi bi-person-fill"></i>
                        Login
                </button>
                @endif
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-start mobile-menu-modern"tabindex="-1"id="mobileMenu">
        <div class="offcanvas-header border-bottom">
            <h6 class="fw-semibold m-0">Menu</h6>
            <button type="button"class="btn-close"data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="user-card">
                @if(session('name'))
                    <div class="d-flex align-items-center gap-3"data-bs-toggle="modal"data-bs-target="#detailPelangganModal">
                        <div class="avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small">
                                {{ session('name') }}
                            </div>
                            <small class="text-muted">
                                Akun aktif
                            </small>
                        </div>
                    </div>
                    <div class="mobile-action-buttons">
                        <button class="mobile-btn primary-btn"data-bs-toggle="modal"data-bs-target="#detailPelangganModal">
                            Profil
                        </button>
                        <form action="/logout" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="mobile-btn danger-btn">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <button class="btn btn-primary w-100"data-bs-toggle="modal"data-bs-target="#loginModal">
                        Login / Daftar
                    </button>
                @endif
            </div>

            <ul class="menu-list">
                <li>
                    <a href="/">
                        <i class="bi bi-house"></i>
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="/semuaproduk">
                        <i class="bi bi-box"></i>
                        Produk
                    </a>
                </li>
                <li>
                    <a href="/tentang">
                        <i class="bi bi-info-circle"></i>
                        Tentang
                    </a>
                </li>
                <li>
                    <a href="/contactus">
                        <i class="bi bi-envelope"></i>
                        Kontak
                    </a>
                </li>
            </ul>
        </div>
    </div>

    @if (Request::is('/') || Request::is('semuaproduk') || Request::is('tentang') || Request::is('contactus'))
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <section class="hero-section d-flex align-items-center" style="background-image: url('/storage/botol.jpeg');">
                    <div class="container position-relative">
                        <div class="row">
                            <div class="col-lg-6 text-center text-lg-start text-white">
                                <h1 class="fw-bold mb-3 hero-title">
                                    Selamat Datang di <br>
                                    <span>Botol Plastik Riau</span>
                                </h1>
                                <p class="hero-text">
                                    Supplier kebutuhan plastik & packaging berkualitas
                                    untuk UMKM, bisnis, dan kebutuhan rumah tangga Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="carousel-item">
                <section class="hero-section d-flex align-items-center" style="background-image: url('/storage/tentang.jpeg');">
                    <div class="container position-relative">
                        <div class="row">
                            <div class="col-lg-6 text-center text-lg-start text-white">
                                <h1 class="fw-bold mb-3 hero-title">
                                    Produk Berkualitas
                                </h1>
                                <p class="hero-text">
                                    Kami menyediakan berbagai jenis botol dan plastik terbaik.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button"data-bs-target="#heroCarousel"data-bs-slide-to="1"></button>
        </div>
    </div>
    @endif
</header>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .main-header-modern{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;

        z-index: 9999;
        background: white;
    }
        body{
        padding-top: 70px;
    }
    #heroCarousel{
        margin-top: 65px;
    }
    .offcanvas {
        width: 300px !important;
    }
    html,
    body {
        margin: 0;
        padding: 0;
    }
    .main-header-modern {
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        padding: 12px 0;
    }
    .main-header-modern .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }
    .brand-modern {
        text-decoration: none;
        font-size: 24px;
        font-weight: 700;
    }
    .brand-modern span {
        background: linear-gradient(90deg, #1e3f66, #5dade2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .nav-modern ul {
        list-style: none;
        margin: 0;
        padding: 0;

        display: flex;
        align-items: center;
        gap: 18px;
    }
    .nav-modern a {
        text-decoration: none;
        color: #1e3f66;
        font-size: 15px;
        font-weight: 500;
        padding: 7px 16px;
        border-radius: 999px;
        transition: 0.3s;
    }
    .nav-modern a:hover,
    .nav-modern a.active {
        color: #0d6efd;
        background: #eff6ff;
    }
    .icons-modern {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .hamburger-btn {
        border: none;
        padding: 0;
    }
    .hamburger-btn i {
        font-size: 28px;
        color: #1e3f66;
    }
    .icon-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        background: #f1f5f9;
        transition: 0.3s;
    }
    .icon-btn i {
        font-size: 18px;
        color: #1e3f66;
    }
    .icon-btn:hover {
        background: #dbeafe;
    }
    .icon-btn:hover i,
    .icon-btn.active i {
        color: #0d6efd;
    }
    .user-name {
        text-decoration: none;
        color: #1e3f66;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        font-weight: 600;
    }
    .user-name:hover {
        color: #0d6efd;
    }
    .btn-login {
        height: 38px;
        padding: 0 14px;
        border: none;
        border-radius: 8px;

        background: linear-gradient(135deg, #1a284a, #243b6b);
        color: white;

        display: flex;
        align-items: center;
        gap: 6px;

        font-size: 13px;
        transition: 0.2s;
    }
    .btn-login:hover {
        background: linear-gradient(135deg, #243b6b, #1a284a);
    }
    .btn-login:active {
        transform: scale(0.96);
    }
    .logout-circle {
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        transition: 0.3s;
    }
    .logout-circle i {
        color: #1e3f66;
    }
    .logout-circle:hover {
        background: #fee2e2;
    }
    .logout-circle:hover i {
        color: #dc2626;
    }
    .mobile-menu-modern {
        width: 270px;
    }
    .user-card {
        background: #f8fafc;
        padding: 14px;
        border-radius: 14px;
        margin-bottom: 20px;
    }
    .avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #dbeafe;
        color: #2563eb;
    }
    .mobile-action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 14px;
    }
    .mobile-action-buttons form {
        margin: 0;
    }
    .mobile-btn {
        width: 90px;
        height: 32px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 12px;
    }
    .primary-btn {
        background: #0d6efd;
        border: none;
        color: white;
    }
    .danger-btn {
        background: white;
        border: 1px solid #dc3545;
        color: #dc3545;
    }
    .menu-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .menu-list li {
        margin-bottom: 8px;
    }
    .menu-list a {
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 14px;
        border-radius: 10px;
        color: #334155;
        font-size: 14px;
        transition: 0.3s;
    }
    .menu-list a:hover {
        background: #dbeafe;
        color: #2563eb;
    }
    .hero-section {
        min-height: 460px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .hero-section::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
    }
    .hero-section .container {
        position: relative;
        z-index: 2;
    }
    .hero-title {
        font-size: 2.7rem;
        color: #ffffff;
    }
    .hero-title span {
        color: #8ec5ff;
    }
    .hero-text {
        font-size: 16px;
        line-height: 1.7;
    }
    @media (max-width: 768px) {
        .main-header-modern {
            padding: 10px 0;
        }
        .main-header-modern .container {
            flex-direction: row;
            align-items: center;
        }
        .brand-modern {
            font-size: 18px;
        }
        .icons-modern {
            gap: 8px;
        }
        .icon-btn {
            width: 35px;
            height: 35px;
        }
        .icon-btn i {
            font-size: 16px;
        }
        .hero-section {
            min-height: 320px;
            padding: 40px 0;
        }
        .hero-title {
            font-size: 1.8rem;
            text-align: center;
        }
        .hero-text {
            font-size: 14px;
            text-align: center;
        }
    }
</style>