<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\MealSessionController;
use App\Http\Controllers\MessMenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomAllocationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentFingerprintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return view('dashboards.admin');
        }

        if (auth()->user()->role === 'manager') {
            return view('dashboards.manager');
        }

        abort(403);
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::middleware('admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::resource('students', StudentController::class);
            Route::resource('hostels', HostelController::class);
            Route::resource('blocks', BlockController::class);
            Route::resource('floors', FloorController::class);
            Route::resource('rooms', RoomController::class);
            Route::resource('room-allocations', RoomAllocationController::class);
            Route::resource('meal-sessions', MealSessionController::class);
            Route::resource('mess-menus', MessMenuController::class);

            Route::delete('/students/{student}/fingerprints/{fingerIndex}', [StudentFingerprintController::class, 'destroy'])
                ->name('students.fingerprints.destroy');

            Route::prefix('attendance')->name('attendance.')->group(function () {
                Route::get('/scan', [AttendanceController::class, 'scan'])->name('scan');
                Route::get('/logs', [AttendanceController::class, 'index'])->name('index');
                Route::get('/today', [AttendanceController::class, 'today'])->name('today');
                Route::get('/reports', [AttendanceController::class, 'reports'])->name('reports');
            });
        });

    Route::middleware('manager')
        ->prefix('manager')
        ->name('manager.')
        ->group(function () {
            Route::get('/attendance', function () {
                return 'Manager Attendance Module';
            })->name('attendance.index');
        });
});

require __DIR__ . '/auth.php';
