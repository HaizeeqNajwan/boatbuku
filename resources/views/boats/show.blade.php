<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-1.5 text-sm hover:underline" style="color: var(--text-muted);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to dashboard
        </a>
    </x-slot>

    <div class="py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: Boat details --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Hero --}}
                <div style="height: 240px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius); background: var(--bg-elevated); border: 1px solid var(--border); position: relative;">
                    <span style="font-size: 72px; font-weight: 600; color: rgba(6, 182, 212, 0.1); font-family: 'Inter', sans-serif;">{{ strtoupper(substr($boat->name, 0, 1)) }}</span>
                    @if($boat->location)
                        <span style="position: absolute; top: 16px; left: 16px; font-size: 11px; color: var(--text-muted); background: rgba(0,0,0,0.3); padding: 4px 10px; border-radius: 8px; letter-spacing: 0.02em;">{{ $boat->location }}</span>
                    @endif
                    <span style="position: absolute; top: 16px; right: 16px;" class="badge {{ $boat->status === 'active' ? 'badge-green' : 'badge-gray' }}">
                        {{ ucfirst($boat->status) }}
                    </span>
                </div>

                {{-- Info card --}}
                <div class="card" style="padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;">
                        <div>
                            <h1 style="font-size: 22px; font-weight: 600; margin: 0;">{{ $boat->name }}</h1>
                            <p style="font-size: 14px; color: var(--text-muted); margin: 4px 0 0;">{{ ucfirst($boat->type) }} &middot; Up to {{ $boat->capacity }} passengers</p>
                        </div>
                        <div style="text-align: right; flex-shrink: 0;">
                            @if($boat->price_per_hour)
                                <span style="font-size: 24px; font-weight: 600;">RM {{ number_format($boat->price_per_hour, 0) }}</span>
                                <span style="font-size: 13px; color: var(--text-muted);">/hour</span>
                            @elseif($boat->price_per_trip)
                                <span style="font-size: 24px; font-weight: 600;">RM {{ number_format($boat->price_per_trip, 0) }}</span>
                                <span style="font-size: 13px; color: var(--text-muted);">/trip</span>
                            @else
                                <span style="font-size: 14px; color: var(--text-muted);">Price on request</span>
                            @endif
                        </div>
                    </div>

                    {{-- Rating --}}
                    <div style="display: flex; align-items: center; gap: 6px; margin-top: 12px;">
                        @php
                            $rating = round($boat->reviews_avg_rating ?? 0);
                            $reviewCount = $boat->reviews_count ?? 0;
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="{{ $i <= $rating ? '#f59e0b' : '#334155' }}"><path d="M10 1.5l2.6 5.6 6.1.6-4.6 4.1 1.3 6-5.4-3.2-5.4 3.2 1.3-6-4.6-4.1 6.1-.6z"/></svg>
                        @endfor
                        <span style="font-size: 13px; color: var(--text-muted);">
                            {{ $rating > 0 ? number_format($boat->reviews_avg_rating, 1) : 'No reviews' }}{{ $reviewCount ? " ({$reviewCount} reviews)" : '' }}
                        </span>
                    </div>

                    {{-- Description --}}
                    @if($boat->description)
                        <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border);">
                            <h3 style="font-size: 14px; font-weight: 600; margin: 0 0 6px;">About this boat</h3>
                            <p style="font-size: 14px; color: var(--text-muted); line-height: 1.6; margin: 0;">{{ $boat->description }}</p>
                        </div>
                    @endif

                    {{-- Specs grid --}}
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 16px; margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border);">
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
                    </div>
                </div>

                {{-- Reviews --}}
                <div class="card" style="padding: 24px;">
                    <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 20px;">Reviews</h3>

                    {{-- Review form --}}
                    @php
                        $hasReviewed = \App\Models\Review::where('boat_id', $boat->id)->where('user_id', auth()->id())->exists();
                    @endphp
                    @if(!$hasReviewed && auth()->user() && auth()->user()->isCustomer())
                        <form method="POST" action="{{ route('reviews.store', $boat) }}" style="margin-bottom: 20px; padding: 16px; border-radius: var(--radius); background: var(--bg-elevated); border: 1px solid var(--border);">
                            @csrf
                            <h4 style="font-size: 13px; font-weight: 600; margin: 0 0 12px; color: var(--text-muted);">Leave a review</h4>
                            <div style="display: flex; align-items: center; gap: 4px; margin-bottom: 12px;">
                                <span style="font-size: 13px; color: var(--text-muted); margin-right: 4px;">Rating:</span>
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating({{ $i }})" class="review-star" data-rating="{{ $i }}" style="background: none; border: none; cursor: pointer; padding: 0;">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="#334155"><path d="M10 1.5l2.6 5.6 6.1.6-4.6 4.1 1.3 6-5.4-3.2-5.4 3.2 1.3-6-4.6-4.1 6.1-.6z"/></svg>
                                    </button>
                                @endfor
                                @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" class="hidden" {{ $i === 3 ? 'checked' : '' }}>
                                @endfor
                            </div>
                            <textarea name="comment" rows="3" class="input" placeholder="Share your experience..." style="margin-bottom: 10px;"></textarea>
                            <button type="submit" class="btn btn-primary btn-sm">Submit Review</button>
                        </form>
                    @endif

                    @if($boat->reviews->count())
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            @foreach($boat->reviews->sortByDesc('created_at') as $review)
                                <div style="padding-bottom: 16px; border-bottom: 1px solid var(--border);">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--accent); color: #000; font-weight: 600; font-size: 12px; display: flex; align-items: center; justify-content: center;">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
                                            <span style="font-size: 13px; font-weight: 500;">{{ $review->user->name }}</span>
                                        </div>
                                        <span style="font-size: 12px; color: var(--text-muted);">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div style="display: flex; gap: 2px; margin-bottom: 4px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg width="12" height="12" viewBox="0 0 20 20" fill="{{ $i <= $review->rating ? '#f59e0b' : '#334155' }}"><path d="M10 1.5l2.6 5.6 6.1.6-4.6 4.1 1.3 6-5.4-3.2-5.4 3.2 1.3-6-4.6-4.1 6.1-.6z"/></svg>
                                        @endfor
                                    </div>
                                    @if($review->comment)
                                        <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin: 0;">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="font-size: 13px; color: var(--text-muted); text-align: center; padding: 20px 0; margin: 0;">No reviews yet. Be the first!</p>
                    @endif
                </div>
            </div>

            {{-- Right: Booking form --}}
            <div>
                <div class="card" style="padding: 24px; position: sticky; top: 80px;">
                    <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 20px;">Book this boat</h3>
                    <form method="POST" action="{{ route('bookings.store', $boat) }}">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 14px;">
                            <div>
                                <label class="label" for="date">Date</label>
                                <input type="date" id="date" name="date" class="input input-sm" required min="{{ date('Y-m-d') }}">
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div>
                                    <label class="label" for="start_time">Start</label>
                                    <input type="time" id="start_time" name="start_time" class="input input-sm" required value="08:00">
                                </div>
                                <div>
                                    <label class="label" for="end_time">End</label>
                                    <input type="time" id="end_time" name="end_time" class="input input-sm" required value="12:00">
                                </div>
                            </div>
                            <div>
                                <label class="label" for="pax">Passengers</label>
                                <input type="number" id="pax" name="pax" min="1" max="{{ $boat->capacity }}" value="1" class="input input-sm" required>
                            </div>
                            <div>
                                <label class="label" for="notes">Notes (optional)</label>
                                <textarea id="notes" name="notes" rows="2" class="input input-sm" placeholder="Special requests..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="margin-top: 4px;">
                                Request to Book
                            </button>
                        </div>
                    </form>

                    @if($boat->owner->profile && $boat->owner->profile->whatsapp)
                        <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border);">
                            <p style="font-size: 12px; color: var(--text-muted); margin: 0 0 8px;">Or contact the owner</p>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $boat->owner->profile->whatsapp) }}" target="_blank" class="flex items-center gap-2 text-sm font-medium" style="color: var(--green); text-decoration: none;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                WhatsApp Owner
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function setRating(rating) {
            document.querySelectorAll('.review-star svg').forEach((star, i) => {
                star.setAttribute('fill', i < rating ? '#f59e0b' : '#334155');
            });
            document.getElementById('rating-' + rating).checked = true;
        }
    </script>
</x-app-layout>
