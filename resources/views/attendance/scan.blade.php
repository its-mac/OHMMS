@extends('layouts.app', ['title' => 'Attendance Scan'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5>Biometric Attendance</h5>
        </div>
    </div>

    <div class="row">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">
                    <h5>Fingerprint Attendance Scanner</h5>
                </div>

                <div class="card-body text-center">

                    <i class="ph ph-fingerprint" style="font-size:100px;"></i>

                    <h4 class="mt-3">
                        Ready for Attendance Scan
                    </h4>

                    <p class="text-muted">
                        Place finger on scanner.
                    </p>

                    <button type="button" class="btn btn-primary btn-lg" onclick="startAttendanceScanner()">
                        Start Scanner
                    </button>

                    <div id="scannerStatus" class="alert alert-info mt-4 d-none"></div>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card">

                <div class="card-header">
                    <h5>Active Meal Sessions</h5>
                </div>

                <div class="card-body">

                    @forelse($mealSessions as $session)
                        <div class="mb-3">

                            <strong>{{ $session->name }}</strong>

                            <br>

                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}
                                -
                                {{ \Carbon\Carbon::parse($session->end_time)->format('h:i A') }}
                            </small>

                        </div>

                    @empty

                        <div class="alert alert-warning mb-0">
                            No active meal sessions.
                        </div>
                    @endforelse

                </div>

            </div>

        </div>

    </div>
@endsection

@push('page-scripts')
<script>
    function startAttendanceScanner() {
        const statusBox = document.getElementById('scannerStatus');

        statusBox.classList.remove('d-none', 'alert-danger', 'alert-success');
        statusBox.classList.add('alert-info');
        statusBox.innerText = 'Starting fingerprint scanner...';

        fetch('http://127.0.0.1:5055/attendance')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusBox.classList.remove('alert-info', 'alert-danger');
                    statusBox.classList.add('alert-success');
                    statusBox.innerText = data.message;
                } else {
                    statusBox.classList.remove('alert-info', 'alert-success');
                    statusBox.classList.add('alert-danger');
                    statusBox.innerText = data.message || 'Unable to start scanner.';
                }
            })
            .catch(() => {
                statusBox.classList.remove('alert-info', 'alert-success');
                statusBox.classList.add('alert-danger');
                statusBox.innerText = 'Fingerprint agent is not running. Please start the agent first.';
            });
    }
</script>
@endpush
