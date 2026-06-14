@extends('layouts.app', ['title' => 'Edit Profile'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Edit Profile</h5>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Editable Information</h5>
    </div>

    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('student.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $student->phone) }}">
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Photo</label>
                <input type="file" name="photo"
                       class="form-control @error('photo') is-invalid @enderror"
                       accept="image/*">
                @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror

                @if($student->photo)
                    <img src="{{ asset('storage/' . $student->photo) }}" class="rounded border mt-2" width="100">
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" rows="4"
                          class="form-control @error('address') is-invalid @enderror">{{ old('address', $student->address) }}</textarea>
                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary">Update Profile</button>
            <a href="{{ route('student.profile.show') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
