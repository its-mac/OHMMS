@extends('layouts.app', ['title' => 'Edit Student'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Edit Student</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Update Student Information</h5>
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.students.update', $student) }}">
                @csrf
                @method('PUT')

                @include('students.partials.form', ['student' => $student])

                <div class="text-end mt-4">
                    <a href="{{ route('admin.students.index') }}" class="btn btn-light">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Update Student
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
