<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Block <span class="text-danger">*</span></label>

        <select name="block_id" class="form-select @error('block_id') is-invalid @enderror" required>
            <option value="">Select Block</option>

            @foreach($blocks as $block)
                <option value="{{ $block->id }}"
                    {{ old('block_id', $floor->block_id ?? '') == $block->id ? 'selected' : '' }}>
                    {{ $block->hostel?->name ?? '-' }} → {{ $block->name }}
                </option>
            @endforeach
        </select>

        @error('block_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Floor Name <span class="text-danger">*</span></label>

        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $floor->name ?? '') }}"
               placeholder="Example: Ground Floor"
               required>

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Status <span class="text-danger">*</span></label>

        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="active" {{ old('status', $floor->status ?? 'active') === 'active' ? 'selected' : '' }}>
                Active
            </option>

            <option value="inactive" {{ old('status', $floor->status ?? '') === 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>

        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
