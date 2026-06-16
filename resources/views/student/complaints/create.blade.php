@extends('layouts.app', ['title' => 'Submit Complaint'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <h5 class="mb-0">Submit Complaint</h5>
            <small class="text-muted">Submit a hostel, room, mess or service-related complaint</small>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Complaint Form</h5>
                </div>

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

                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject</label>

                            <input type="text"
                                   name="subject"
                                   value="{{ old('subject') }}"
                                   class="form-control @error('subject') is-invalid @enderror"
                                   placeholder="Example: Room fan is not working">

                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>

                            <textarea name="description"
                                      rows="6"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Write full complaint details here...">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary">
                            <i class="ph ph-paper-plane-tilt me-1"></i>
                            Submit Complaint
                        </button>

                        <a href="{{ route('student.complaints.index') }}" class="btn btn-light">
                            Cancel
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3"
                             style="width: 48px; height: 48px;">
                            <i class="ph ph-info" style="font-size: 24px;"></i>
                        </div>

                        <div>
                            <h5 class="mb-0">Complaint Guidelines</h5>
                            <small class="text-muted">Before submission</small>
                        </div>
                    </div>

                    <ul class="mb-0 text-muted">
                        <li>Choose the correct complaint category.</li>
                        <li>Write a clear and short subject.</li>
                        <li>Add complete details for quick resolution.</li>
                        <li>You will be notified after manager response.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
