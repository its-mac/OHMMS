<?php

namespace App\Helpers;

use App\Models\AppNotification;
use App\Models\User;

class NotificationHelper
{
    public static function sendToRole(string $role, string $title, string $message, ?string $url = null, ?string $type = null): void
    {
        $users = User::where('role', $role)->get();

        foreach ($users as $user) {
            AppNotification::create([
                'user_id' => $user->id,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'url' => $url,
            ]);
        }
    }

    public static function sendToUser(int $userId, string $title, string $message, ?string $url = null, ?string $type = null): void
    {
        AppNotification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'url' => $url,
        ]);
    }

    public static function icon(?string $type = null): string
    {
        return match ($type) {
            'complaint' => 'ph-warning-circle',
            'complaint_escalation' => 'ph-warning-octagon',
            'fee' => 'ph-money',
            'payment_proof' => 'ph-receipt',
            'attendance' => 'ph-fingerprint',
            'guest_meal' => 'ph-fork-knife',
            'leave_request' => 'ph-airplane-takeoff',
            'gate_pass' => 'ph-door-open',
            'mess_off' => 'ph-calendar-x',
            default => 'ph-bell',
        };
    }
}
