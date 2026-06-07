<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Hostel <span class="text-danger">*</span></label>
        <select name="hostel_id" class="form-select @error('hostel_id') is-invalid @enderror" required>
            <option value="">Select Hostel</option>

            @foreach($hostels as $hostel)
                <option value="{{ $hostel->id }}"
                    {{ old('hostel_id', $block->hostel_id ?? '') == $hostel->id ? 'selected' : '' }}>
                    {{ $hostel->name }} - {{ ucfirst($hostel->type) }}
                </option>
            @endforeach
        </select>

        @error('hostel_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Block Name <span class="text-danger">*</span></label>
        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $block->name ?? '') }}"
               placeholder="Example: Block A"
               required>

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="active" {{ old('status', $block->status ?? 'active') === 'active' ? 'selected' : '' }}>
                Active
            </option>
            <option value="inactive" {{ old('status', $block->status ?? '') === 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>

        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
