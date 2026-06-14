<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name"
           value="{{ old('name', $manager->name ?? '') }}"
           class="form-control @error('name') is-invalid @enderror">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email"
           value="{{ old('email', $manager->email ?? '') }}"
           class="form-control @error('email') is-invalid @enderror">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">
        Password
        @if(!empty($manager))
            <small class="text-muted">(Leave blank to keep current password)</small>
        @endif
    </label>
    <input type="password" name="password"
           class="form-control @error('password') is-invalid @enderror">
    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Confirm Password</label>
    <input type="password" name="password_confirmation" class="form-control">
</div>
