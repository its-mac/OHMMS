<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Floor <span class="text-danger">*</span></label>

        <select name="floor_id" class="form-select @error('floor_id') is-invalid @enderror" required>
            <option value="">Select Floor</option>

            @foreach($floors as $floor)
                <option value="{{ $floor->id }}"
                    {{ old('floor_id', $room->floor_id ?? '') == $floor->id ? 'selected' : '' }}>
                    {{ $floor->block?->hostel?->name ?? '-' }} → {{ $floor->block?->name ?? '-' }} → {{ $floor->name }}
                </option>
            @endforeach
        </select>

        @error('floor_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Room No <span class="text-danger">*</span></label>

        <input type="text"
               name="room_no"
               class="form-control @error('room_no') is-invalid @enderror"
               value="{{ old('room_no', $room->room_no ?? '') }}"
               placeholder="Example: 101"
               required>

        @error('room_no')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Capacity <span class="text-danger">*</span></label>

        <input type="number"
               name="capacity"
               min="1"
               class="form-control @error('capacity') is-invalid @enderror"
               value="{{ old('capacity', $room->capacity ?? 1) }}"
               required>

        @error('capacity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if($room)
        <div class="col-md-6 mb-3">
            <label class="form-label">Occupied <span class="text-danger">*</span></label>

            <input type="number"
                   name="occupied"
                   min="0"
                   class="form-control @error('occupied') is-invalid @enderror"
                   value="{{ old('occupied', $room->occupied ?? 0) }}"
                   required>

            @error('occupied')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endif

    <div class="col-md-6 mb-3">
        <label class="form-label">Status <span class="text-danger">*</span></label>

        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="available" {{ old('status', $room->status ?? 'available') === 'available' ? 'selected' : '' }}>
                Available
            </option>

            <option value="full" {{ old('status', $room->status ?? '') === 'full' ? 'selected' : '' }}>
                Full
            </option>

            <option value="maintenance" {{ old('status', $room->status ?? '') === 'maintenance' ? 'selected' : '' }}>
                Maintenance
            </option>

            <option value="inactive" {{ old('status', $room->status ?? '') === 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>

        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
