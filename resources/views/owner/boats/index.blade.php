<x-app-layout>
    <x-slot name="header">
        <div class="page-header-row">
            <div>
                <h2>My Fleet</h2>
                <p>Manage your boats and their details</p>
            </div>
            <a href="{{ route('owner.boats.create') }}" class="btn btn-primary btn-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add Boat
            </a>
        </div>
    </x-slot>

    @if($boats->count())
        <div class="grid-3">
            @foreach($boats as $boat)
                <div class="card">
                    <div style="height: 140px; display: flex; align-items: center; justify-content: center; background: var(--bg-elevated); border-bottom: 1px solid var(--border); position: relative;">
                        <span style="font-size: 40px; font-weight: 600; color: rgba(6, 182, 212, 0.1);">{{ strtoupper(substr($boat->name, 0, 1)) }}</span>
                        @if($boat->location)
                            <span style="position: absolute; top: 10px; left: 10px; font-size: 11px; color: var(--text-muted); background: rgba(0,0,0,0.3); padding: 3px 8px; border-radius: 6px;">{{ $boat->location }}</span>
                        @endif
                    </div>
                    <div style="padding: 14px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <h3 style="font-size: 14px; font-weight: 600; margin: 0;">{{ $boat->name }}</h3>
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
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('owner.boats.edit', $boat) }}" style="font-size: 12px; color: var(--accent); text-decoration: none;">Edit</a>
                                <a href="{{ route('boats.show', $boat) }}" style="font-size: 12px; color: var(--text-muted); text-decoration: none;">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card" style="text-align: center; padding: 64px 24px;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--text-muted); margin-bottom: 12px;">
                <path d="M2 20l1.5-3L7 12l3.5 5L12 20l1.5-3L17 12l3.5 5L22 20"/>
            </svg>
            <p style="font-size: 15px; font-weight: 500; margin: 0 0 4px;">No boats in your fleet</p>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0 0 16px;">Add your first boat to start receiving bookings.</p>
            <a href="{{ route('owner.boats.create') }}" class="btn btn-primary btn-sm">Add Your First Boat</a>
        </div>
    @endif
</x-app-layout>
