<x-app-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --abyss: #070C13;
            --panel: #0D1620;
            --panel-2: #111C28;
            --edge: #223244;
            --cyan: #4FD8E0;
            --cyan-dim: #1F5A5E;
            --cyan-glow: rgba(79,216,224,0.35);
            --amber: #F0A94E;
            --amber-dim: #6B5228;
            --amber-glow: rgba(240,169,78,0.4);
            --green: #5FD98A;
            --green-glow: rgba(95,217,138,0.4);
            --red: #FF6B6B;
            --mist: #9FB4C4;
            --mist-dim: #5C7286;
            --text: #E7F0F4;
        }

        body { font-family: 'Inter', system-ui, sans-serif; color: var(--text); background: var(--abyss); }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        .bg-abyss {
            background-color: var(--abyss);
            background-image:
                linear-gradient(rgba(79,216,224,0.045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(79,216,224,0.045) 1px, transparent 1px);
            background-size: 42px 42px;
        }

        .console-panel {
            background: var(--panel);
            border: 1px solid var(--edge);
            clip-path: polygon(16px 0, 100% 0, 100% calc(100% - 16px), calc(100% - 16px) 100%, 0 100%, 0 16px);
            position: relative;
        }
        .console-panel::before, .console-panel::after { content: ""; position: absolute; width: 11px; height: 11px; pointer-events: none; }
        .console-panel::before { top: -1px; left: -1px; border-top: 2px solid var(--cyan); border-left: 2px solid var(--cyan); opacity: 0.7; }
        .console-panel::after { bottom: -1px; right: -1px; border-bottom: 2px solid var(--cyan); border-right: 2px solid var(--cyan); opacity: 0.7; }

        .panel-head {
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem;
            padding: 0.9rem 1.25rem; border-bottom: 1px solid var(--edge);
        }
        .panel-title {
            font-family: 'JetBrains Mono', monospace; font-size: 0.7rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: var(--cyan); display: flex; align-items: center; gap: 0.5rem;
        }
        .panel-title::before { content: ""; width: 6px; height: 6px; background: var(--cyan); border-radius: 50%; box-shadow: 0 0 6px var(--cyan); }

        .hero-console {
            background: radial-gradient(120% 140% at 100% 0%, #10202A 0%, var(--panel) 60%);
            border: 1px solid var(--edge);
            border-radius: 1rem;
            overflow: hidden;
        }
        .legend-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.1rem 1.5rem; }
        .legend-item { display: flex; align-items: center; gap: 0.65rem; }
        .legend-led { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .led-cyan  { background: var(--cyan);  box-shadow: 0 0 8px var(--cyan-glow); }
        .led-green { background: var(--green); box-shadow: 0 0 8px var(--green-glow); animation: pulse-op 2.2s ease-in-out infinite; }
        .led-mist  { background: var(--mist-dim); }
        .led-amber { background: var(--amber); box-shadow: 0 0 8px var(--amber-glow); }
        @keyframes pulse-op { 0%,100% { opacity: 1; } 50% { opacity: 0.3; } }

        /* Owner CTA - amber, matches "priority" meaning from legend */
        .owner-btn {
            display: inline-flex; align-items: center; gap: 0.55rem;
            padding: 0.55rem 1rem;
            border: 1px solid var(--amber);
            background: rgba(240,169,78,0.1);
            color: var(--amber);
            font-family: 'JetBrains Mono', monospace; font-size: 0.7rem; font-weight: 600;
            letter-spacing: 0.05em; text-transform: uppercase;
            clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);
            transition: all 0.15s ease;
        }
        .owner-btn:hover { background: rgba(240,169,78,0.18); box-shadow: 0 0 10px var(--amber-glow); }

        /* Compass / location radar */
        .radar-wrap { width: 210px; height: 210px; position: relative; margin: 0 auto; }
        .radar-face {
            position: absolute; inset: 0; border-radius: 50%;
            background: radial-gradient(circle at 50% 50%, #0B1620 0%, #060C12 100%);
            border: 1px solid var(--edge);
            overflow: hidden;
        }
        .radar-ring { position: absolute; top: 50%; left: 50%; border: 1px solid rgba(79,216,224,0.16); border-radius: 50%; transform: translate(-50%,-50%); }
        .radar-spokes { position: absolute; inset: 0;
            background:
                linear-gradient(rgba(79,216,224,0.14) 1px, transparent 1px) center / 1px 100% no-repeat,
                linear-gradient(90deg, rgba(79,216,224,0.14) 1px, transparent 1px) center / 100% 1px no-repeat;
        }
        .radar-sweep {
            position: absolute; inset: 0; border-radius: 50%;
            background: conic-gradient(from 0deg, var(--cyan-glow), transparent 22%, transparent 100%);
            animation: radar-spin 5s linear infinite;
            mix-blend-mode: screen;
        }
        @keyframes radar-spin { to { transform: rotate(360deg); } }
        .radar-center { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); text-align: center; z-index: 5; }
        .harbor-blip {
            position: absolute; top: 50%; left: 50%; width: 10px; height: 10px; margin: -5px;
            border-radius: 50%; transform: rotate(var(--angle)) translate(var(--radius));
            cursor: pointer; transition: transform 0.15s ease, box-shadow 0.15s ease;
            background: var(--cyan); box-shadow: 0 0 6px var(--cyan-glow);
            border: 2px solid var(--abyss);
        }
        .harbor-blip.is-active { background: var(--amber); box-shadow: 0 0 10px var(--amber-glow); transform: rotate(var(--angle)) translate(var(--radius)) scale(1.3); }
        .harbor-blip:hover { box-shadow: 0 0 10px var(--cyan-glow); }

        .console-input {
            background: var(--panel-2); border: 1px solid var(--edge); color: var(--text);
            font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;
            padding: 0.5rem 0.85rem 0.5rem 2.1rem; border-radius: 0.5rem;
            outline: none; transition: border-color 0.15s ease, box-shadow 0.15s ease;
            width: 100%; max-width: 260px;
        }
        .console-input:focus { border-color: var(--cyan); box-shadow: 0 0 0 3px rgba(79,216,224,0.12); }
        .console-input::placeholder { color: var(--mist-dim); }
        .search-wrap { position: relative; }
        .search-wrap svg { position: absolute; left: 0.7rem; top: 50%; transform: translateY(-50%); color: var(--mist-dim); pointer-events: none; }

        .filter-chip {
            font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; letter-spacing: 0.05em;
            padding: 0.35rem 0.7rem; border: 1px solid var(--amber); color: var(--amber);
            background: rgba(240,169,78,0.1); border-radius: 0.4rem;
            display: inline-flex; align-items: center; gap: 0.4rem;
        }

        /* Boat cards */
        .boat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem; }
        .boat-card {
            background: var(--panel); border: 1px solid var(--edge); border-radius: 0.75rem;
            overflow: hidden; transition: border-color 0.18s ease, transform 0.18s ease, box-shadow 0.18s ease;
        }
        .boat-card:hover { border-color: var(--cyan-dim); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.35); }
        .boat-thumb {
            height: 140px; background: var(--panel-2);
            display: flex; align-items: center; justify-content: center;
            border-bottom: 1px solid var(--edge); position: relative;
        }
        .boat-thumb-letter { font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 2rem; color: var(--cyan-dim); }
        .boat-location-tag {
            position: absolute; top: 0.6rem; left: 0.6rem;
            font-family: 'JetBrains Mono', monospace; font-size: 0.62rem; letter-spacing: 0.05em;
            padding: 0.25rem 0.55rem; background: rgba(7,12,19,0.75); border: 1px solid var(--edge);
            color: var(--mist); border-radius: 0.3rem; text-transform: uppercase;
        }
        .capacity-bar { display: flex; gap: 2px; }
        .capacity-seg { width: 4px; height: 11px; background: var(--edge); border-radius: 1px; }
        .capacity-seg.is-lit { background: var(--cyan); box-shadow: 0 0 4px var(--cyan-glow); }

        .star { width: 13px; height: 13px; }
        .star.is-lit { color: var(--amber); }
        .star.is-dim { color: var(--edge); }

        .book-btn {
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            width: 100%; padding: 0.6rem; margin-top: 0.9rem;
            border: 1px solid var(--cyan-dim); background: rgba(79,216,224,0.08); color: var(--text);
            font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; font-weight: 600;
            letter-spacing: 0.08em; text-transform: uppercase; border-radius: 0.4rem;
            transition: all 0.15s ease;
        }
        .book-btn:hover { border-color: var(--cyan); background: rgba(79,216,224,0.16); }
    </style>

    <div class="py-10 bg-abyss min-h-screen"
         x-data="{ query: '', location: '',
                    matches(name, type, loc) {
                        const q = this.query.toLowerCase();
                        const textOk = !q || (name + ' ' + type).toLowerCase().includes(q);
                        const locOk = !this.location || loc === this.location;
                        return textOk && locOk;
                    } }">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @php
                $totalBoats = $boats->count();
                $locations = $boats->pluck('location')->filter()->unique()->values();
                $totalLocations = $locations->count();
                $ratedBoats = $boats->filter(fn($b) => ($b->reviews_avg_rating ?? 0) > 0);
                $avgRating = $ratedBoats->count() ? $ratedBoats->avg('reviews_avg_rating') : null;
                $avgHourly = $boats->where('price_per_hour', '>', 0)->avg('price_per_hour');
            @endphp

            {{-- ===== Hero console ===== --}}
            <div class="hero-console px-6 sm:px-9 py-8 mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-[1fr_240px] gap-10 items-center">
                    <div>
                        <div class="flex items-center justify-between flex-wrap gap-3 mb-5">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="var(--cyan)" stroke-width="1.5">
                                    <path d="M12 2v20M6 8l6-2 6 2M4 15c1.5 2 3.5 3 8 3s6.5-1 8-3l-2-7H6l-2 7z"/>
                                </svg>
                                <span class="font-mono text-xs tracking-[0.2em] text-[color:var(--mist)] uppercase">Boatbuku &middot; Charter Deck</span>
                            </div>

                            @if(auth()->user()->isOwner())
                                <a href="{{ route('owner.dashboard') }}" class="owner-btn">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                                    Owner Console
                                </a>
                            @endif
                        </div>

                        <h1 class="font-display text-3xl sm:text-4xl font-semibold mb-1">Find your vessel</h1>
                        <p class="text-sm text-[color:var(--mist)] mb-6">Live availability across every registered harbor.</p>

                        <div class="legend-grid">
                            <div class="legend-item">
                                <span class="legend-led led-cyan"></span>
                                <div>
                                    <p class="font-display text-xl font-semibold leading-none">{{ $totalBoats }}</p>
                                    <span class="font-mono text-[0.65rem] uppercase tracking-wider text-[color:var(--mist-dim)]">Boats Available</span>
                                </div>
                            </div>
                            <div class="legend-item">
                                <span class="legend-led led-green"></span>
                                <div>
                                    <p class="font-display text-xl font-semibold leading-none">{{ $totalLocations }}</p>
                                    <span class="font-mono text-[0.65rem] uppercase tracking-wider text-[color:var(--mist-dim)]">Harbors</span>
                                </div>
                            </div>
                            <div class="legend-item">
                                <span class="legend-led led-amber"></span>
                                <div>
                                    <p class="font-display text-xl font-semibold leading-none">{{ $avgRating ? number_format($avgRating, 1) : '&mdash;' }}</p>
                                    <span class="font-mono text-[0.65rem] uppercase tracking-wider text-[color:var(--mist-dim)]">Avg Rating</span>
                                </div>
                            </div>
                            <div class="legend-item">
                                <span class="legend-led led-mist"></span>
                                <div>
                                    <p class="font-display text-xl font-semibold leading-none">{{ $avgHourly ? 'RM ' . number_format($avgHourly, 0) : '&mdash;' }}</p>
                                    <span class="font-mono text-[0.65rem] uppercase tracking-wider text-[color:var(--mist-dim)]">Avg RM/hr</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Location compass --}}
                    <div>
                        <div class="radar-wrap">
                            <div class="radar-face">
                                <div class="radar-ring" style="width:70px; height:70px;"></div>
                                <div class="radar-ring" style="width:130px; height:130px;"></div>
                                <div class="radar-ring" style="width:190px; height:190px;"></div>
                                <div class="radar-spokes"></div>
                                <div class="radar-sweep"></div>
                                @foreach($locations as $loc)
                                    <span class="harbor-blip"
                                          :class="{ 'is-active': location === '{{ $loc }}' }"
                                          @click="location = (location === '{{ $loc }}') ? '' : '{{ $loc }}'"
                                          style="--angle: {{ (360 / max($locations->count(),1)) * $loop->index }}deg; --radius: {{ 55 + ($loop->index % 3) * 30 }}px;"
                                          title="{{ $loc }}"></span>
                                @endforeach
                            </div>
                            <div class="radar-center">
                                <p class="font-display text-lg font-bold">{{ $totalLocations }}</p>
                                <span class="font-mono text-[0.58rem] uppercase tracking-widest text-[color:var(--mist-dim)]">Harbors</span>
                            </div>
                        </div>
                        <p class="text-center font-mono text-[0.62rem] text-[color:var(--mist-dim)] uppercase tracking-widest mt-3">Tap a beacon to filter by harbor</p>
                    </div>
                </div>
            </div>

            {{-- ===== Search + filter bar ===== --}}
            <div class="console-panel px-5 py-4 mb-6 flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="search-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                        <input type="text" x-model="query" placeholder="Search boats..." class="console-input">
                    </div>
                    <template x-if="location">
                        <span class="filter-chip">
                            <span x-text="location"></span>
                            <svg class="w-3 h-3 cursor-pointer" @click="location = ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </span>
                    </template>
                </div>
                <span class="panel-title" style="border:none; padding:0;">Live Availability</span>
            </div>

            {{-- ===== Boat grid ===== --}}
            @if($boats->count())
                <div class="boat-grid">
                    @foreach($boats as $boat)
                        @php
                            $rating = round($boat->reviews_avg_rating ?? 0);
                            $reviewCount = $boat->reviews_count ?? 0;
                        @endphp
                        <div x-show="matches('{{ addslashes($boat->name) }}', '{{ addslashes($boat->type) }}', '{{ addslashes($boat->location ?? '') }}')"
                             x-transition
                             class="boat-card">
                            <div class="boat-thumb">
                                @if($boat->location)
                                    <span class="boat-location-tag">{{ $boat->location }}</span>
                                @endif
                                <span class="boat-thumb-letter">{{ strtoupper(substr($boat->name, 0, 1)) }}</span>
                            </div>

                            <div class="p-4">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="font-semibold text-[color:var(--text)] truncate">{{ $boat->name }}</p>
                                    <span class="font-mono text-[0.6rem] text-[color:var(--mist-dim)] tracking-widest shrink-0">VSL-{{ str_pad($boat->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <p class="text-sm text-[color:var(--mist)] mt-0.5">{{ $boat->type }}</p>

                                <div class="flex items-center gap-1 mt-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="star {{ $i <= $rating ? 'is-lit' : 'is-dim' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M10 1.5l2.6 5.6 6.1.6-4.6 4.1 1.3 6-5.4-3.2-5.4 3.2 1.3-6-4.6-4.1 6.1-.6z"/></svg>
                                    @endfor
                                    <span class="font-mono text-[0.65rem] text-[color:var(--mist-dim)] ml-1">
                                        {{ $rating > 0 ? number_format($boat->reviews_avg_rating, 1) : 'No reviews' }}
                                        @if($reviewCount) ({{ $reviewCount }}) @endif
                                    </span>
                                </div>

                                <div class="flex items-center gap-3 mt-3">
                                    <span class="capacity-bar" title="Capacity {{ $boat->capacity }}">
                                        @for($i = 0; $i < 5; $i++)
                                            <span class="capacity-seg {{ $i < min(5, ceil($boat->capacity / 4)) ? 'is-lit' : '' }}"></span>
                                        @endfor
                                    </span>
                                    <span class="font-mono text-xs text-[color:var(--mist-dim)]">{{ $boat->capacity }} pax</span>
                                </div>

                                <div class="flex items-center gap-3 mt-2 font-mono text-xs" style="color: var(--cyan);">
                                    @if($boat->price_per_hour)
                                        <span>RM {{ number_format($boat->price_per_hour, 2) }}/hr</span>
                                    @endif
                                    @if($boat->price_per_trip)
                                        <span>RM {{ number_format($boat->price_per_trip, 2) }}/trip</span>
                                    @endif
                                    @if(!$boat->price_per_hour && !$boat->price_per_trip)
                                        <span class="text-[color:var(--mist-dim)]">Price on request</span>
                                    @endif
                                </div>

                                <a href="{{ route('boats.show', $boat) }}" class="book-btn">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Book this boat
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="console-panel p-14 text-center">
                    <div class="w-12 h-12 flex items-center justify-center mx-auto mb-4" style="background: var(--panel-2); border: 1px solid var(--edge); clip-path: polygon(8px 0, 100% 0, 100% calc(100% - 8px), calc(100% - 8px) 100%, 0 100%, 0 8px);">
                        <svg class="w-6 h-6" style="color: var(--cyan);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 2v20M6 8l6-2 6 2M4 15c1.5 2 3.5 3 8 3s6.5-1 8-3l-2-7H6l-2 7z"/>
                        </svg>
                    </div>
                    <p class="font-mono text-sm text-[color:var(--mist-dim)]">// no vessels registered yet</p>
                    <p class="text-[color:var(--mist)] mt-2">Check back soon &mdash; new boats are added regularly.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
