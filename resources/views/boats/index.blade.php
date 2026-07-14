<x-app-layout>
    <x-slot name="header">
        <div class="page-header-row">
            <div>
                <h2>Browse boats</h2>
                <p>Find the perfect vessel for your fishing trip</p>
            </div>
        </div>
    </x-slot>

    {{-- Search and filters --}}
    <form method="GET" action="{{ route('boats.index') }}" style="margin-bottom: 24px;">
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" value="{{ request()->search }}" placeholder="Search boats..." class="input">
            </div>
            <select name="location" class="input" style="min-width: 160px;">
                <option value="">All Locations</option>
                @foreach($locations as $loc)
                    <option value="{{ $loc }}" {{ request()->location == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            @if(request()->hasAny(['search', 'location']))
                <a href="{{ route('boats.index') }}" class="btn btn-secondary btn-sm">Clear</a>
            @endif
        </div>
    </form>

    {{-- Boat Grid --}}
    @if($boats->count())
        <div class="grid-3">
            @foreach($boats as $boat)
                @php
                    $rating = round($boat->reviews_avg_rating ?? 0);
                    $reviewCount = $boat->reviews_count ?? 0;
                @endphp
                <div class="card">
                    {{-- Image area --}}
                    <div style="height: 160px; display: flex; align-items: center; justify-content: center; position: relative; background: var(--bg-elevated); border-bottom: 1px solid var(--border);">
                        <span style="font-size: 48px; font-weight: 600; color: rgba(6, 182, 212, 0.12); font-family: 'Inter', sans-serif;">{{ strtoupper(substr($boat->name, 0, 1)) }}</span>
                        <span style="position: absolute; top: 12px; left: 12px; font-size: 11px; color: var(--text-muted); background: rgba(0,0,0,0.3); padding: 4px 8px; border-radius: 6px; letter-spacing: 0.02em;">{{ $boat->location ?? '—' }}</span>
                    </div>

                    {{-- Card body --}}
                    <div style="padding: 16px;">
                        <h3 style="font-size: 15px; font-weight: 600; margin: 0;">{{ $boat->name }}</h3>
                        <p style="font-size: 13px; color: var(--text-muted); margin: 2px 0 0;">{{ ucfirst($boat->type) }} &middot; {{ $boat->capacity }} pax</p>

                        @if($boat->description)
                            <p style="font-size: 13px; color: var(--text-muted); margin: 8px 0 0; line-height: 1.4;">{{ Str::limit($boat->description, 90) }}</p>
                        @endif

                        {{-- Rating --}}
                        <div style="display: flex; align-items: center; gap: 4px; margin-top: 10px;">
                            @for($i = 1; $i <= 5; $i++)
                                <svg width="13" height="13" viewBox="0 0 20 20" fill="{{ $i <= $rating ? '#f59e0b' : '#334155' }}"><path d="M10 1.5l2.6 5.6 6.1.6-4.6 4.1 1.3 6-5.4-3.2-5.4 3.2 1.3-6-4.6-4.1 6.1-.6z"/></svg>
                            @endfor
                            <span style="font-size: 12px; color: var(--text-muted); margin-left: 4px;">
                                {{ $rating > 0 ? number_format($boat->reviews_avg_rating, 1) : 'New' }}{{ $reviewCount ? " ({$reviewCount})" : '' }}
                            </span>
                        </div>

                        {{-- Price + CTA --}}
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border);">
                            <div>
                                @if($boat->price_per_hour)
                                    <span style="font-size: 18px; font-weight: 600;">RM {{ number_format($boat->price_per_hour, 0) }}</span>
                                    <span style="font-size: 12px; color: var(--text-muted);">/hr</span>
                                @elseif($boat->price_per_trip)
                                    <span style="font-size: 18px; font-weight: 600;">RM {{ number_format($boat->price_per_trip, 0) }}</span>
                                    <span style="font-size: 12px; color: var(--text-muted);">/trip</span>
                                @else
                                    <span style="font-size: 13px; color: var(--text-muted);">Price on request</span>
                                @endif
                            </div>
                            <a href="{{ route('boats.show', $boat) }}" class="btn btn-secondary btn-sm">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div style="margin-top: 24px; display: flex; justify-content: center;">
            {{ $boats->links() }}
        </div>
    @else
        <div class="card" style="text-align: center; padding: 64px 24px;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--text-muted); margin-bottom: 12px;">
                <path d="M2 20l1.5-3L7 12l3.5 5L12 20l1.5-3L17 12l3.5 5L22 20"/>
            </svg>
            <p style="font-size: 15px; font-weight: 500; margin: 0 0 4px;">{{ $boats->count() ? 'No boats match your search' : 'No boats available yet' }}</p>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">{{ $boats->count() ? 'Try adjusting your filters' : 'Check back later' }}</p>
        </div>
    @endif
</x-app-layout>
