<x-guest-layout>
    <h2 class="guest-title">Reset password</h2>
    <p class="guest-subtitle">Choose a new password for your account.</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div style="margin-bottom: 16px;">
            <label class="label" for="email">Email</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="you@example.com">
            @error('email') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label class="label" for="password">New password</label>
            <input id="password" class="input" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 characters">
            @error('password') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label class="label" for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" class="input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            @error('password_confirmation') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Reset password</button>
    </form>
</x-guest-layout>
