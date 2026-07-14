<x-guest-layout>
    <h2 class="guest-title">Create account</h2>
    <p class="guest-subtitle">Join Boatbuku to find and book boats</p>

    <div x-data="{ role: @js($role ?? '') }">
        {{-- Role selection --}}
        <div x-show="!role" style="margin-bottom: 24px;">
            <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 16px; text-align: center;">I want to</p>
            <div style="display: flex; flex-direction: column; gap: 12px; max-width: 320px; margin: 0 auto;">
                <button @click="role = 'customer'" class="btn btn-secondary" style="padding: 14px 20px; font-size: 15px; justify-content: center;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                    Register as Renter
                </button>
                <button @click="role = 'owner'" class="btn btn-secondary" style="padding: 14px 20px; font-size: 15px; justify-content: center;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 20l1.5-3L7 12l3.5 5L12 20l1.5-3L17 12l3.5 5L22 20M12 3L2 12h3v8h6v-5h2v5h6v-8h3L12 3z"/></svg>
                    Register as Owner
                </button>
            </div>
        </div>

        {{-- Registration form --}}
        <form method="POST" action="{{ route('register') }}" x-show="role" x-cloak>
            @csrf

            <input type="hidden" name="role" x-bind:value="role" value="{{ $role ?? 'customer' }}">

            {{-- Name --}}
            <div style="margin-bottom: 16px;">
                <label class="label" for="name">Full Name</label>
                <input id="name" class="input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
                @error('name') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            {{-- Email --}}
            <div style="margin-bottom: 16px;">
                <label class="label" for="email">Email</label>
                <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com">
                @error('email') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            {{-- Password --}}
            <div style="margin-bottom: 16px;">
                <label class="label" for="password">Password</label>
                <input id="password" class="input" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 characters">
                @error('password') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            {{-- Confirm Password --}}
            <div style="margin-bottom: 20px;">
                <label class="label" for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" class="input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                @error('password_confirmation') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Create account</button>
        </form>
    </div>

    <div class="divider">or</div>

    <p style="text-align: center; font-size: 13px; color: var(--text-muted);">
        Already have an account?
        <a href="{{ route('login') }}" class="link">Sign in</a>
    </p>
</x-guest-layout>