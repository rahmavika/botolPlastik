<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header" style="
            background: linear-gradient(to right, #f4f4f4, #ffffff);
            padding: 10px 15px;
            border-radius: 4px;
        ">
            <link href="https://fonts.googleapis.com/css2?family=Marcellus&display=swap" rel="stylesheet">
            <a href="/welcome" class="b-brand" style="text-decoration: none;">
                <span style="
                    font-family: 'Marcellus', serif;
                    font-size: 1rem;
                    color: #2f4f4f;
                    letter-spacing: 2px;
                ">
                    Botol Plastik Riau
                </span>
            </a>
        </div>
    </div>

    <div class="navbar-content">
        <ul class="pc-navbar">
            <li class="pc-item">
                <a href="/dashboard" class="pc-link">
                    <span class="pc-micon"><i class="bi bi-graph-up"></i></span>
                    <span class="pc-mtext">Dashboard</span>
                </a>
            </li>
            <li class="pc-item pc-caption">
                <label>Produk dan Stok</label>
            </li>
            <li class="pc-item">
                <a href="/dashboard-produk" class="pc-link">
                    <span class="pc-micon"><i class="bi bi-box"></i></span>
                    <span class="pc-mtext">Produk</span>
                </a>
            </li>
            <li class="pc-item">
                <a href="/dashboard-stok" class="pc-link">
                    <span class="pc-micon"><i class="bi bi-archive"></i></span>
                    <span class="pc-mtext">Stok Produk</span>
                </a>
            </li>
            <li class="pc-item">
                <a href="/dashboard-mutasi" class="pc-link">
                    <span class="pc-micon"><i class="bi bi-box-seam"></i></span>
                    <span class="pc-mtext">Log Stok</span>
                </a>
            </li>
            <li class="pc-item pc-caption">
                <label>Penjualan</label>
            </li>
            <li class="pc-item">
                <a href="/dashboard-pesanan" class="pc-link">
                    <span class="pc-micon"><i class="bi bi-clipboard-data"></i></span>
                    <span class="pc-mtext">Pesanan Masuk</span>
                </a>
            </li>
            <li class="pc-item">
                <a href="/dashboard-penjualan" class="pc-link">
                    <span class="pc-micon"><i class="bi bi-cash-stack"></i></span>
                    <span class="pc-mtext">Penjualan</span>
                </a>
            </li>
            <li class="pc-item pc-caption">
                <label>Lainnya</label>
            </li>
            <li class="pc-item">
                <a href="/dashboard-pengguna" class="pc-link">
                    <span class="pc-micon"><i class="bi bi-people"></i></span>
                    <span class="pc-mtext">Data Pengguna</span>
                </a>
            </li>
            <li class="pc-item">
                <a href="/contact-us" class="pc-link">
                    <span class="pc-micon"><i class="bi bi-envelope"></i></span>
                    <span class="pc-mtext">Contact Us</span>
                </a>
            </li>

            <li class="pc-item">
                <form id="logout-form" action="/logout" method="POST">
                    @csrf
                    <a href="#" class="pc-link" onclick="document.getElementById('logout-form').submit();">
                        <span class="pc-micon"><i class="bi bi-box-arrow-right"></i></span>
                        <span class="pc-mtext">Sign out</span>
                    </a>
                </form>
            </li>

        </ul>
    </div>
</nav>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .pc-micon i {
    font-size: 18px;
    font-weight: 300;
    color: #5a6c7d;
    transition: 0.3s;
    }

    .pc-link:hover .pc-micon i {
        color: #0d6efd;
        transform: scale(1.1);
    }
    /* ACTIVE STATE → warna donker */
    .pc-item.active > .pc-link {
        background: #0b2a4a !important;  /* donker */
        color: #ffffff !important;
        border-right: 4px solid #082033;  /* donker lebih gelap */
    }

    /* Icon ikut putih saat aktif */
    .pc-item.active > .pc-link .pc-micon i {
        color: #ffffff !important;
    }
    /* Hilangkan border kanan bawaan */
    .pc-item.active > .pc-link {
        background: #0b2a4a !important;  /* donker */
        color: #ffffff !important;
        border-right: none !important;   /* HAPUS GARIS BIRU */
    }
    /* Icon ikut putih saat aktif */
    .pc-item.active > .pc-link .pc-micon i {
        color: #ffffff !important;
    }
</style>