<x-app-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .flex-shrink-0 { display: none !important; }

        :root {
            --abyss: #070C13;
            --panel: #0D1620;
            --panel-2: #111C28;
            --edge: #223244;
            --cyan: #4FD8E0;
            --cyan-dim: #1F5A5E;
            --cyan-glow: rgba(79,216,224,0.35);
            --amber: #F0A94E;
            --amber-glow: rgba(240,169,78,0.4);
            --green: #5FD98A;
            --green-glow: rgba(95,217,138,0.4);
            --red: #FF6B6B;
            --red-glow: rgba(255,107,107,0.4);
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
        .scanline {
            position: fixed; inset: 0; pointer-events: none; z-index: 30;
            background: linear-gradient(to bottom, transparent 0%, rgba(79,216,224,0.05) 50%, transparent 100%);
            height: 220px;
            animation: scan 7s linear infinite;
            mix-blend-mode: screen;
        }
        @keyframes scan { 0% { transform: translateY(-220px); } 100% { transform: translateY(100vh); } }
        @keyframes pulse-op { 0%,100% { opacity: 1; } 50% { opacity: 0.3; } }

        /* ===== Console panels with cut corners + HUD brackets ===== */
        .console-panel {
            background: var(--panel);
            border: 1px solid var(--edge);
            clip-path: polygon(16px 0, 100% 0, 100% calc(100% - 16px), calc(100% - 16px) 100%, 0 100%, 0 16px);
            position: relative;
        }
        .console-panel::before, .console-panel::after {
            content: ""; position: absolute; width: 11px; height: 11px; pointer-events: none;
        }
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

        /* ===== Hero console ===== */
        .hero-console {
            background: radial-gradient(120% 140% at 100% 0%, #10202A 0%, var(--panel) 60%);
            border: 1px solid var(--edge);
            border-radius: 1rem;
            overflow: hidden;
            position: relative;
        }
        .legend-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.1rem 1.5rem; }
        .legend-item { display: flex; align-items: center; gap: 0.65rem; }
        .legend-led { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .led-cyan  { background: var(--cyan);  box-shadow: 0 0 8px var(--cyan-glow); }
        .led-green { background: var(--green); box-shadow: 0 0 8px var(--green-glow); animation: pulse-op 2.2s ease-in-out infinite; }
        .led-mist  { background: var(--mist-dim); }
        .led-amber { background: var(--amber); box-shadow: 0 0 8px var(--amber-glow); }

        /* ===== Radar ===== */
        .radar-wrap { width: 230px; height: 230px; position: relative; margin: 0 auto; }
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
            animation: radar-spin 4.5s linear infinite;
            mix-blend-mode: screen;
        }
        @keyframes radar-spin { to { transform: rotate(360deg); } }
        .radar-center { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); text-align: center; z-index: 5; }
        .radar-blip {
            position: absolute; top: 50%; left: 50%; width: 7px; height: 7px; margin: -3.5px;
            border-radius: 50%; transform: rotate(var(--angle)) translate(var(--radius));
            cursor: pointer; transition: transform 0.15s ease;
        }
        .blip-cyan { background: var(--cyan); box-shadow: 0 0 6px var(--cyan-glow); }

        /* ===== Search ===== */
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

        .console-btn {
            display: inline-flex; align-items: center; gap: 0.6rem;
            padding: 0.6rem 1rem;
            border: 1px solid var(--cyan-dim);
            background: rgba(79,216,224,0.08);
            color: var(--text);
            font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; font-weight: 600;
            letter-spacing: 0.05em; text-transform: uppercase;
            clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);
            transition: all 0.15s ease;
        }
        .console-btn:hover { border-color: var(--cyan); background: rgba(79,216,224,0.15); }

        .icon-btn {
            width: 2.2rem; height: 2.2rem; flex-shrink: 0;
            display: inline-flex; align-items: center; justify-content: center;
            border: 1px solid var(--edge); background: var(--panel-2); color: var(--mist);
            clip-path: polygon(6px 0, 100% 0, 100% calc(100% - 6px), calc(100% - 6px) 100%, 0 100%, 0 6px);
            transition: all 0.15s ease;
        }
        .icon-btn:hover { border-color: var(--cyan); color: var(--cyan); background: rgba(79,216,224,0.1); transform: translateY(-1px); }
        .icon-btn.danger:hover { border-color: var(--red); color: var(--red); background: rgba(255,107,107,0.1); }

        .led { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }

        /* ===== Interactive registry rows ===== */
        .registry-item { border-bottom: 1px solid var(--edge); transition: background 0.18s ease, box-shadow 0.18s ease; cursor: pointer; }
        .registry-item:last-child { border-bottom: none; }
        .registry-item:hover { background: rgba(79,216,224,0.05); box-shadow: inset 3px 0 0 var(--cyan); }
        .registry-item.is-open { background: rgba(79,216,224,0.06); box-shadow: inset 3px 0 0 var(--cyan); }

        .registry-tile {
            width: 3rem; height: 3rem; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            background: var(--panel-2); border: 1px solid var(--edge);
            color: var(--cyan); font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 1.15rem;
            clip-path: polygon(8px 0, 100% 0, 100% calc(100% - 8px), calc(100% - 8px) 100%, 0 100%, 0 8px);
            transition: box-shadow 0.18s ease;
        }
        .registry-item:hover .registry-tile { box-shadow: 0 0 12px var(--cyan-glow); }

        .capacity-bar { display: flex; gap: 2px; }
        .capacity-seg { width: 4px; height: 11px; background: var(--edge); border-radius: 1px; transition: background 0.3s ease, box-shadow 0.3s ease; }
        .capacity-seg.is-lit { background: var(--cyan); box-shadow: 0 0 4px var(--cyan-glow); }

        .chevron { transition: transform 0.2s ease; color: var(--mist-dim); }
        .registry-item.is-open .chevron { transform: rotate(90deg); color: var(--cyan); }

        .detail-row {
            background: #0A121B; border-top: 1px dashed var(--edge);
            display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1rem;
        }
        .detail-stat span { display: block; }

        .success-banner {
            background: rgba(95,217,138,0.08);
            border: 1px solid rgba(95,217,138,0.35);
            color: var(--green);
            border-radius: 0.6rem;
        }
    </style>

    <div class="scanline"></div>

    <div class="pt-8 pb-10 bg-abyss min-h-screen" x-data="{ query: '' }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @php
                $totalBoats = $boats->count();
                $totalCapacity = $boats->sum('capacity');
                $pricedBoats = $boats->filter(fn($b) => $b->price_per_hour || $b->price_per_trip);
                $avgHourly = $boats->where('price_per_hour', '>', 0)->avg('price_per_hour');
            @endphp

            {{-- ===== Hero console ===== --}}
            <div class="hero-console px-6 sm:px-9 py-8 mb-8 mt-6 sm:mt-10">
                <div class="grid grid-cols-1 lg:grid-cols-[1fr_260px] gap-10 items-center">
                    <div>
                        <div class="flex items-center gap-2.5 mb-5">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="var(--cyan)" stroke-width="1.5">
                                <circle cx="12" cy="12" r="9" opacity="0.4"/>
                                <circle cx="12" cy="12" r="5" opacity="0.7"/>
                                <circle cx="12" cy="12" r="1.4" fill="var(--cyan)" stroke="none"/>
                                <path d="M12 3v3M12 18v3M3 12h3M18 12h3" opacity="0.5"/>
                            </svg>
                            <span class="font-mono text-xs tracking-[0.2em] text-[color:var(--mist)] uppercase">Boatbuku &middot; Owner Dashboard</span>
                        </div>

                        <h1 class="font-display text-3xl sm:text-4xl font-semibold mb-1">My Boats</h1>
                        <p class="text-sm text-[color:var(--mist)] mb-6">Manage and track all your boats in one place.</p>

                        <div class="legend-grid">
                            <div class="legend-item">
                                <span class="legend-led led-cyan"></span>
                                <div>
                                    <p class="font-display text-xl font-semibold leading-none">{{ $totalBoats }}</p>
                                    <span class="font-mono text-[0.65rem] uppercase tracking-wider text-[color:var(--mist-dim)]">Total Boats</span>
                                </div>
                            </div>
                            <div class="legend-item">
                                <span class="legend-led led-green"></span>
                                <div>
                                    <p class="font-display text-xl font-semibold leading-none">{{ $totalCapacity }}</p>
                                    <span class="font-mono text-[0.65rem] uppercase tracking-wider text-[color:var(--mist-dim)]">Total Capacity</span>
                                </div>
                            </div>
                            <div class="legend-item">
                                <span class="legend-led led-amber"></span>
                                <div>
                                    <p class="font-display text-xl font-semibold leading-none">{{ $pricedBoats->count() }}</p>
                                    <span class="font-mono text-[0.65rem] uppercase tracking-wider text-[color:var(--mist-dim)]">With Pricing</span>
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

                    <div class="radar-wrap">
                        <div class="radar-face">
                            <div class="radar-ring" style="width:80px; height:80px;"></div>
                            <div class="radar-ring" style="width:140px; height:140px;"></div>
                            <div class="radar-ring" style="width:200px; height:200px;"></div>
                            <div class="radar-spokes"></div>
                            <div class="radar-sweep"></div>
                            @foreach($boats->take(10) as $boat)
                                <span class="radar-blip blip-cyan" style="--angle: {{ (360 / max($loop->count,1)) * $loop->index }}deg; --radius: {{ 40 + (min($boat->capacity, 20) * 3) }}px;" title="{{ $boat->name }}"></span>
                            @endforeach
                        </div>
                        <div class="radar-center">
                            <p class="font-display text-2xl font-bold">{{ $totalBoats }}</p>
                            <span class="font-mono text-[0.6rem] uppercase tracking-widest text-[color:var(--mist-dim)]">Boats</span>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 success-banner px-4 py-3 flex items-center gap-2 text-sm font-mono" role="alert">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($boats->count())
                <div class="console-panel overflow-hidden">
                    <div class="panel-head">
                        <span class="panel-title">Your Boats</span>
                        <div class="flex items-center gap-3">
                            <div class="search-wrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                                <input type="text" x-model="query" placeholder="Search boats..." class="console-input">
                            </div>
                            <a href="{{ route('owner.boats.create') }}" class="console-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Add Boat
                            </a>
                        </div>
                    </div>

                    @foreach($boats as $boat)
                        <div x-data="{ open: false }"
                             x-show="!query || '{{ strtolower($boat->name) }} {{ strtolower($boat->type) }}'.includes(query.toLowerCase())"
                             x-transition>
                            <div class="registry-item px-5 py-4 flex items-center gap-4" :class="{ 'is-open': open }" @click="open = !open">
                                <div class="registry-tile">{{ strtoupper(substr($boat->name, 0, 1)) }}</div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2.5 flex-wrap">
                                        <p class="font-semibold text-[color:var(--text)]">{{ $boat->name }}</p>
                                        <span class="font-mono text-[0.62rem] text-[color:var(--mist-dim)] tracking-widest">#{{ str_pad($boat->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        <span class="inline-flex items-center gap-1.5 font-mono text-[0.62rem] uppercase" style="color: var(--green);">
                                            <span class="led led-green"></span>Active
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                                        <span class="text-sm text-[color:var(--mist)]">{{ $boat->type }}</span>
                                        <span class="capacity-bar" title="Capacity {{ $boat->capacity }}">
                                            @for($i = 0; $i < 5; $i++)
                                                <span class="capacity-seg {{ $i < min(5, ceil($boat->capacity / 4)) ? 'is-lit' : '' }}"></span>
                                            @endfor
                                        </span>
                                        <span class="font-mono text-xs" style="color: var(--mist-dim);">{{ $boat->capacity }} pax</span>
                                        @if($boat->price_per_hour)
                                            <span class="font-mono text-xs" style="color: var(--cyan);">RM {{ number_format($boat->price_per_hour, 2) }}/hr</span>
                                        @endif
                                        @if($boat->price_per_trip)
                                            <span class="font-mono text-xs" style="color: var(--cyan);">RM {{ number_format($boat->price_per_trip, 2) }}/trip</span>
                                        @endif
                                        @if(!$boat->price_per_hour && !$boat->price_per_trip)
                                            <span class="font-mono text-xs text-[color:var(--mist-dim)]">no pricing set</span>
                                        @endif
                                    </div>
                                </div>

                                <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>

                                <div class="flex items-center gap-2 flex-shrink-0" @click.stop>
                                    <a href="{{ route('owner.boats.show', $boat) }}" class="icon-btn" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('owner.boats.edit', $boat) }}" class="icon-btn" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('owner.boats.destroy', $boat) }}" method="POST" onsubmit="return confirm('Delete this boat?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="icon-btn danger" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div x-show="open" x-transition x-cloak class="detail-row px-5 py-4">
                                <div class="detail-stat">
                                    <span class="font-mono text-[0.62rem] uppercase tracking-widest text-[color:var(--mist-dim)]">Boat ID</span>
                                    <span class="font-mono text-sm text-[color:var(--text)]">#{{ $boat->id }}</span>
                                </div>
                                <div class="detail-stat">
                                    <span class="font-mono text-[0.62rem] uppercase tracking-widest text-[color:var(--mist-dim)]">Type</span>
                                    <span class="font-mono text-sm text-[color:var(--text)]">{{ $boat->type }}</span>
                                </div>
                                <div class="detail-stat">
                                    <span class="font-mono text-[0.62rem] uppercase tracking-widest text-[color:var(--mist-dim)]">Registered</span>
                                    <span class="font-mono text-sm text-[color:var(--text)]">{{ $boat->created_at?->format('d M Y') ?? '—' }}</span>
                                </div>
                                <div class="detail-stat">
                                    <span class="font-mono text-[0.62rem] uppercase tracking-widest text-[color:var(--mist-dim)]">Capacity</span>
                                    <span class="font-mono text-sm text-[color:var(--text)]">{{ $boat->capacity }} passengers</span>
                                </div>
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
                    <p class="text-sm text-[color:var(--mist-dim)]">No boats added yet.</p>
                    <p class="text-[color:var(--mist)] mt-2">
                        <a href="{{ route('owner.boats.create') }}" class="font-semibold" style="color: var(--cyan);">Add your first boat</a> to start taking bookings.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
