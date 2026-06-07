<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Hostel Name <span class="text-danger">*</span></label>
        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $hostel?->name) }}"
               required>

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Hostel Type <span class="text-danger">*</span></label>
        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
            <option value="boys" {{ old('type', $hostel?->type ?? 'boys') === 'boys' ? 'selected' : '' }}>
                Boys
            </option>
            <option value="girls" {{ old('type', $hostel?->type) === 'girls' ? 'selected' : '' }}>
                Girls
            </option>
        </select>

        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Capacity <span class="text-danger">*</span></label>
        <input type="number"
               name="capacity"
               min="0"
               class="form-control @error('capacity') is-invalid @enderror"
               value="{{ old('capacity', $hostel?->capacity ?? 0) }}"
               required>

        @error('capacity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="active" {{ old('status', $hostel?->status ?? 'active') === 'active' ? 'selected' : '' }}>
                Active
            </option>
            <option value="inactive" {{ old('status', $hostel?->status) === 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>

        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
