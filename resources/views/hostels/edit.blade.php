@extends('layouts.app', ['title' => 'Edit Hostel'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Edit Hostel</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Update Hostel Information</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.hostels.update', $hostel) }}">
                @csrf
                @method('PUT')

                @include('hostels.partials.form', ['hostel' => $hostel])

                <div class="text-end mt-4">
                    <a href="{{ route('admin.hostels.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Hostel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
