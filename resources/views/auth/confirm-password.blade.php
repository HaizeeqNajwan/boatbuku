<x-guest-layout>
    <h2 class="guest-title">Confirm password</h2>
    <p class="guest-subtitle">This is a secure area of the application. Please confirm your password before continuing.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div style="margin-bottom: 16px;">
            <label class="label" for="password">Password</label>
            <input id="password" class="input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            @error('password') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Confirm</button>
    </form>
</x-guest-layout>
