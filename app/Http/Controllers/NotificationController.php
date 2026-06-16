<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AppNotification::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        $unreadCount = AppNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(AppNotification $notification)
    {
        abort_if($notification->user_id !== auth()->id(), 403);

        $notification->update([
            'read_at' => now(),
        ]);

        return redirect($notification->url ?? url()->previous());
    }

    public function markAllAsRead()
    {
        AppNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        return back();
    }
}
