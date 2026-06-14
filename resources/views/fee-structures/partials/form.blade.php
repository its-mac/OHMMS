<div class="mb-3">
    <label class="form-label">Fee Name</label>
    <input type="text" name="name"
           value="{{ old('name', $feeStructure->name ?? '') }}"
           class="form-control @error('name') is-invalid @enderror"
           placeholder="Example: Hostel Fee">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Amount</label>
    <input type="number" step="0.01" name="amount"
           value="{{ old('amount', $feeStructure->amount ?? '') }}"
           class="form-control @error('amount') is-invalid @enderror"
           placeholder="Example: 5000">
    @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select @error('status') is-invalid @enderror">
        <option value="active" @selected(old('status', $feeStructure->status ?? 'active') === 'active')>
            Active
        </option>
        <option value="inactive" @selected(old('status', $feeStructure->status ?? '') === 'inactive')>
            Inactive
        </option>
    </select>
    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="4"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $feeStructure->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
