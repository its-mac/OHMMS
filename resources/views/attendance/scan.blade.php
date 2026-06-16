@extends('layouts.app', ['title' => 'Attendance Scan'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5>Biometric Attendance</h5>
            <small class="text-muted">Scan fingerprint and mark meal attendance</small>
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

                    <button type="button" id="startScannerBtn" class="btn btn-primary btn-lg"
                        onclick="startAttendanceScanner()">
                        Start Scanner
                    </button>

                    <div id="scannerStatus" class="alert alert-info mt-4 d-none"></div>

                    <div id="attendanceResultCard" class="card mt-4 d-none text-start">
                        <div class="card-header">
                            <h5 class="mb-0" id="attendanceResultTitle">Attendance Result</h5>
                        </div>

                        <div class="card-body">
                            <div class="row align-items-center">

                                <div class="col-md-2 text-center">
                                    <i id="attendanceResultIcon" class="ph ph-check-circle" style="font-size:64px;"></i>
                                </div>

                                <div class="col-md-10">
                                    <table class="table table-bordered mb-0">
                                        <tr>
                                            <th width="180">Student Name</th>
                                            <td id="resultStudentName">-</td>
                                        </tr>

                                        <tr>
                                            <th>Registration No</th>
                                            <td id="resultRegistrationNo">-</td>
                                        </tr>

                                        <tr>
                                            <th>Meal Session</th>
                                            <td id="resultMealSession">-</td>
                                        </tr>

                                        <tr>
                                            <th>Scan Time</th>
                                            <td id="resultScanTime">-</td>
                                        </tr>

                                        <tr>
                                            <th>Status</th>
                                            <td id="resultStatus">-</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

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
        let scannerStatusInterval = null;
        let lastFinalStatus = null;

        function startAttendanceScanner() {
            const statusBox = document.getElementById('scannerStatus');
            const startButton = document.getElementById('startScannerBtn');

            hideAttendanceResultCard();

            startButton.disabled = true;
            startButton.innerText = 'Scanner Running...';

            statusBox.classList.remove('d-none', 'alert-danger', 'alert-success', 'alert-warning');
            statusBox.classList.add('alert-info');
            statusBox.innerText = 'Starting fingerprint scanner...';

            fetch('http://127.0.0.1:5055/attendance')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        statusBox.classList.remove('alert-danger', 'alert-success', 'alert-warning');
                        statusBox.classList.add('alert-info');
                        statusBox.innerText = data.message;

                        startStatusPolling();
                    } else {
                        startButton.disabled = false;
                        startButton.innerText = 'Start Scanner';

                        statusBox.classList.remove('alert-info', 'alert-success');
                        statusBox.classList.add('alert-danger');
                        statusBox.innerText = data.message || 'Unable to start scanner.';
                    }
                })
                .catch(() => {
                    startButton.disabled = false;
                    startButton.innerText = 'Start Scanner';

                    statusBox.classList.remove('alert-info', 'alert-success');
                    statusBox.classList.add('alert-danger');
                    statusBox.innerText = 'Fingerprint agent is not running. Please start the agent first.';
                });
        }

        function startStatusPolling() {
            if (scannerStatusInterval) {
                clearInterval(scannerStatusInterval);
            }

            scannerStatusInterval = setInterval(fetchScannerStatus, 1500);
        }

        function fetchScannerStatus() {
            const statusBox = document.getElementById('scannerStatus');
            const startButton = document.getElementById('startScannerBtn');

            fetch('http://127.0.0.1:5055/status')
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        return;
                    }

                    const status = data.status || 'Scanner is running...';

                    statusBox.innerText = status;

                    const lowerStatus = status.toLowerCase();

                    if (
                        lowerStatus.includes('attendance marked') ||
                        lowerStatus.includes('attendance failed') ||
                        lowerStatus.includes('no matching fingerprint')
                    ) {
                        clearInterval(scannerStatusInterval);

                        startButton.disabled = false;
                        startButton.innerText = 'Start Scanner';

                        lastFinalStatus = status;

                        statusBox.classList.remove('alert-info', 'alert-danger', 'alert-success', 'alert-warning');

                        if (lowerStatus.includes('already marked')) {
                            statusBox.classList.add('alert-warning');
                        } else if (
                            lowerStatus.includes('failed') ||
                            lowerStatus.includes('no matching fingerprint')
                        ) {
                            statusBox.classList.add('alert-danger');
                        } else {
                            statusBox.classList.add('alert-success');
                        }

                        if (data.attendance_result) {
                            showAttendanceResult(data.attendance_result);
                        } else {
                            showBasicAttendanceResult(status);
                        }
                    }
                })
                .catch(() => {
                    clearInterval(scannerStatusInterval);

                    startButton.disabled = false;
                    startButton.innerText = 'Start Scanner';

                    statusBox.classList.remove('alert-info', 'alert-success');
                    statusBox.classList.add('alert-danger');
                    statusBox.innerText = 'Unable to read scanner status.';
                });
        }

        function showBasicAttendanceResult(status) {
            const resultCard = document.getElementById('attendanceResultCard');
            const resultTitle = document.getElementById('attendanceResultTitle');
            const resultIcon = document.getElementById('attendanceResultIcon');

            const lowerStatus = status.toLowerCase();

            resultCard.classList.remove('d-none');

            document.getElementById('resultStudentName').innerText = 'Available in attendance log';
            document.getElementById('resultRegistrationNo').innerText = 'Available in attendance log';
            document.getElementById('resultScanTime').innerText = new Date().toLocaleTimeString();

            if (lowerStatus.includes('lunch')) {
                document.getElementById('resultMealSession').innerText = 'Lunch';
            } else if (lowerStatus.includes('breakfast')) {
                document.getElementById('resultMealSession').innerText = 'Breakfast';
            } else if (lowerStatus.includes('dinner')) {
                document.getElementById('resultMealSession').innerText = 'Dinner';
            } else {
                document.getElementById('resultMealSession').innerText = '-';
            }

            if (lowerStatus.includes('already marked')) {
                resultTitle.innerText = 'Attendance Already Marked';
                resultIcon.className = 'ph ph-warning-circle text-warning';
                document.getElementById('resultStatus').innerHTML =
                    '<span class="badge bg-warning">Already Marked</span>';
            } else if (lowerStatus.includes('failed') || lowerStatus.includes('no matching fingerprint')) {
                resultTitle.innerText = 'Attendance Failed';
                resultIcon.className = 'ph ph-x-circle text-danger';
                document.getElementById('resultStatus').innerHTML =
                    '<span class="badge bg-danger">' + status + '</span>';
            } else {
                resultTitle.innerText = 'Attendance Marked Successfully';
                resultIcon.className = 'ph ph-check-circle text-success';
                document.getElementById('resultStatus').innerHTML =
                    '<span class="badge bg-success">Marked</span>';
            }
        }

        function showAttendanceResult(result) {

            const resultCard = document.getElementById('attendanceResultCard');
            const resultTitle = document.getElementById('attendanceResultTitle');
            const resultIcon = document.getElementById('attendanceResultIcon');

            resultCard.classList.remove('d-none');

            document.getElementById('resultStudentName').innerText =
                result.student_name || '-';

            document.getElementById('resultRegistrationNo').innerText =
                result.registration_no || '-';

            document.getElementById('resultMealSession').innerText =
                result.meal_session || '-';

            document.getElementById('resultScanTime').innerText =
                result.attendance_time || new Date().toLocaleTimeString();

            const statusCell = document.getElementById('resultStatus');

            if (result.success) {

                resultTitle.innerText = 'Attendance Marked Successfully';

                resultIcon.className =
                    'ph ph-check-circle text-success';

                statusCell.innerHTML =
                    '<span class="badge bg-success">Marked</span>';

            } else {

                if (
                    result.message &&
                    result.message.toLowerCase().includes('already marked')
                ) {

                    resultTitle.innerText = 'Attendance Already Marked';

                    resultIcon.className =
                        'ph ph-warning-circle text-warning';

                    statusCell.innerHTML =
                        '<span class="badge bg-warning">Already Marked</span>';
                } else {

                    resultTitle.innerText = 'Attendance Failed';

                    resultIcon.className =
                        'ph ph-x-circle text-danger';

                    statusCell.innerHTML =
                        '<span class="badge bg-danger">' +
                        result.message +
                        '</span>';
                }
            }
        }

        function hideAttendanceResultCard() {
            document.getElementById('attendanceResultCard').classList.add('d-none');
        }
    </script>
@endpush
