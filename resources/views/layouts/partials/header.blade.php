<header class="pc-header">
    <div class="header-wrapper">
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ph ph-list"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ph ph-list"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button">
                        <i class="ph ph-sun-dim"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="#" class="dropdown-item" onclick="layout_change('dark')">
                            <i class="ph ph-moon"></i>
                            <span>Dark</span>
                        </a>
                        <a href="#" class="dropdown-item" onclick="layout_change('light')">
                            <i class="ph ph-sun"></i>
                            <span>Light</span>
                        </a>
                    </div>
                </li>
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button">
                        <i class="ph ph-user-circle"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-item-text">
                            <strong>{{ auth()->user()?->name }}</strong>
                            <div class="text-muted text-capitalize">{{ auth()->user()?->role }}</div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="ph ph-sign-out"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
