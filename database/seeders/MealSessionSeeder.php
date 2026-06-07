<?php

namespace Database\Seeders;

use App\Models\MealSession;
use Illuminate\Database\Seeder;

class MealSessionSeeder extends Seeder
{
    public function run(): void
    {
        $sessions = [
            [
                'name' => 'Breakfast',
                'start_time' => '07:00:00',
                'end_time' => '09:00:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lunch',
                'start_time' => '12:30:00',
                'end_time' => '14:30:00',
                'is_active' => true,
            ],
            [
                'name' => 'Dinner',
                'start_time' => '19:00:00',
                'end_time' => '21:00:00',
                'is_active' => true,
            ],
        ];

        foreach ($sessions as $session) {
            MealSession::updateOrCreate(
                ['name' => $session['name']],
                $session
            );
        }
    }
}
