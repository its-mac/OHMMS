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

                @php
                    $dashboardRoute = match (auth()->user()?->role) {
                        'admin' => 'admin.dashboard',
                        'manager' => 'manager.dashboard',
                        'student' => 'student.dashboard',
                        default => 'dashboard',
                    };
                @endphp

                <li
                    class="pc-item {{ request()->routeIs($dashboardRoute) || request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route($dashboardRoute) }}" class="pc-link">
                        <span class="pc-micon"><i class="ph ph-house-line"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                @if (auth()->user()?->role === 'admin')
                    <li class="pc-item pc-caption">
                        <label>Administration</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.managers.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.managers.index') }}" class="pc-link">
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
                        <label>Infrastructure</label>
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

                    <li class="pc-item pc-caption">
                        <label>Configuration</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.meal-sessions.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.meal-sessions.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-clock"></i></span>
                            <span class="pc-mtext">Meal Sessions</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.fee-structures.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.fee-structures.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-money"></i></span>
                            <span class="pc-mtext">Fee Structures</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Monitoring & Reports</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.reports.analytics') ? 'active' : '' }}">
                        <a href="{{ route('admin.reports.analytics') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-chart-bar"></i></span>
                            <span class="pc-mtext">Analytics Dashboard</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.complaints.escalated*') ? 'active' : '' }}">
                        <a href="{{ route('admin.complaints.escalated') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-warning-octagon"></i></span>
                            <span class="pc-mtext">Escalated Complaints</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.finance-reports.defaulters') ? 'active' : '' }}">
                        <a href="{{ route('admin.finance-reports.defaulters') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-warning-circle"></i></span>
                            <span class="pc-mtext">Defaulters Report</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('admin.finance-reports.collections') ? 'active' : '' }}">
                        <a href="{{ route('admin.finance-reports.collections') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-chart-line-up"></i></span>
                            <span class="pc-mtext">Collection Report</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()?->role === 'manager')
                    <li class="pc-item pc-caption">
                        <label>Hostel Operations</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('manager.room-allocations.*') ? 'active' : '' }}">
                        <a href="{{ route('manager.room-allocations.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-user-switch"></i></span>
                            <span class="pc-mtext">Room Allocations</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Mess Operations</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('manager.mess-menus.*') ? 'active' : '' }}">
                        <a href="{{ route('manager.mess-menus.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-tools-kitchen-2"></i></span>
                            <span class="pc-mtext">Mess Menu</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('manager.guest-meals.*') ? 'active' : '' }}">
                        <a href="{{ route('manager.guest-meals.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-users-three"></i></span>
                            <span class="pc-mtext">Guest Meals</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('manager.mess-offs.*') ? 'active' : '' }}">
                        <a href="{{ route('manager.mess-offs.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-calendar-x"></i></span>
                            <span class="pc-mtext">Mess Off Requests</span>
                        </a>
                    </li>

                    <li
                        class="pc-item pc-hasmenu {{ request()->routeIs('manager.attendance.*') ? 'active pc-trigger' : '' }}">
                        <a href="#" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-fingerprint"></i></span>
                            <span class="pc-mtext">Attendance</span>
                            <span class="pc-arrow"><i class="ph ph-caret-right"></i></span>
                        </a>

                        <ul class="pc-submenu">

                            <li class="pc-item {{ request()->routeIs('manager.attendance.scan') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('manager.attendance.scan') }}">
                                    Scan Attendance
                                </a>
                            </li>

                            <li class="pc-item {{ request()->routeIs('manager.attendance.today') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('manager.attendance.today') }}">
                                    Today's Attendance
                                </a>
                            </li>

                            <li class="pc-item {{ request()->routeIs('manager.attendance.index') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('manager.attendance.index') }}">
                                    Attendance Logs
                                </a>
                            </li>

                            <li
                                class="pc-item {{ request()->routeIs('manager.attendance.reports') ? 'active' : '' }}">
                                <a class="pc-link" href="{{ route('manager.attendance.reports') }}">
                                    Reports
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Student Services</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('manager.leave-requests.*') ? 'active' : '' }}">
                        <a href="{{ route('manager.leave-requests.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-calendar-check"></i></span>
                            <span class="pc-mtext">Leave Requests</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('manager.gate-passes.*') ? 'active' : '' }}">
                        <a href="{{ route('manager.gate-passes.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-door-open"></i></span>
                            <span class="pc-mtext">Gate Passes</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('manager.complaints.*') ? 'active' : '' }}">
                        <a href="{{ route('manager.complaints.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-chat-circle-text"></i></span>
                            <span class="pc-mtext">Complaints</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Finance</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('manager.invoices.*') ? 'active' : '' }}">
                        <a href="{{ route('manager.invoices.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-file-text"></i></span>
                            <span class="pc-mtext">Invoices / Challans</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('manager.invoices.generate-monthly') ? 'active' : '' }}">
                        <a href="{{ route('manager.invoices.generate-monthly') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-calendar-plus"></i></span>
                            <span class="pc-mtext">Generate Monthly Fees</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('manager.payment-proofs.*') ? 'active' : '' }}">
                        <a href="{{ route('manager.payment-proofs.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph ph-receipt"></i>
                            </span>
                            <span class="pc-mtext">
                                Payment Proofs
                            </span>
                        </a>
                    </li>

                    <li
                        class="pc-item {{ request()->routeIs('manager.finance-reports.defaulters') ? 'active' : '' }}">
                        <a href="{{ route('manager.finance-reports.defaulters') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-warning-circle"></i></span>
                            <span class="pc-mtext">Defaulters</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Reports</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('manager.reports.analytics') ? 'active' : '' }}">
                        <a href="{{ route('manager.reports.analytics') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-chart-bar"></i></span>
                            <span class="pc-mtext">Reports & Analytics</span>
                        </a>
                    </li>
                    <li
                        class="pc-item {{ request()->routeIs('manager.finance-reports.collections') ? 'active' : '' }}">
                        <a href="{{ route('manager.finance-reports.collections') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-chart-line-up"></i></span>
                            <span class="pc-mtext">Collection Report</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()?->role === 'student')
                    <li class="pc-item pc-caption">
                        <label>Student Portal</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('student.profile.*') ? 'active' : '' }}">
                        <a href="{{ route('student.profile.show') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-user"></i></span>
                            <span class="pc-mtext">My Profile</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('student.room.*') ? 'active' : '' }}">
                        <a href="{{ route('student.room.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-bed"></i></span>
                            <span class="pc-mtext">My Room</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Mess</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('student.mess-menu.*') ? 'active' : '' }}">
                        <a href="{{ route('student.mess-menu.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-fork-knife"></i></span>
                            <span class="pc-mtext">Weekly Menu</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('student.attendance.*') ? 'active' : '' }}">
                        <a href="{{ route('student.attendance.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-fingerprint"></i></span>
                            <span class="pc-mtext">Attendance History</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Requests</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('student.mess-offs.*') ? 'active' : '' }}">
                        <a href="{{ route('student.mess-offs.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-calendar-x"></i></span>
                            <span class="pc-mtext">Mess Off</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('student.guest-meals.*') ? 'active' : '' }}">
                        <a href="{{ route('student.guest-meals.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-users-three"></i></span>
                            <span class="pc-mtext">Guest Meals</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('student.gate-passes.*') ? 'active' : '' }}">
                        <a href="{{ route('student.gate-passes.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-door-open"></i></span>
                            <span class="pc-mtext">Gate Passes</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('student.complaints.*') ? 'active' : '' }}">
                        <a href="{{ route('student.complaints.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-chat-circle-text"></i></span>
                            <span class="pc-mtext">Complaints</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->routeIs('student.leave-requests.*') ? 'active' : '' }}">
                        <a href="{{ route('student.leave-requests.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-calendar-check"></i></span>
                            <span class="pc-mtext">Leave Requests</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Finance</label>
                    </li>

                    <li class="pc-item {{ request()->routeIs('student.fees.*') ? 'active' : '' }}">
                        <a href="{{ route('student.fees.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-money"></i></span>
                            <span class="pc-mtext">My Fees</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
