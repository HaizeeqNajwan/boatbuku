<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div>
            <label class="label" for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus class="input">
            @error('name') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="label" for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="input">
            @error('email') <span class="error-text">{{ $message }}</span> @enderror
        </div>
    </div>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div style="margin-top: 16px; padding: 12px 14px; border-radius: 8px; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2);">
            <p style="font-size: 13px; margin: 0 0 4px; color: var(--yellow);">
                Your email address is unverified.
                <button form="verify-email" type="button" style="background: none; border: none; color: var(--accent); cursor: pointer; font-size: 13px; text-decoration: underline;">
                    Click here to re-send the verification email.
                </button>
            </p>
            @if (session('status') === 'verification-link-sent')
                <p style="font-size: 12px; margin: 0; color: var(--green);">A new verification link has been sent to your email address.</p>
            @endif
        </div>
        <form id="verify-email" method="POST" action="{{ route('verification.send') }}" style="display: none;">
            @csrf
        </form>
    @endif

    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save</button>
        @if (session('status') === 'profile-updated')
            <span style="font-size: 13px; color: var(--green); margin-left: 12px;">Saved.</span>
        @endif
    </div>
</form>
