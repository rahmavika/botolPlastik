<header class="header-modern shadow-sm">

    <div class="main-header-modern">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/" class="brand-modern">
                <span>Botol Plastik Riau</span>
            </a>
            <nav class="nav-modern d-none d-md-block">
                <ul>
                    <li><a href="/" class="{{ Request::is('/') ? 'active' : '' }}">Beranda</a></li>
                    <li><a href="/semuaproduk" class="{{ Request::is('semuaproduk') ? 'active' : '' }}">Produk</a></li>
                    <li><a href="/tentang" class="{{ Request::is('tentang') ? 'active' : '' }}">Tentang</a></li>
                    <li><a href="/contactus" class="{{ Request::is('contactus') ? 'active' : '' }}">Kontak</a></li>
                </ul>
            </nav>

            <!-- ICONS + LOGIN -->
            <div class="icons-modern d-flex align-items-center ">

                <form action="/semuaproduk" method="GET" id="searchForm" class="search-box d-none d-md-flex align-items-center">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                </form>

                <!-- CART ICON -->
                @if(session('name'))
                    <a href="{{ url('/keranjang') }}" class="icon-btn">
                        <i class="bi bi-cart-fill"></i>
                    </a>

                    <a href="{{ url('/riwayat-belanja') }}" class="icon-btn ms-3 {{ Request::is('riwayat-belanja') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i>
                    </a>
                @else
                    <a href="#" class="icon-btn" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                @endif

                <!-- LOGIN BUTTON NOW HERE -->
                @if(session('name'))
                <a href="#" class="user-name ms-3"
                data-bs-toggle="modal"
                data-bs-target="#detailPelangganModal">
                 <i class="bi bi-person-circle"></i> {{ session('name') }}
             </a>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout ms-2">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                @else
                <button class="btn-login ms-3"
                data-bs-toggle="modal"
                data-bs-target="#loginModal">
            <i class="bi bi-person-fill"></i> Login
        </button>
                @endif

                <!-- MOBILE SEARCH -->
                <button class="search-mobile d-md-none ms-2" data-bs-toggle="modal" data-bs-target="#searchModal">
                    <i class="bi bi-search"></i>
                </button>

            </div>

        </div>
    </div>
    @if (Request::is('/') || Request::is('semuaproduk') || Request::is('tentang') || Request::is('contactus'))
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <section class="hero-section d-flex align-items-center"
                    style="background-image: url('/storage/botol.jpeg');">

                    <div class="container position-relative">
                        <div class="row">
                            <div class="col-lg-6 text-center text-lg-start text-white">
                                <h1 class="fw-bold mb-3" style="font-size: 2.7rem; color: #010b19">
                                    Selamat Datang di<br>
                                    <span style="color: #010b19;">Botol Plastik Riau</span>
                                </h1>
                                <p>
                                    Supplier kebutuhan plastik & packaging berkualitas untuk UMKM,
                                    bisnis, dan kebutuhan rumah tangga Anda.
                                </p>
                            </div>
                        </div>
                    </div>

                </section>
            </div>

            <div class="carousel-item">
                <section class="hero-section d-flex align-items-center"
                    style="background-image: url('/storage/tentang.jpeg');">

                    <div class="container position-relative">
                        <div class="row">
                            <div class="col-lg-6 text-center text-lg-start text-white">
                                <h1 class="fw-bold mb-3" style="color: #010b19">Produk Berkualitas</h1>
                                <p>Kami menyediakan berbagai jenis botol dan plastik terbaik.</p>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        </div>
    </div>
    @endif
</header>
<script>
let timer;

const input = document.getElementById('searchInput');
const form = document.getElementById('searchForm');

input.addEventListener('keyup', function () {
    clearTimeout(timer);

    timer = setTimeout(() => {
        if (input.value.length >= 2 || input.value.length === 0) {
            form.submit();
        }
    }, 500);
});
</script>
<style>
    /* .main-header-modern {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 9999;
    background: #fff;
} */

.hero-section {
    width: 100%;
    min-height: 450px;
    padding: 70px 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
}

.hero-section::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5); /* overlay gelap */
}

/* Biar teks di atas overlay */
.hero-section .container {
    position: relative;
    z-index: 2;
}
.brand-modern {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    color: #1e3f66;
    text-decoration: none;
    cursor: default;
}

/* Gradient text brand */
.brand-modern span {
    background: linear-gradient(90deg, #1e3f66, #5dade2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* === MAIN HEADER === */
.main-header-modern {
    padding: 12px 0;
    background: #ffffff;    /* putih bersih */
    border-bottom: 1px solid #e6ecf5;
}

/* RESET TOP BAR (hapus) */
.top-bar-modern {
    display: none !important;
}

/* NAVIGATION */
.nav-modern ul {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
    gap: 18px;
}

.nav-modern a {
    font-size: 15px;
    color: #1e3f66;
    text-decoration: none;
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 6px;
    transition: 0.25s ease;
}

/* Hover & Active nav — dongker halus */
.nav-modern a {
    position: relative;
    padding: 6px 16px;
    border-radius: 999px;
    transition: 0.3s;
}

.nav-modern a {
    padding: 6px 16px;
    border-radius: 999px;
    transition: 0.3s;
}

/* ACTIVE */
.nav-modern a.active {
    color: #4875ac;
    border: 2px solid #4875ac;
    background: transparent;
}

/* === SEARCH BOX === */
.search-box {
    border: 1px solid #d0e2f7;
    border-radius: 8px;
    padding: 2px 8px;
}

.search-box input {
    border: none;
    outline: none;
    font-size: 14px;
}

.search-box button {
    background: transparent;
    border: none;
    color: #1e3f66;
}

/* MOBILE SEARCH BUTTON */
.search-mobile {
    background: #c0c7d1;
    border: none;
    padding: 6px;
    border-radius: 6px;
    color: white;
}

/* === ICONS & WRAPPER === */
.icons-modern {
    display: flex;
    align-items: center;
    gap: 12px;
}

.icons-modern .icon-btn i {
    font-size: 18px;
    color: #1e3f66;
    transition: 0.3s;
}

.icons-modern .icon-btn:hover i {
    color: #0d6efd;
}

/* USER NAME */
.user-name {
    font-size: 14px;
    color: #1e3f66;
    text-decoration: none;
    transition: 0.25s;
}

.user-name:hover {
    color: #0d6efd;
}

/* LOGIN & LOGOUT BUTTON */
.btn-login,
.btn-logout {
    background-color: #0D1321;
    color: #ffffff;
    border: none;
    padding: 7px 16px;
    border-radius: 6px;
    font-size: 14px;
    transition: 0.25s;
}

.btn-login:hover,
.btn-logout:hover {
    background-color: #162036;
    color: #ffffff;
}

/* RESET TOTAL */
html, body {
    margin: 0;
    padding: 0;
}

/* HEADER FULL RESET */
.header-modern {
    margin: 0;
    padding: 0;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">