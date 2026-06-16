@extends('layouts.app', ['title' => 'Today Attendance'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Today's Attendance</h5>
        <small class="text-muted">Meal attendance records for {{ now()->format('d M Y') }}</small>
    </div>
</div>

<div class="row">

    <div class="col-md-3">
        <div class="card bg-primary">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white">Total Attendance</h6>
                        <h3 class="text-white mb-0">{{ $totalToday }}</h3>
                    </div>
                    <i class="ph ph-fingerprint" style="font-size: 38px;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white">Breakfast</h6>
                        <h3 class="text-white mb-0">{{ $breakfastCount }}</h3>
                    </div>
                    <i class="ph ph-coffee" style="font-size: 38px;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white">Lunch</h6>
                        <h3 class="text-white mb-0">{{ $lunchCount }}</h3>
                    </div>
                    <i class="ph ph-bowl-food" style="font-size: 38px;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white">Dinner</h6>
                        <h3 class="text-white mb-0">{{ $dinnerCount }}</h3>
                    </div>
                    <i class="ph ph-fork-knife" style="font-size: 38px;"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="card mt-3">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Attendance Records</h5>

        <a href="{{ route('manager.attendance.scan') }}" class="btn btn-primary btn-sm">
            Scan Attendance
        </a>
    </div>

    <div class="card-body table-border-style">

        <div class="table-responsive">

            <table class="table table-hover table-bordered">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Time</th>
                        <th>Reg No</th>
                        <th>Student</th>
                        <th>Meal Session</th>
                        <th>Method</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($logs as $log)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($log->attendance_time)->format('h:i A') }}
                            </td>

                            <td>
                                {{ $log->student->registration_no ?? '-' }}
                            </td>

                            <td>
                                {{ $log->student->name ?? '-' }}
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ $log->mealSession->name ?? '-' }}
                                </span>
                            </td>

                            <td>
                                {{ ucfirst($log->verification_method ?? 'fingerprint') }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center">
                                No attendance recorded today.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
