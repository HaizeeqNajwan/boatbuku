<x-guest-layout>
    <x-auth-session-status class="session-success" :status="session('status')" />

    <h2 class="guest-title">Forgot password</h2>
    <p class="guest-subtitle">No worries — we'll email you a reset link.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div style="margin-bottom: 16px;">
            <label class="label" for="email">Email</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com">
            @error('email') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 8px;">Send reset link</button>
    </form>

    <p style="text-align: center; font-size: 13px; color: var(--text-muted); margin-top: 20px;">
        <a href="{{ route('login') }}" class="link">Back to sign in</a>
    </p>
</x-guest-layout>
