<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('dashboard') }}" class="b-brand text-primary">
                <img src="{{ asset('assets/images/logo-white.svg') }}" class="img-fluid logo-lg" alt="logo">
            </a>
        </div>

        <div class="navbar-content">
            <ul class="pc-navbar">

                <li class="pc-item pc-caption">
                    <label>Navigation</label>
                </li>

                <li class="pc-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ph ph-house-line"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                @if (auth()->user()?->role === 'admin')
                    <li class="pc-item pc-caption">
                        <label>Administration</label>
                    </li>

                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-users-three"></i></span>
                            <span class="pc-mtext">Managers</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.students.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-student"></i></span>
                            <span class="pc-mtext">Students</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Hostel Structure</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.hostels.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.hostels.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-buildings"></i></span>
                            <span class="pc-mtext">Hostels</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.blocks.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.blocks.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-squares-four"></i></span>
                            <span class="pc-mtext">Blocks</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.floors.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.floors.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-stack"></i></span>
                            <span class="pc-mtext">Floors</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.rooms.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-door-open"></i></span>
                            <span class="pc-mtext">Rooms</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.room-allocations.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.room-allocations.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-user-switch"></i></span>
                            <span class="pc-mtext">Room Allocations</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Mess & Attendance</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.meal-sessions.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.meal-sessions.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-clock"></i></span>
                            <span class="pc-mtext">Meal Sessions</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.mess-menus.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.mess-menus.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="ti ti-tools-kitchen-2"></i>
                            </span>
                            <span class="pc-mtext">Mess Menu</span>
                        </a>
                    </li>

                    <li
                        class="pc-item pc-hasmenu {{ request()->routeIs('admin.attendance.*') ? 'active pc-trigger' : '' }}">
                        <a href="#" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-fingerprint"></i></span>
                            <span class="pc-mtext">Attendance</span>
                            <span class="pc-arrow"><i class="ph ph-caret-right"></i></span>
                        </a>

                        <ul class="pc-submenu">
                            <li class="pc-item {{ request()->routeIs('admin.attendance.scan') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('admin.attendance.scan') }}">
                                    Scan Attendance
                                </a>
                            </li>

                            <li class="pc-item {{ request()->routeIs('admin.attendance.today') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('admin.attendance.today') }}">
                                    Today's Attendance
                                </a>
                            </li>

                            <li class="pc-item {{ request()->routeIs('admin.attendance.index') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('admin.attendance.index') }}">
                                    Attendance Logs
                                </a>
                            </li>

                            <li class="pc-item {{ request()->routeIs('admin.attendance.reports') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('admin.attendance.reports') }}">
                                    Reports
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-fork-knife"></i></span>
                            <span class="pc-mtext">Mess Management</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
