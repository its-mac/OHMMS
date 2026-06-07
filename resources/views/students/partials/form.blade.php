<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Registration No <span class="text-danger">*</span></label>
        <input type="text" name="registration_no"
               class="form-control @error('registration_no') is-invalid @enderror"
               value="{{ old('registration_no', $student->registration_no ?? '') }}" required>
        @error('registration_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Student Name <span class="text-danger">*</span></label>
        <input type="text" name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $student->name ?? '') }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Father Name</label>
        <input type="text" name="father_name" class="form-control"
               value="{{ old('father_name', $student->father_name ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">CNIC</label>
        <input type="text" name="cnic"
               class="form-control @error('cnic') is-invalid @enderror"
               value="{{ old('cnic', $student->cnic ?? '') }}">
        @error('cnic') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $student->email ?? '') }}">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone', $student->phone ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Department</label>
        <input type="text" name="department" class="form-control"
               value="{{ old('department', $student->department ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Session</label>
        <input type="text" name="session" class="form-control"
               value="{{ old('session', $student->session ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Hostel</label>
        <input type="text" name="hostel" class="form-control"
               value="{{ old('hostel', $student->hostel ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Room No</label>
        <input type="text" name="room_no" class="form-control"
               value="{{ old('room_no', $student->room_no ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Blood Group</label>
        <select name="blood_group" class="form-select">
            <option value="">Select Blood Group</option>
            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $group)
                <option value="{{ $group }}" {{ old('blood_group', $student->blood_group ?? '') === $group ? 'selected' : '' }}>
                    {{ $group }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Photo</label>
        <input type="file" name="photo"
               class="form-control @error('photo') is-invalid @enderror"
               accept="image/*">
        @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror

        @if(!empty($student?->photo))
            <div class="mt-2">
                <img src="{{ asset('storage/' . $student->photo) }}"
                     alt="student photo"
                     width="80"
                     class="rounded border">
            </div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Guardian Name</label>
        <input type="text" name="guardian_name" class="form-control"
               value="{{ old('guardian_name', $student->guardian_name ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Guardian Phone</label>
        <input type="text" name="guardian_phone" class="form-control"
               value="{{ old('guardian_phone', $student->guardian_phone ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Emergency Contact</label>
        <input type="text" name="emergency_contact" class="form-control"
               value="{{ old('emergency_contact', $student->emergency_contact ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select" required>
            <option value="active" {{ old('status', $student->status ?? 'active') === 'active' ? 'selected' : '' }}>
                Active
            </option>
            <option value="inactive" {{ old('status', $student->status ?? '') === 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="3">{{ old('address', $student->address ?? '') }}</textarea>
    </div>
</div>
