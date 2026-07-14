<x-guest-layout>
    <h2 class="guest-title">Verify email</h2>
    <p class="guest-subtitle">Please verify your email address by clicking the link we emailed you.</p>

    <p style="font-size: 13px; color: var(--text-muted); text-align: center; margin-bottom: 20px;">
        Didn't receive the email? We'll send another one.
    </p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary" style="margin-bottom: 16px;">
            Resend verification email
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-secondary" style="width: 100%;">
            Sign out
        </button>
    </form>
</x-guest-layout>
