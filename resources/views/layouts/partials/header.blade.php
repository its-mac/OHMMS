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

                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown p-0"
                        style="width: 360px; border-radius: 10px; overflow: hidden;">

                        <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom">
                            <h6 class="mb-0 fw-semibold">Notifications</h6>
                        </div>

                        <div style="max-height: 360px; overflow-y: auto;">
                            @forelse ($unreadNotifications as $notification)
                                <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                    @csrf

                                    <button type="submit" class="w-100 border-0 bg-transparent text-start p-0">
                                        <div class="d-flex gap-3 px-3 py-3 border-bottom notification-dropdown-item">
                                            <div class="flex-shrink-0">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary"
                                                    style="width: 38px; height: 38px;">
                                                    <i class="ph ph-bell" style="font-size: 18px;"></i>
                                                </div>
                                            </div>

                                            <div class="flex-grow-1 overflow-hidden">
                                                <div class="d-flex justify-content-between align-items-start gap-2">
                                                    <h6 class="mb-1 text-truncate fw-semibold">
                                                        {{ $notification->title }}
                                                    </h6>

                                                    <span class="rounded-circle bg-primary flex-shrink-0 mt-1"
                                                        style="width: 8px; height: 8px;"></span>
                                                </div>

                                                <p class="mb-1 text-muted text-truncate">
                                                    {{ $notification->message }}
                                                </p>

                                                <small class="text-muted">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            @empty
                                <div class="text-center py-4">
                                    <i class="ph ph-bell-slash d-block mb-2 text-muted" style="font-size: 30px;"></i>
                                    <p class="mb-0 text-muted">No new notifications</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="border-top p-2 text-center">
                            <a href="{{ route('notifications.index') }}" class="btn btn-link btn-sm text-primary w-100">
                                View all notifications
                            </a>
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

@push('page-css')
    <style>
        .notification-dropdown-item {
            transition: background 0.2s ease;
        }

        .notification-dropdown-item:hover {
            background: rgba(var(--bs-primary-rgb), 0.05);
        }
    </style>
@endpush
