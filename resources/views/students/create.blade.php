@extends('layouts.app', ['title' => 'Add Student'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Add Student</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Student Information</h5>
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.students.store') }}">
                @csrf

                @include('students.partials.form', ['student' => null])

                <div class="text-end mt-4">
                    <a href="{{ route('admin.students.index') }}" class="btn btn-light">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Save Student
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
