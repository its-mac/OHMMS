<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Session Name <span class="text-danger">*</span>
        </label>

        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $mealSession->name ?? '') }}"
               placeholder="Breakfast, Lunch, Dinner"
               required>

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">
            Start Time <span class="text-danger">*</span>
        </label>

        <input type="time"
               name="start_time"
               class="form-control @error('start_time') is-invalid @enderror"
               value="{{ old('start_time', isset($mealSession) ? \Carbon\Carbon::parse($mealSession->start_time)->format('H:i') : '') }}"
               required>

        @error('start_time')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">
            End Time <span class="text-danger">*</span>
        </label>

        <input type="time"
               name="end_time"
               class="form-control @error('end_time') is-invalid @enderror"
               value="{{ old('end_time', isset($mealSession) ? \Carbon\Carbon::parse($mealSession->end_time)->format('H:i') : '') }}"
               required>

        @error('end_time')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">
            Status
        </label>

        <select name="is_active" class="form-select">
            <option value="1"
                {{ old('is_active', $mealSession->is_active ?? 1) == 1 ? 'selected' : '' }}>
                Active
            </option>

            <option value="0"
                {{ old('is_active', $mealSession->is_active ?? 1) == 0 ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>

</div>
