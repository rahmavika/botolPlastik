<header class="pc-header custom-header">
    <div class="header-wrapper">
        <div class="me-auto pc-mob-drp d-flex align-items-center">
            <ul class="list-unstyled d-flex align-items-center mb-0">
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0 custom-menu-btn" id="sidebar-hide">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="ms-auto d-flex align-items-center">
            <ul class="navbar-nav d-flex align-items-center mb-0">
                <li class="nav-item px-3">
                    @if (session('name'))
                    <div>
                        <span class="d-flex align-items-center">
                            <span class="profile-icon me-2">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            {{ session('name') }}
                        </span>
                    </div>
                    @else
                        <button class="btn-login"
                            onclick="window.location.href='/login';">
                            <i class="bi bi-person-fill me-1"></i> Login
                        </button>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</header>

<style>
    .profile-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        box-shadow: 0 2px 6px rgba(30, 58, 138, 0.25);
    }
    .custom-header {
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        padding: 6px 0;
    }

    .custom-menu-btn {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1e3a8a !important;
        transition: all 0.3s ease;
    }

    .custom-menu-btn:hover {
        background: #1e3a8a;
        color: #ffffff !important;
        transform: scale(1.05);
    }

    .btn-login {
        border: 1px solid #1e3a8a;
        color: #1e3a8a;
        background: transparent;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        background: #1e3a8a;
        color: #ffffff;
    }
</style>