@extends('layouts.app', ['title' => 'Submit Complaint'])

@section('content')
<div class="page-header">
    <div class="page-block">
        <h5 class="mb-0">Submit Complaint</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('student.complaints.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select @error('category') is-invalid @enderror">
                    <option value="">Select Category</option>
                    @foreach(['Room', 'Mess', 'Water', 'Electricity', 'Internet', 'Cleanliness', 'Security', 'Other'] as $category)
                        <option value="{{ $category }}" @selected(old('category') === $category)>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" value="{{ old('subject') }}"
                       class="form-control @error('subject') is-invalid @enderror">
                @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="5"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary">Submit Complaint</button>
            <a href="{{ route('student.complaints.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
