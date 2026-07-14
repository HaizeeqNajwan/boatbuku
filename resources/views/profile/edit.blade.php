<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 18px; font-weight: 600; margin: 0;">Profile Settings</h2>
        <p style="font-size: 13px; color: var(--text-muted); margin: 4px 0 0;">Manage your account information</p>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl space-y-6">
            <div class="card" style="padding: 24px;">
                <h3 style="font-size: 15px; font-weight: 600; margin: 0 0 20px;">Profile Information</h3>
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="card" style="padding: 24px;">
                <h3 style="font-size: 15px; font-weight: 600; margin: 0 0 20px;">Update Password</h3>
                @include('profile.partials.update-password-form')
            </div>

            <div class="card" style="padding: 24px;">
                <h3 style="font-size: 15px; font-weight: 600; margin: 0 0 20px;">Delete Account</h3>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
