@extends('layouts.app', ['title' => 'Attendance Logs'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5>Attendance Logs</h5>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h5>All Attendance Records</h5>
    </div>

    <div class="card-body table-border-style">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Registration No</th>
                        <th>Student</th>
                        <th>Meal Session</th>
                        <th>Method</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($logs as $log)

                        <tr>

                            <td>
                                {{ $log->attendance_date }}
                            </td>

                            <td>
                                {{ $log->attendance_time }}
                            </td>

                            <td>
                                {{ $log->student->registration_no }}
                            </td>

                            <td>
                                {{ $log->student->name }}
                            </td>

                            <td>
                                {{ $log->mealSession->name }}
                            </td>

                            <td>

                                @if($log->verification_method == 'fingerprint')
                                    <span class="badge bg-success">
                                        Fingerprint
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        Manual
                                    </span>
                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center">
                                No attendance records found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $logs->links() }}
        </div>

    </div>

</div>

@endsection
