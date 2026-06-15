@php
    $unreadNotifications = \App\Models\AppNotification::where('user_id', auth()->id())
        ->whereNull('read_at')
        ->latest()
        ->take(5)
        ->get();

    $unreadNotificationCount = \App\Models\AppNotification::where('user_id', auth()->id())
        ->whereNull('read_at')
        ->count();
@endphp
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

                {{-- Theme Switcher --}}
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph ph-sun-dim"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
                            <i class="ph ph-moon"></i>
                            <span>Dark</span>
                        </a>

                        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
                            <i class="ph ph-sun"></i>
                            <span>Light</span>
                        </a>

                        <a href="#!" class="dropdown-item" onclick="layout_change_default()">
                            <i class="ph ph-cpu"></i>
                            <span>Default</span>
                        </a>
                    </div>
                </li>

                {{-- Notifications --}}
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">

                        <i class="ph ph-bell"></i>

                        @if ($unreadNotificationCount > 0)
                            <span class="badge bg-danger pc-h-badge">{{ $unreadNotificationCount }}</span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Notifications</h5>

                            @if ($unreadNotificationCount > 0)
                                <form method="POST" action="{{ route('notifications.read-all') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link btn-sm">
                                        Mark all read
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="dropdown-body text-wrap header-notification-scroll position-relative"
                            style="max-height: calc(100vh - 215px)">

                            @forelse ($unreadNotifications as $notification)
                                <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                    @csrf

                                    <button type="submit"
                                        class="dropdown-item p-0 border-0 bg-transparent w-100 text-start">
                                        <div class="card bg-transparent mb-2 border-0">
                                            <div class="card-body p-3 rounded"
                                                style="background: rgba(var(--bs-light-rgb), 0.3); transition: all 0.2s ease;"
                                                onmouseover="this.style.background='rgba(var(--bs-primary-rgb), 0.05)'"
                                                onmouseout="this.style.background='rgba(var(--bs-light-rgb), 0.3)'">

                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 40px; height: 40px;">
                                                            <i class="ph ph-bell text-primary"
                                                                style="font-size: 16px;"></i>
                                                        </div>
                                                    </div>

                                                    <div class="flex-grow-1 ms-3">
                                                        <span class="float-end text-sm text-muted">
                                                            {{ $notification->created_at->diffForHumans() }}
                                                        </span>

                                                        <h5 class="text-body mb-2">
                                                            {{ $notification->title }}
                                                        </h5>

                                                        <p class="mb-0">
                                                            {{ $notification->message }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            @empty
                                <div class="text-center py-4">
                                    <i class="ph ph-bell-slash d-block mb-2" style="font-size: 28px;"></i>
                                    <p class="mb-0 text-muted">No new notifications</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="text-center py-2">
                            <a href="#!" class="link-primary">View all Notifications</a>
                        </div>
                    </div>
                </li>

                {{-- User Profile --}}
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <i class="ph ph-user-circle"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <h6 class="mb-0">{{ auth()->user()?->name }}</h6>
                            <small class="text-muted">{{ auth()->user()?->email }}</small>
                            <br>
                            <span class="badge bg-success-subtle text-success mt-1 text-capitalize">
                                {{ auth()->user()?->role }}
                            </span>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="ph ph-user-circle"></i>
                            <span>Profile</span>
                        </a>

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
