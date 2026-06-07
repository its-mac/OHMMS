@extends('layouts.app', ['title' => 'Students'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">Students</h5>
                </div>

                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
                        <i class="ph ph-plus"></i> Add Student
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Student List</h5>
        </div>

        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Reg No</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Phone</th>
                            <th>Fingerprint</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>
                                    @if($student->photo)
                                        <img src="{{ asset('storage/' . $student->photo) }}"
                                             width="45" height="45"
                                             class="rounded-circle object-fit-cover"
                                             alt="student">
                                    @else
                                        <span class="badge bg-light-secondary">No Photo</span>
                                    @endif
                                </td>
                                <td>{{ $student->registration_no }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->department ?? '-' }}</td>
                                <td>{{ $student->phone ?? '-' }}</td>
                                <td>
                                    @if($student->fingerprint_enrolled)
                                        <span class="badge bg-success">Enrolled</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($student->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-light-primary">View</a>
                                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-light-warning">Edit</a>

                                    <form action="{{ route('admin.students.destroy', $student) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this student?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $students->links() }}</div>
        </div>
    </div>
@endsection
