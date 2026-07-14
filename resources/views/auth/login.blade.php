<x-guest-layout>
    <x-auth-session-status class="session-success" :status="session('status')" />

    <h2 class="guest-title">Welcome back</h2>
    <p class="guest-subtitle">Sign in to your Boatbuku account</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div style="margin-bottom: 16px;">
            <label class="label" for="email">Email</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com">
            @error('email') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        {{-- Password --}}
        <div style="margin-bottom: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <label class="label" for="password">Password</label>
                @if (Route::has('password.request'))
                    <a class="link" href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>
            <input id="password" class="input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            @error('password') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        {{-- Remember --}}
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
            <input id="remember_me" type="checkbox" class="rounded" style="width: 16px; height: 16px; accent-color: var(--accent);" name="remember">
            <label for="remember_me" style="font-size: 13px; color: var(--text-muted); cursor: pointer;">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary">Sign in</button>
    </form>

    <div class="divider">or</div>

    <p style="text-align: center; font-size: 13px; color: var(--text-muted);">
        Don't have an account?
        <a href="{{ route('register') }}" class="link">Create one</a>
    </p>
</x-guest-layout>
