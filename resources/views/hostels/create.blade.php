@extends('layouts.app', ['title' => 'Add Hostel'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Add Hostel</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Hostel Information</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.hostels.store') }}">
                @csrf

                @include('hostels.partials.form', ['hostel' => null])

                <div class="text-end mt-4">
                    <a href="{{ route('admin.hostels.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Hostel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
