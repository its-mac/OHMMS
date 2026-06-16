@extends('layouts.app', ['title' => 'Notifications'])

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="d-flex align-items-center gap-2">
                <h5 class="mb-0">Notifications</h5>

                @if ($unreadCount > 0)
                    <span class="badge bg-primary rounded-pill">
                        {{ $unreadCount }} unread
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div></div>

        <form method="POST" action="{{ route('notifications.read-all') }}">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none">
                Mark all as read
            </button>
        </form>
    </div>

    <div class="nc-tabs mb-3">
        <button class="nc-tab active" type="button">All</button>
        <button class="nc-tab" type="button">Alerts</button>
        <button class="nc-tab" type="button">Messages</button>
        <button class="nc-tab" type="button">Updates</button>
        <button class="nc-tab" type="button">System</button>
    </div>

    <div class="card mb-0">
        <div class="card-body p-0">

            <div class="px-3 py-2 bg-body-secondary">
                <small class="fw-medium text-muted text-uppercase">Recent</small>
            </div>

            @forelse($notifications as $notification)
                <form method="POST" action="{{ route('notifications.read', $notification) }}">
                    @csrf

                    <button type="submit" class="nc-button">
                        <div class="nc-item {{ $notification->read_at ? '' : 'nc-unread' }}">
                            <div class="nc-icon bg-primary-subtle text-primary">
                                <i class="ph {{ \App\Helpers\NotificationHelper::icon($notification->type) }}"></i>
                            </div>

                            <div class="nc-content">
                                <div class="nc-title">
                                    {{ $notification->title }}
                                </div>

                                <div class="nc-text">
                                    {{ $notification->message }}
                                </div>

                                <div class="nc-time">
                                    <i class="ph ph-clock"></i>
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>

                            <div class="nc-actions">
                                @if (!$notification->read_at)
                                    <span class="nc-dot"></span>
                                @endif
                            </div>
                        </div>
                    </button>
                </form>
            @empty
                <div class="text-center py-5">
                    <i class="ph ph-bell-slash text-muted d-block mb-2" style="font-size: 42px;"></i>
                    <p class="text-muted mb-0">No notifications found.</p>
                </div>
            @endforelse

        </div>

        <div class="card-footer">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection

@push('page-css')
    <style>
        .nc-tabs {
            display: flex;
            gap: 16px;
            background: #fff;
            border: 1px solid #eef0f4;
            border-radius: 6px;
            padding: 6px;
        }

        .nc-tab {
            border: 0;
            background: transparent;
            padding: 10px 18px;
            border-radius: 5px;
            color: #5b667a;
            font-weight: 500;
        }

        .nc-tab.active {
            background: var(--bs-primary);
            color: #fff;
        }

        .nc-button {
            width: 100%;
            border: 0;
            background: transparent;
            padding: 0;
            text-align: left;
        }

        .nc-item {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 22px 24px;
            border-bottom: 1px solid #eef0f4;
            transition: 0.2s ease;
            position: relative;
        }

        .nc-item:hover {
            background: #f8fbff;
        }

        .nc-item.nc-unread {
            background: #f4f7ff;
            border-left: 3px solid var(--bs-primary);
        }

        .nc-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 20px;
        }

        .nc-content {
            flex: 1;
            min-width: 0;
        }

        .nc-title {
            font-size: 15px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 4px;
        }

        .nc-text {
            font-size: 14px;
            color: #526071;
            margin-bottom: 6px;
        }

        .nc-time {
            font-size: 13px;
            color: #6b7280;
        }

        .nc-actions {
            min-width: 24px;
            display: flex;
            justify-content: center;
            padding-top: 6px;
        }

        .nc-dot {
            width: 8px;
            height: 8px;
            background: var(--bs-primary);
            border-radius: 50%;
            display: inline-block;
        }
    </style>
@endpush
