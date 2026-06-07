@extends('layouts.app', ['title' => 'Today Attendance'])

@section('content')

<div class="page-header">
    <div class="page-block">
        <h5>Today's Attendance</h5>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h5>
            Attendance for {{ now()->format('d M Y') }}
        </h5>
    </div>

    <div class="card-body table-border-style">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Reg No</th>
                        <th>Student</th>
                        <th>Meal Session</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($logs as $log)

                        <tr>

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

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center">
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
