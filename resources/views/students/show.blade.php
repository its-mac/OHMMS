@extends('layouts.app', ['title' => 'Student Details'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Student Details</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ $student->name }}</h5>

            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-primary btn-sm">
                Edit Student
            </a>
        </div>

        <div class="card-body">
            <div class="text-center mb-4">
                @if ($student->photo)
                    <img src="{{ asset('storage/' . $student->photo) }}" alt="student photo" width="120" height="120"
                        class="rounded-circle object-fit-cover border">
                @else
                    <div class="text-muted">No photo uploaded</div>
                @endif
            </div>

            <table class="table table-bordered">
                <tr>
                    <th width="220">Registration No</th>
                    <td>{{ $student->registration_no }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $student->name }}</td>
                </tr>
                <tr>
                    <th>Father Name</th>
                    <td>{{ $student->father_name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>CNIC</th>
                    <td>{{ $student->cnic ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $student->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $student->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>{{ $student->department ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Session</th>
                    <td>{{ $student->session ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Hostel</th>
                    <td>{{ $student->hostel ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Room No</th>
                    <td>{{ $student->room_no ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Blood Group</th>
                    <td>{{ $student->blood_group ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Guardian Name</th>
                    <td>{{ $student->guardian_name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Guardian Phone</th>
                    <td>{{ $student->guardian_phone ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Emergency Contact</th>
                    <td>{{ $student->emergency_contact ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $student->address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Fingerprint</th>
                    <td>
                        @if ($student->fingerprint_enrolled)
                            <span class="badge bg-success">Enrolled</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($student->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>
            </table>
            <hr>

            <h5 class="mb-3">Fingerprint Enrollment</h5>

            <div class="alert alert-info">
                For testing in Visual Studio, use:
                <strong>Student ID: {{ $student->id }}</strong>
            </div>
            <div class="mb-3">
                <a href="http://127.0.0.1:5055/enroll?student_id={{ $student->id }}&finger_index=1" target="_blank"
                    class="btn btn-primary">
                    <i class="ph ph-fingerprint"></i>
                    Enroll Fingerprint
                </a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Finger Index</th>
                        <th>Status</th>
                        <th>Enrolled At</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($student->fingerprints as $fingerprint)
                        <tr>
                            <td>{{ $fingerprint->finger_index }}</td>
                            <td><span class="badge bg-success">Enrolled</span></td>
                            <td>{{ $fingerprint->created_at?->format('d M Y h:i A') }}</td>
                            <td class="text-end">
                                <form method="POST"
                                    action="{{ route('admin.students.fingerprints.destroy', [$student, $fingerprint->finger_index]) }}"
                                    class="d-inline" onsubmit="return confirm('Delete this fingerprint?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-light-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No fingerprint enrolled yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <a href="{{ route('admin.students.index') }}" class="btn btn-light">Back</a>
        </div>
    </div>
@endsection
