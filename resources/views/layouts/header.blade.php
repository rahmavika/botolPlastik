<header class="pc-header custom-header">
    <div class="header-wrapper">
        <div class="me-auto d-flex align-items-center">
            <button class="mobile-menu-btn d-lg-none"id="mobileSidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="list-unstyled d-none d-lg-flex align-items-center mb-0">
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0 custom-menu-btn" id="sidebar-hide">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="ms-auto d-flex align-items-center">
            <ul class="navbar-nav d-flex align-items-center mb-0">
                <li class="nav-item px-2 px-md-3">
                    @if (session('name'))
                    <div class="user-info">
                        <span class="profile-icon me-2">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <span class="user-name">
                            {{ session('name') }}
                        </span>
                    </div>
                    @else
                        <button class="btn-login" onclick="window.location.href='/login';">
                            <i class="bi bi-person-fill me-1"></i>
                            <span class="d-none d-sm-inline">
                                Login
                            </span>
                        </button>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</header>
<style>
    .custom-header {
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        padding: 10px 16px;
        position: sticky;
        top: 0;
        z-index: 1040;
    }
    .header-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .mobile-menu-btn,
    .custom-menu-btn {
        width: 42px;
        height: 42px;
        border: none;
        border-radius: 12px;
        background: #f8fafc;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s ease;
    }
    .mobile-menu-btn:hover,
    .custom-menu-btn:hover {
        background: #1e3a8a;
        color: white;
    }
    .user-info {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: #334155;
    }
    .profile-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-login {
        border: 1px solid #1e3a8a;
        color: #1e3a8a;
        background: transparent;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
    }
    .btn-login:hover {
        background: #1e3a8a;
        color: white;
    }
    @media (max-width: 991px) {
        .custom-header {
            padding: 10px 14px;
        }
        .user-name {
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
        }
    }
</style>