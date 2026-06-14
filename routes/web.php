<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\FinanceReportController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\GuestMealController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MealSessionController;
use App\Http\Controllers\MessMenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomAllocationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Manager\ComplaintController as ManagerComplaintController;
use App\Http\Controllers\Manager\GatePassController as ManagerGatePassController;
use App\Http\Controllers\Manager\MessOffController as ManagerMessOffController;
use App\Http\Controllers\Manager\LeaveRequestController as ManagerLeaveRequestController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Student\StudentAttendanceController;
use App\Http\Controllers\Student\StudentComplaintController;
use App\Http\Controllers\Student\StudentFeeController;
use App\Http\Controllers\Student\StudentGatePassController;
use App\Http\Controllers\Student\StudentGuestMealController;
use App\Http\Controllers\Student\StudentLeaveRequestController;
use App\Http\Controllers\Student\StudentMessMenuController;
use App\Http\Controllers\Student\StudentMessOffController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\Student\StudentRoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentFingerprintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (auth()->user()->role === 'manager') {
            return redirect()->route('manager.dashboard');
        }

        if (auth()->user()->role === 'student') {
            return redirect()->route('student.dashboard');
        }

        abort(403);
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', function () {
                return view('dashboards.admin');
            })->name('dashboard');

            Route::resource('managers', ManagerController::class)->except(['show']);
            Route::resource('students', StudentController::class);
            Route::resource('hostels', HostelController::class);
            Route::resource('blocks', BlockController::class);
            Route::resource('floors', FloorController::class);
            Route::resource('rooms', RoomController::class);
            Route::resource('room-allocations', RoomAllocationController::class);
            Route::resource('meal-sessions', MealSessionController::class);
            Route::resource('mess-menus', MessMenuController::class);
            Route::resource('fee-structures', FeeStructureController::class);

            Route::delete('/students/{student}/fingerprints/{fingerIndex}', [StudentFingerprintController::class, 'destroy'])
                ->name('students.fingerprints.destroy');

            Route::prefix('attendance')->name('attendance.')->group(function () {
                Route::get('/scan', [AttendanceController::class, 'scan'])->name('scan');
                Route::get('/logs', [AttendanceController::class, 'index'])->name('index');
                Route::get('/today', [AttendanceController::class, 'today'])->name('today');
                Route::get('/reports', [AttendanceController::class, 'reports'])->name('reports');
            });

            Route::get('/guest-meals/reports', [GuestMealController::class, 'reports'])
                ->name('guest-meals.reports');

            Route::get('/guest-meals', [GuestMealController::class, 'index'])
                ->name('guest-meals.index');

            Route::get('/guest-meals/{guestMeal}', [GuestMealController::class, 'show'])
                ->name('guest-meals.show');

            Route::patch('/guest-meals/{guestMeal}/approve', [GuestMealController::class, 'approve'])
                ->name('guest-meals.approve');

            Route::patch('/guest-meals/{guestMeal}/reject', [GuestMealController::class, 'reject'])
                ->name('guest-meals.reject');

            Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
            Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
            Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
            Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
            Route::post('/invoices/{invoice}/payments', [PaymentController::class, 'store'])
                ->name('invoices.payments.store');

            Route::get('/finance-reports/defaulters', [FinanceReportController::class, 'defaulters'])
                ->name('finance-reports.defaulters');

            Route::get('/finance-reports/collections', [FinanceReportController::class, 'collections'])
                ->name('finance-reports.collections');
        });

    /*
    |--------------------------------------------------------------------------
    | Manager Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('manager')
        ->prefix('manager')
        ->name('manager.')
        ->group(function () {
            Route::get(
                '/dashboard',
                [ManagerDashboardController::class, 'index']
            )->name('dashboard');

            Route::get('/attendance', function () {
                return 'Manager Attendance Module';
            })->name('attendance.index');

            Route::get('/mess-offs', [ManagerMessOffController::class, 'index'])
                ->name('mess-offs.index');

            Route::get('/mess-offs/{messOff}', [ManagerMessOffController::class, 'show'])
                ->name('mess-offs.show');

            Route::patch('/mess-offs/{messOff}/approve', [ManagerMessOffController::class, 'approve'])
                ->name('mess-offs.approve');

            Route::patch('/mess-offs/{messOff}/reject', [ManagerMessOffController::class, 'reject'])
                ->name('mess-offs.reject');

            Route::get('/leave-requests', [ManagerLeaveRequestController::class, 'index'])->name('leave-requests.index');
            Route::get('/leave-requests/{leaveRequest}', [ManagerLeaveRequestController::class, 'show'])->name('leave-requests.show');
            Route::patch('/leave-requests/{leaveRequest}/approve', [ManagerLeaveRequestController::class, 'approve'])->name('leave-requests.approve');
            Route::patch('/leave-requests/{leaveRequest}/reject', [ManagerLeaveRequestController::class, 'reject'])->name('leave-requests.reject');

            Route::get('/gate-passes', [ManagerGatePassController::class, 'index'])->name('gate-passes.index');
            Route::get('/gate-passes/{gatePass}', [ManagerGatePassController::class, 'show'])->name('gate-passes.show');
            Route::patch('/gate-passes/{gatePass}/approve', [ManagerGatePassController::class, 'approve'])->name('gate-passes.approve');
            Route::patch('/gate-passes/{gatePass}/reject', [ManagerGatePassController::class, 'reject'])->name('gate-passes.reject');

            Route::get('/complaints', [ManagerComplaintController::class, 'index'])->name('complaints.index');
            Route::get('/complaints/{complaint}', [ManagerComplaintController::class, 'show'])->name('complaints.show');
            Route::patch('/complaints/{complaint}/status', [ManagerComplaintController::class, 'updateStatus'])->name('complaints.update-status');
        });

    /*
    |--------------------------------------------------------------------------
    | Student Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('student')
        ->prefix('student')
        ->name('student.')
        ->group(function () {
            Route::get('/dashboard', [StudentDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/profile', [StudentProfileController::class, 'show'])
                ->name('profile.show');

            Route::get('/profile/edit', [StudentProfileController::class, 'edit'])
                ->name('profile.edit');

            Route::put('/profile', [StudentProfileController::class, 'update'])
                ->name('profile.update');

            Route::get('/my-room', [StudentRoomController::class, 'index'])
                ->name('room.index');

            Route::get('/mess-menu', [StudentMessMenuController::class, 'index'])
                ->name('mess-menu.index');

            Route::get('/attendance-history', [StudentAttendanceController::class, 'index'])
                ->name('attendance.index');

            Route::get('/mess-offs', [StudentMessOffController::class, 'index'])
                ->name('mess-offs.index');

            Route::get('/mess-offs/create', [StudentMessOffController::class, 'create'])
                ->name('mess-offs.create');

            Route::post('/mess-offs', [StudentMessOffController::class, 'store'])
                ->name('mess-offs.store');

            Route::get('/mess-offs/{messOff}', [StudentMessOffController::class, 'show'])
                ->name('mess-offs.show');


            Route::get('/guest-meals', [StudentGuestMealController::class, 'index'])
                ->name('guest-meals.index');

            Route::get('/guest-meals/create', [StudentGuestMealController::class, 'create'])
                ->name('guest-meals.create');

            Route::post('/guest-meals', [StudentGuestMealController::class, 'store'])
                ->name('guest-meals.store');

            Route::get('/guest-meals/{guestMeal}', [StudentGuestMealController::class, 'show'])
                ->name('guest-meals.show');

            Route::get('/leave-requests', [StudentLeaveRequestController::class, 'index'])->name('leave-requests.index');
            Route::get('/leave-requests/create', [StudentLeaveRequestController::class, 'create'])->name('leave-requests.create');
            Route::post('/leave-requests', [StudentLeaveRequestController::class, 'store'])->name('leave-requests.store');
            Route::get('/leave-requests/{leaveRequest}', [StudentLeaveRequestController::class, 'show'])->name('leave-requests.show');

            Route::get('/gate-passes', [StudentGatePassController::class, 'index'])->name('gate-passes.index');
            Route::get('/gate-passes/create', [StudentGatePassController::class, 'create'])->name('gate-passes.create');
            Route::post('/gate-passes', [StudentGatePassController::class, 'store'])->name('gate-passes.store');
            Route::get('/gate-passes/{gatePass}', [StudentGatePassController::class, 'show'])->name('gate-passes.show');

            Route::get('/complaints', [StudentComplaintController::class, 'index'])->name('complaints.index');
            Route::get('/complaints/create', [StudentComplaintController::class, 'create'])->name('complaints.create');
            Route::post('/complaints', [StudentComplaintController::class, 'store'])->name('complaints.store');
            Route::get('/complaints/{complaint}', [StudentComplaintController::class, 'show'])->name('complaints.show');

            Route::get('/fees', [StudentFeeController::class, 'index'])
                ->name('fees.index');

            Route::get('/fees/{invoice}', [StudentFeeController::class, 'show'])
                ->name('fees.show');
        });
});

require __DIR__ . '/auth.php';
