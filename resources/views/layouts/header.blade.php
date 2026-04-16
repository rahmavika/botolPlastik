<header class="pc-header">
    <div class="header-wrapper">
        <div class="me-auto pc-mob-drp d-flex align-items-center">
            <ul class="list-unstyled d-flex align-items-center mb-0">
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="ms-auto d-flex align-items-center">
            <ul class="navbar-nav d-flex align-items-center mb-0">
                <li class="nav-item px-3">
                    @if (session('name'))
                        <a href="#" style="color: #07582d; font-size: 16px; text-decoration: none;">
                            <span class="me-2">
                                <i class="bi bi-per son-fill" style="color: #07582d;"></i>
                                {{ session('name') }}
                            </span>
                        </a>
                    @else
                        <button class="btn-login" style="border-color: #07582d; transition: background-color 0.3s, color 0.3s;" onclick="window.location.href='/login';">
                            <i class="bi bi-person-fill" ></i> Login
                        </button>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</header>
