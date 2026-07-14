<x-app-layout>
    <x-slot name="header">
        <div class="page-header-row">
            <div>
                <a href="{{ route('owner.boats.index') }}" class="flex items-center gap-1.5 text-sm hover:underline" style="color: var(--text-muted);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Back to My Fleet
                </a>
                <h2 style="font-size: 18px; font-weight: 600; margin: 8px 0 0;">{{ $boat->name }}</h2>
            </div>
            <a href="{{ route('owner.boats.edit', $boat) }}" class="btn btn-secondary btn-sm">Edit Boat</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl">
            <div class="card" style="padding: 24px;">
                {{-- Specs --}}
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 20px; margin-bottom: 24px;">
                    <div>
                        <p style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Type</p>
                        <p style="font-size: 14px; font-weight: 500; margin-top: 2px;">{{ ucfirst($boat->type) }}</p>
                    </div>
                    <div>
                        <p style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Capacity</p>
                        <p style="font-size: 14px; font-weight: 500; margin-top: 2px;">{{ $boat->capacity }} pax</p>
                    </div>
                    <div>
                        <p style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Location</p>
                        <p style="font-size: 14px; font-weight: 500; margin-top: 2px;">{{ $boat->location ?? '—' }}</p>
                    </div>
                    <div>
                        <p style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Status</p>
                        <span class="badge {{ $boat->status === 'active' ? 'badge-green' : 'badge-gray' }}" style="margin-top: 4px;">{{ ucfirst($boat->status) }}</span>
                    </div>
                </div>

                {{-- Description --}}
                @if($boat->description)
                    <div style="padding-top: 20px; border-top: 1px solid var(--border); margin-bottom: 24px;">
                        <h3 style="font-size: 13px; font-weight: 600; margin: 0 0 6px; color: var(--text-muted);">Description</h3>
                        <p style="font-size: 14px; line-height: 1.6; color: var(--text-muted); margin: 0;">{{ $boat->description }}</p>
                    </div>
                @endif

                {{-- Pricing --}}
                <div style="padding-top: 20px; border-top: 1px solid var(--border); margin-bottom: 24px;">
                    <h3 style="font-size: 13px; font-weight: 600; margin: 0 0 12px; color: var(--text-muted);">Pricing</h3>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        @if($boat->price_per_hour)
                            <div style="padding: 12px 16px; border-radius: var(--radius); background: var(--bg-elevated); border: 1px solid var(--border);">
                                <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Per Hour</p>
                                <p style="font-size: 18px; font-weight: 600; margin: 4px 0 0;">RM {{ number_format($boat->price_per_hour, 0) }}</p>
                            </div>
                        @endif
                        @if($boat->price_per_trip)
                            <div style="padding: 12px 16px; border-radius: var(--radius); background: var(--bg-elevated); border: 1px solid var(--border);">
                                <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Per Trip</p>
                                <p style="font-size: 18px; font-weight: 600; margin: 4px 0 0;">RM {{ number_format($boat->price_per_trip, 0) }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Bookings --}}
                <div style="padding-top: 20px; border-top: 1px solid var(--border);">
                    <h3 style="font-size: 13px; font-weight: 600; margin: 0 0 12px; color: var(--text-muted);">Bookings</h3>
                    @if($boat->bookings->count())
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            @foreach($boat->bookings as $booking)
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; border-radius: 8px; background: var(--bg-elevated); border: 1px solid var(--border);">
                                    <div>
                                        <p style="font-size: 13px; font-weight: 500; margin: 0;">{{ $booking->customer_name }}</p>
                                        <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">
                                            {{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }} &middot; {{ $booking->start_time }} - {{ $booking->end_time }} &middot; {{ $booking->pax }} pax
                                        </p>
                                    </div>
                                    <span class="badge {{ $booking->status === 'confirmed' ? 'badge-green' : ($booking->status === 'pending' ? 'badge-yellow' : 'badge-red') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">No bookings yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
