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
}
