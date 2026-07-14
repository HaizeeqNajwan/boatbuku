<div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;">
    <div>
        <p style="font-size: 14px; font-weight: 500; color: var(--red); margin: 0 0 4px;">Delete Account</p>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0; max-width: 400px;">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
    </div>
    <button type="button" onclick="document.getElementById('delete-modal').showModal()" class="btn btn-secondary" style="color: var(--red); border-color: rgba(239, 68, 68, 0.3);">Delete Account</button>
</div>

<dialog id="delete-modal" style="width: 100%; max-width: 400px; border-radius: 16px; border: 1px solid var(--border); background: var(--bg-card); color: var(--text); padding: 0; margin: auto;">
    <div style="padding: 24px;">
        <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 8px;">Are you sure?</h3>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0 0 20px;">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.</p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <div style="margin-bottom: 16px;">
                <label class="label" for="password">Password</label>
                <input type="password" id="password" name="password" required class="input" placeholder="••••••••">
                @error('password') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="background: var(--red); color: #fff;">Delete Account</button>
                <button type="button" onclick="document.getElementById('delete-modal').close()" class="btn btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</dialog>
