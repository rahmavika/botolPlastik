<div class="mobile-overlay" id="mobileOverlay"></div>
<nav class="pc-sidebar" id="mobileSidebar">
    <div class="sidebar-mobile-top d-lg-none">
        <button class="close-sidebar-btn" id="closeSidebar">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
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
                <a href="/dashboard-log" class="pc-link">
                    <span class="pc-micon"><i class="bi bi-box-seam"></i></span>
                    <span class="pc-mtext">Log Stok</span>
                </a>
            </li>
            <li class="pc-item">
                <a href="/dashboard-mutasi" class="pc-link">
                    <span class="pc-micon"><i class="bi bi-arrow-left-right"></i></span>
                    <span class="pc-mtext">Mutasi Stok</span>
                </a>
            </li>
            <li class="pc-item pc-caption">
                <label>Penjualan</label>
            </li>
            <li class="pc-item">
                <a href="/dashboard-pesanan" class="pc-link">
                    <span class="pc-micon"><i class="bi bi-clipboard-data"></i></span>
                    <span class="pc-mtext">Pesanan</span>
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
                <a href="#" class="pc-link"data-bs-toggle="modal"data-bs-target="#logoutModal">
                    <span class="pc-micon">
                        <i class="bi bi-box-arrow-right"></i>
                    </span>
                    <span class="pc-mtext">
                        Log out
                    </span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body text-center px-4 pt-4 pb-2">
                <div class="mb-3">
                    <i class="bi bi-box-arrow-right fs-2 text-danger"></i>
                </div>
                <h6 class="fw-semibold mb-1">Keluar dari akun?</h6>
                <p class="text-muted small mb-0">
                    Anda akan mengakhiri sesi saat ini
                </p>
            </div>
            <div class="modal-footer border-0 pt-2 pb-3 px-3 d-flex">
                <button type="button"class="btn btn-light flex-fill me-2"data-bs-dismiss="modal">
                    Batal
                </button>
                <form action="/logout" method="POST" class="flex-fill">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .pc-sidebar {
        width: 280px;
        height: 100vh;
        background: #ffffff;
        border-right: 1px solid #e5e7eb;
        position: fixed;
        top: 0;
        left: 0;
        overflow-y: auto;
        z-index: 1050;
        transition: all 0.3s ease;
    }
    .sidebar-mobile-top {
        display: flex;
        justify-content: flex-end;
        padding: 14px 14px 0;
    }
    .close-sidebar-btn {
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 10px;
        background: #f1f5f9;
        color: #1e3a8a;
    }
    .mobile-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 1045;
        opacity: 0;
        visibility: hidden;
        transition: 0.3s ease;
    }
    .mobile-overlay.active {
        opacity: 1;
        visibility: visible;
    }
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
    }
    .logo-title {
        font-size: 20px;
        color: #1e3a8a;
        font-weight: 700;
    }
    .logo-subtitle {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 4px;
        color: #64748b;
    }
    .pc-navbar {
        padding: 10px;
    }
    .pc-item {
        list-style: none;
        margin-bottom: 4px;
    }
    .pc-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 12px;
        text-decoration: none;
        transition: 0.3s ease;
    }
    .pc-link:hover {
        background: #eff6ff;
    }
    .pc-micon i {
        font-size: 18px;
        color: #5a6c7d;
    }
    .pc-mtext {
        color: #334155;
        font-weight: 500;
    }
    .pc-item.active > .pc-link {
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    }
    .pc-item.active > .pc-link .pc-micon i,
    .pc-item.active > .pc-link .pc-mtext {
        color: white;
    }
    .pc-caption {
        margin-top: 4px;
        margin-bottom: 2px;
        padding: 0 14px;
    }
    .pc-caption label {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    @media (max-width: 991px) {
        .pc-sidebar {
            transform: translateX(-100%);
            width: 290px;
        }
        .pc-sidebar.mobile-open {
            transform: translateX(0);
        }

    }
</style>
<script>
    const sidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('mobileOverlay');
    const openBtn = document.getElementById('mobileSidebarToggle');
    const closeBtn = document.getElementById('closeSidebar');

    openBtn.addEventListener('click', function () {
        sidebar.classList.add('mobile-open');
        overlay.classList.add('active');
    });

    closeBtn.addEventListener('click', function () {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
    });

    overlay.addEventListener('click', function () {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
    });
</script>