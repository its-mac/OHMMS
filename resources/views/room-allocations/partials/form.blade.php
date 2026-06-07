<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Student <span class="text-danger">*</span></label>

        <select name="student_id" class="form-select @error('student_id') is-invalid @enderror"
                {{ $allocation ? 'disabled' : '' }} required>
            <option value="">Select Student</option>

            @foreach($students ?? [] as $student)
                <option value="{{ $student->id }}"
                    {{ old('student_id', $allocation->student_id ?? '') == $student->id ? 'selected' : '' }}>
                    {{ $student->registration_no }} - {{ $student->name }}
                </option>
            @endforeach

            @if($allocation)
                <option value="{{ $allocation->student_id }}" selected>
                    {{ $allocation->student?->registration_no }} - {{ $allocation->student?->name }}
                </option>
            @endif
        </select>

        @error('student_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Room <span class="text-danger">*</span></label>

        <select name="room_id" class="form-select @error('room_id') is-invalid @enderror"
                {{ $allocation ? 'disabled' : '' }} required>
            <option value="">Select Room</option>

            @foreach($rooms ?? [] as $room)
                <option value="{{ $room->id }}"
                    {{ old('room_id', $allocation->room_id ?? '') == $room->id ? 'selected' : '' }}>
                    {{ $room->floor?->block?->hostel?->name ?? '-' }}
                    →
                    {{ $room->floor?->block?->name ?? '-' }}
                    →
                    {{ $room->floor?->name ?? '-' }}
                    →
                    Room {{ $room->room_no }}
                    ({{ $room->occupied }}/{{ $room->capacity }})
                </option>
            @endforeach

            @if($allocation)
                <option value="{{ $allocation->room_id }}" selected>
                    {{ $allocation->room?->floor?->block?->hostel?->name ?? '-' }}
                    →
                    {{ $allocation->room?->floor?->block?->name ?? '-' }}
                    →
                    {{ $allocation->room?->floor?->name ?? '-' }}
                    →
                    Room {{ $allocation->room?->room_no }}
                </option>
            @endif
        </select>

        @error('room_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Allocated Date <span class="text-danger">*</span></label>

        <input type="date"
               name="allocated_at"
               class="form-control @error('allocated_at') is-invalid @enderror"
               value="{{ old('allocated_at', isset($allocation) && $allocation ? $allocation->allocated_at?->format('Y-m-d') : now()->toDateString()) }}"
               {{ $allocation ? 'readonly' : '' }}
               required>

        @error('allocated_at')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if($allocation)
        <div class="col-md-6 mb-3">
            <label class="form-label">Released Date</label>

            <input type="date"
                   name="released_at"
                   class="form-control @error('released_at') is-invalid @enderror"
                   value="{{ old('released_at', $allocation->released_at?->format('Y-m-d')) }}">

            @error('released_at')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>

            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="active" {{ old('status', $allocation->status) === 'active' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="released" {{ old('status', $allocation->status) === 'released' ? 'selected' : '' }}>
                    Released
                </option>
            </select>

            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endif
</div>
