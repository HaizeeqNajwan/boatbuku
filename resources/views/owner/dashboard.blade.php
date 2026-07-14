<x-app-layout>
    <x-slot name="header">
        <div class="page-header-row">
            <div>
                <h2>Dashboard</h2>
                <p>Manage your fleet and bookings</p>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('owner.boats.create') }}" class="btn btn-primary btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                    Add Boat
                </a>
                <a href="{{ route('owner.boats.index') }}" class="btn btn-secondary btn-sm">Manage Fleet</a>
            </div>
        </div>
    </x-slot>

    {{-- Stats --}}
    <div class="grid-4" style="margin-bottom: 32px;">
        <div class="stat">
            <div class="stat-value">{{ $stats['total_boats'] }}</div>
            <div class="stat-label">Active Boats</div>
        </div>
        <div class="stat">
            <div class="stat-value">{{ $stats['total_bookings'] }}</div>
            <div class="stat-label">Total Bookings</div>
        </div>
        <div class="stat">
            <div class="stat-value" style="color: var(--yellow);">{{ $stats['pending'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat">
            <div class="stat-value" style="color: var(--green);">{{ $stats['confirmed'] }}</div>
            <div class="stat-label">Confirmed</div>
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="card" style="margin-bottom: 24px; overflow: hidden;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 14px; font-weight: 600; margin: 0;">Recent Bookings</h3>
            <a href="{{ route('owner.bookings') }}" style="font-size: 13px; color: var(--accent); text-decoration: none;">View all</a>
        </div>

        @if($bookings->count())
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Boat</th>
                            <th>Date &amp; Time</th>
                            <th>Pax</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings->take(10) as $booking)
                            <tr>
                                <td>
                                    <div style="font-weight: 500;">{{ $booking->customer_name }}</div>
                                    @if($booking->customer_phone)
                                        <div style="font-size: 12px; color: var(--text-muted);">{{ $booking->customer_phone }}</div>
                                    @endif
                                </td>
                                <td>{{ $booking->boat->name }}</td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}</div>
                                    <div style="font-size: 12px; color: var(--text-muted);">{{ $booking->start_time }} - {{ $booking->end_time }}</div>
                                </td>
                                <td>{{ $booking->pax }}</td>
                                <td>
                                    <span class="badge {{ $booking->status === 'confirmed' ? 'badge-green' : ($booking->status === 'pending' ? 'badge-yellow' : 'badge-red') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($booking->status === 'pending')
                                        <div style="display: flex; gap: 4px;">
                                            <form method="POST" action="{{ route('owner.bookings.update', $booking) }}">
                                                @csrf
                                                <button type="submit" name="status" value="confirmed" class="btn btn-xs" style="background: rgba(16, 185, 129, 0.1); color: var(--green); border: 1px solid rgba(16, 185, 129, 0.2);">Confirm</button>
                                            </form>
                                            <form method="POST" action="{{ route('owner.bookings.update', $booking) }}">
                                                @csrf
                                                <button type="submit" name="status" value="rejected" class="btn btn-xs" style="background: rgba(239, 68, 68, 0.1); color: var(--red); border: 1px solid rgba(239, 68, 68, 0.2);">Reject</button>
                                            </form>
                                        </div>
                                    @else
                                        <span style="font-size: 12px; color: var(--text-muted);">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 32px;">
                <p style="font-size: 13px; color: var(--text-muted); margin: 0;">No bookings yet. New bookings will appear here.</p>
            </div>
        @endif
    </div>

    {{-- Your Boats --}}
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 14px; font-weight: 600; margin: 0;">Your Boats</h3>
            <a href="{{ route('owner.boats.index') }}" style="font-size: 13px; color: var(--accent); text-decoration: none;">Manage all</a>
        </div>

        @if($boats->count())
            <div class="grid-3">
                @foreach($boats as $boat)
                    <div class="card" style="padding: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <h4 style="font-size: 14px; font-weight: 600; margin: 0;">{{ $boat->name }}</h4>
                                <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">{{ ucfirst($boat->type) }} &middot; {{ $boat->capacity }} pax</p>
                            </div>
                            <span class="badge {{ $boat->status === 'active' ? 'badge-green' : 'badge-gray' }}">{{ ucfirst($boat->status) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border);">
                            <span style="font-size: 13px; color: var(--text-muted);">
                                @if($boat->price_per_hour)
                                    RM {{ number_format($boat->price_per_hour, 0) }}/hr
                                @elseif($boat->price_per_trip)
                                    RM {{ number_format($boat->price_per_trip, 0) }}/trip
                                @else
                                    On request
                                @endif
                            </span>
                            <a href="{{ route('owner.boats.edit', $boat) }}" style="font-size: 12px; color: var(--accent); text-decoration: none;">Edit</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card" style="text-align: center; padding: 40px;">
                <p style="font-size: 13px; color: var(--text-muted); margin: 0 0 12px;">You haven't added any boats yet.</p>
                <a href="{{ route('owner.boats.create') }}" class="btn btn-primary btn-sm">Add Your First Boat</a>
            </div>
        @endif
    </div>
</x-app-layout>
