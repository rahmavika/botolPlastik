<nav class="pc-sidebar">
    <div class="m-header sidebar-logo">
        <div class="logo-wrapper">
            <div class="logo-icon">
                <i class="fas fa-bottle-water"></i>
            </div>

            <div class="logo-text">
                <span class="logo-title">Botol Plastik</span>
                <small class="logo-subtitle">RIAU</small>
            </div>
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
    .sidebar-logo {
        padding: 18px 16px;
        margin: 12px;
        border-radius: 16px;
        background: linear-gradient(135deg, #ffffff, #f8fafc);
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
    }

    .logo-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        box-shadow: 0 4px 10px rgba(30, 58, 138, 0.2);
    }

    .logo-text {
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }

    .logo-title {
        font-family: 'Marcellus', serif;
        font-size: 20px;
        color: #1e3a8a;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .logo-subtitle {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 4px;
        color: #64748b;
    }

    /* ICON DEFAULT */
    .pc-micon i {
        font-size: 18px;
        font-weight: 300;
        color: #5a6c7d;
        transition: all 0.3s ease;
    }

    /* HOVER */
    .pc-link:hover {
        background: #eff6ff;
        border-radius: 10px;
    }

    .pc-link:hover .pc-micon i,
    .pc-link:hover .pc-mtext {
        color: #1e3a8a;
        transform: scale(1.05);
    }

    /* ACTIVE / ON CLICK */
    .pc-item.active > .pc-link {
        background: linear-gradient(135deg, #1e3a8a, #3b82f6) !important;
        color: #ffffff !important;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
        border-right: none !important;
    }

    /* ICON ACTIVE */
    .pc-item.active > .pc-link .pc-micon i {
        color: #ffffff !important;
    }

    /* TEXT ACTIVE */
    .pc-item.active > .pc-link .pc-mtext {
        color: #ffffff !important;
        font-weight: 600;
    }
</style>