<x-app-layout>
    <x-slot name="header">
        <div class="page-header-row">
            <div>
                <h2>All Bookings</h2>
                <p>Manage all booking requests for your fleet</p>
            </div>
            <a href="{{ route('owner.dashboard') }}" class="btn btn-secondary btn-sm">Back to Dashboard</a>
        </div>
    </x-slot>

    @if($bookings->count())
        <div class="card" style="overflow: hidden;">
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Boat</th>
                            <th>Date &amp; Time</th>
                            <th>Pax</th>
                            <th>Notes</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>
                                    <div style="font-weight: 500;">{{ $booking->customer_name }}</div>
                                    @if($booking->customer_phone)
                                        <div style="font-size: 12px; color: var(--text-muted);">{{ $booking->customer_phone }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $booking->boat->name }}</div>
                                    <div style="font-size: 12px; color: var(--text-muted);">{{ $booking->boat->location ?? '—' }}</div>
                                </td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}</div>
                                    <div style="font-size: 12px; color: var(--text-muted);">{{ $booking->start_time }} - {{ $booking->end_time }}</div>
                                </td>
                                <td>{{ $booking->pax }}</td>
                                <td style="max-width: 150px;">
                                    @if($booking->notes)
                                        <span style="font-size: 13px; color: var(--text-muted);">{{ Str::limit($booking->notes, 40) }}</span>
                                    @else
                                        <span style="font-size: 13px; color: var(--text-muted);">—</span>
                                    @endif
                                </td>
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
        </div>
    @else
        <div class="card" style="text-align: center; padding: 64px 24px;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--text-muted); margin-bottom: 12px;">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p style="font-size: 15px; font-weight: 500; margin: 0 0 4px;">No bookings yet</p>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Booking requests from customers will appear here.</p>
        </div>
    @endif
</x-app-layout>
