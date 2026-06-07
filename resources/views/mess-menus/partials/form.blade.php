<div class="mb-3">
    <label class="form-label">Meal Session</label>
    <select name="meal_session_id" class="form-control @error('meal_session_id') is-invalid @enderror">
        <option value="">Select Meal Session</option>
        @foreach($mealSessions as $session)
            <option value="{{ $session->id }}"
                @selected(old('meal_session_id', $messMenu->meal_session_id ?? '') == $session->id)>
                {{ $session->name }}
            </option>
        @endforeach
    </select>
    @error('meal_session_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Menu Date</label>
    <input type="date"
           name="menu_date"
           value="{{ old('menu_date', $messMenu->menu_date ?? now()->toDateString()) }}"
           class="form-control @error('menu_date') is-invalid @enderror">
    @error('menu_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Menu Items</label>
    <textarea name="menu_items"
              rows="5"
              class="form-control @error('menu_items') is-invalid @enderror"
              placeholder="Example: Roti, Chicken Curry, Rice, Salad">{{ old('menu_items', $messMenu->menu_items ?? '') }}</textarea>
    @error('menu_items')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
