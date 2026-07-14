<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')

    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div>
            <label class="label" for="update_password_current_password">Current Password</label>
            <input type="password" id="update_password_current_password" name="current_password" required autocomplete="current-password" class="input">
            @error('current_password') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="label" for="update_password_password">New Password</label>
            <input type="password" id="update_password_password" name="password" required autocomplete="new-password" class="input">
            @error('password') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="label" for="update_password_password_confirmation">Confirm Password</label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation" required autocomplete="new-password" class="input">
            @error('password_confirmation') <span class="error-text">{{ $message }}</span> @enderror
        </div>
    </div>

    <div style="display: flex; align-items: center; gap: 12px; margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save</button>
        @if (session('status') === 'password-updated')
            <span style="font-size: 13px; color: var(--green);">Saved.</span>
        @endif
    </div>
</form>
