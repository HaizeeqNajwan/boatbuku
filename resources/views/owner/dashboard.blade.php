<x-app-layout>
    {{-- Space Grotesk: technical display face for headings/big numbers. Inter: UI/body. JetBrains Mono: HUD data/readouts --}}
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
            position: relative;
        }
        .scanline {
            position: fixed; inset: 0; pointer-events: none; z-index: 30;
            background: linear-gradient(to bottom, transparent 0%, rgba(79,216,224,0.05) 50%, transparent 100%);
            height: 220px;
            animation: scan 7s linear infinite;
            mix-blend-mode: screen;
        }
        @keyframes scan { 0% { transform: translateY(-220px); } 100% { transform: translateY(100vh); } }

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
            display: flex; align-items: center; justify-content: space-between;
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
        .status-pill {
            display: inline-flex; align-items: center; gap: 0.5rem;
            font-family: 'JetBrains Mono', monospace; font-size: 0.7rem; letter-spacing: 0.08em;
            padding: 0.35rem 0.8rem; border-radius: 999px; text-transform: uppercase;
        }
        .status-nominal { background: rgba(95,217,138,0.1); color: var(--green); border: 1px solid rgba(95,217,138,0.3); }
        .status-alert { background: rgba(240,169,78,0.1); color: var(--amber); border: 1px solid rgba(240,169,78,0.3); }
        .status-pill .pulse-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; box-shadow: 0 0 6px currentColor; animation: pulse-op 1.6s ease-in-out infinite; }
        @keyframes pulse-op { 0%,100% { opacity: 1; } 50% { opacity: 0.3; } }

        .legend-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.1rem 1.5rem; }
        .legend-item { display: flex; align-items: center; gap: 0.65rem; }
        .legend-led { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .led-cyan   { background: var(--cyan);  box-shadow: 0 0 8px var(--cyan-glow); }
        .led-green  { background: var(--green); box-shadow: 0 0 8px var(--green-glow); }
        .led-amber  { background: var(--amber); box-shadow: 0 0 8px var(--amber-glow); animation: pulse-op 1.6s ease-in-out infinite; }
        .led-mist   { background: var(--mist-dim); }

        /* ===== Radar ===== */
        .radar-wrap { width: 290px; height: 290px; position: relative; margin: 0 auto; }
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
        .radar-center {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
            text-align: center; z-index: 5;
        }
        .radar-blip {
            position: absolute; top: 50%; left: 50%; width: 7px; height: 7px; margin: -3.5px;
            border-radius: 50%; transform: rotate(var(--angle)) translate(var(--radius));
        }
        .blip-cyan  { background: var(--cyan);  box-shadow: 0 0 6px var(--cyan-glow); }
        .blip-green { background: var(--green); box-shadow: 0 0 6px var(--green-glow); }
        .blip-amber { background: var(--amber); box-shadow: 0 0 7px var(--amber-glow); animation: pulse-op 1.4s ease-in-out infinite; }

        /* ===== Alert contact strip ===== */
        .contact-card {
            min-width: 240px;
            background: var(--panel-2);
            border: 1px solid rgba(240,169,78,0.35);
            border-radius: 0.6rem;
            padding: 0.9rem 1rem;
            position: relative;
        }
        .contact-card::before {
            content: ""; position: absolute; left: 0; top: 0.75rem; bottom: 0.75rem; width: 3px;
            background: var(--amber); box-shadow: 0 0 8px var(--amber-glow); border-radius: 2px;
        }

        /* ===== Log table ===== */
        table th { font-family: 'JetBrains Mono', monospace; font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--mist-dim); font-weight: 500; }
        .log-row { border-bottom: 1px solid var(--edge); transition: background 0.15s ease; }
        .log-row:hover { background: rgba(79,216,224,0.05); }
        .led { width: 7px; height: 7px; border-radius: 50%; display: inline-block; margin-right: 0.5rem; }

        /* ===== Console buttons ===== */
        .console-btn {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.85rem 1rem;
            border: 1px solid var(--edge);
            background: var(--panel-2);
            clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);
            transition: all 0.15s ease;
        }
        .console-btn:hover { border-color: var(--cyan); background: rgba(79,216,224,0.07); }
        .console-btn.is-primary { border-color: var(--cyan-dim); background: rgba(79,216,224,0.08); }
        .console-btn.is-primary:hover { border-color: var(--cyan); background: rgba(79,216,224,0.14); }
        .console-btn-icon {
            width: 2.1rem; height: 2.1rem; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
            border-radius: 0.4rem; background: rgba(79,216,224,0.1); color: var(--cyan);
        }
        .console-btn-title { font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--text); font-weight: 600; }
        .console-btn-desc { font-size: 0.72rem; color: var(--mist-dim); margin-top: 0.1rem; }

        .registry-row { display: flex; align-items: center; gap: 0.7rem; padding: 0.6rem 0; border-bottom: 1px solid var(--edge); }
        .registry-row:last-child { border-bottom: none; }
        .capacity-bar { display: flex; gap: 2px; }
        .capacity-seg { width: 4px; height: 10px; background: var(--edge); border-radius: 1px; }
        .capacity-seg.is-lit { background: var(--cyan); box-shadow: 0 0 4px var(--cyan-glow); }

        .lcd {
            background: #061014; border: 1px solid var(--cyan-dim); border-radius: 0.6rem;
            padding: 1.1rem 1.25rem;
        }
        .lcd-value { font-family: 'JetBrains Mono', monospace; font-weight: 700; text-shadow: 0 0 12px var(--cyan-glow); }

        .scrollbar-thin::-webkit-scrollbar { height: 6px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: var(--edge); border-radius: 999px; }
    </style>

    <div class="scanline"></div>

    <div class="pt-8 pb-10 bg-abyss min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php
                $totalBoats = $boats->count();
                $totalBookings = $bookings->count();
                $pending = $bookings->where('status', 'pending');
                $pendingCount = $pending->count();
                $confirmedBookings = $bookings->where('status', 'confirmed');
                $confirmed = $confirmedBookings->count();
            @endphp

            {{-- ===== Hero: bridge console ===== --}}
            <div class="hero-console px-6 sm:px-9 py-8 mb-8 mt-6 sm:mt-10">
                <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-10 items-center">
                    {{-- Left: identity + status + legend --}}
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

                        <h1 class="font-display text-3xl sm:text-4xl font-semibold mb-1">Welcome back, {{ auth()->user()->name }}</h1>
                        <p class="font-mono text-xs text-[color:var(--mist-dim)] mb-5">{{ now()->format('l, d M Y') }} &middot; <span id="live-clock">{{ now()->format('H:i:s') }}</span></p>

                        @if($pendingCount > 0)
                            <div class="status-pill status-alert mb-6">
                                <span class="pulse-dot"></span>
                                {{ $pendingCount }} booking{{ $pendingCount === 1 ? '' : 's' }} awaiting review
                            </div>
                        @else
                            <div class="status-pill status-nominal mb-6">
                                <span class="pulse-dot"></span>
                                No bookings pending review
                            </div>
                        @endif

                        <div class="legend-grid">
                            <div class="legend-item">
                                <span class="legend-led led-cyan"></span>
                                <div>
                                    <p class="font-display text-xl font-semibold leading-none">{{ $totalBoats }}</p>
                                    <span class="font-mono text-[0.65rem] uppercase tracking-wider text-[color:var(--mist-dim)]">Total Boats</span>
                                </div>
                            </div>
                            <div class="legend-item">
                                <span class="legend-led led-mist"></span>
                                <div>
                                    <p class="font-display text-xl font-semibold leading-none">{{ $totalBookings }}</p>
                                    <span class="font-mono text-[0.65rem] uppercase tracking-wider text-[color:var(--mist-dim)]">Total Bookings</span>
                                </div>
                            </div>
                            <div class="legend-item">
                                <span class="legend-led led-green"></span>
                                <div>
                                    <p class="font-display text-xl font-semibold leading-none">{{ $confirmed }}</p>
                                    <span class="font-mono text-[0.65rem] uppercase tracking-wider text-[color:var(--mist-dim)]">Confirmed</span>
                                </div>
                            </div>
                            <div class="legend-item">
                                <span class="legend-led led-amber"></span>
                                <div>
                                    <p class="font-display text-xl font-semibold leading-none">{{ $pendingCount }}</p>
                                    <span class="font-mono text-[0.65rem] uppercase tracking-wider text-[color:var(--mist-dim)]">Pending</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: radar --}}
                    <div class="radar-wrap">
                        <div class="radar-face">
                            <div class="radar-ring" style="width:96px; height:96px;"></div>
                            <div class="radar-ring" style="width:168px; height:168px;"></div>
                            <div class="radar-ring" style="width:240px; height:240px;"></div>
                            <div class="radar-spokes"></div>
                            <div class="radar-sweep"></div>

                            @foreach($boats->take(6) as $boat)
                                <span class="radar-blip blip-cyan" style="--angle: {{ (360 / max($loop->count,1)) * $loop->index }}deg; --radius: 48px;" title="{{ $boat->name }}"></span>
                            @endforeach
                            @foreach($confirmedBookings->take(6) as $booking)
                                <span class="radar-blip blip-green" style="--angle: {{ (360 / max($loop->count,1)) * $loop->index + 25 }}deg; --radius: 84px;" title="{{ $booking->customer_name }}"></span>
                            @endforeach
                            @foreach($pending->take(6) as $booking)
                                <span class="radar-blip blip-amber" style="--angle: {{ (360 / max($loop->count,1)) * $loop->index + 50 }}deg; --radius: 120px;" title="{{ $booking->customer_name }}"></span>
                            @endforeach
                        </div>
                        <div class="radar-center">
                            <p class="font-display text-2xl font-bold">{{ $totalBookings }}</p>
                            <span class="font-mono text-[0.6rem] uppercase tracking-widest text-[color:var(--mist-dim)]">Bookings</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== Priority contacts: pending bookings ===== --}}
            @if($pendingCount > 0)
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="legend-led led-amber"></span>
                        <h3 class="font-mono text-xs uppercase tracking-[0.15em] text-[color:var(--mist)]">Pending Bookings &mdash; Needs Your Review</h3>
                    </div>
                    <div class="flex gap-3 overflow-x-auto scrollbar-thin pb-2">
                        @foreach($pending->take(8) as $booking)
                            <div class="contact-card">
                                <div class="pl-2">
                                    <span class="font-mono text-[0.62rem] text-[color:var(--mist-dim)] tracking-widest">BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <p class="font-semibold text-sm mt-1">{{ $booking->customer_name }}</p>
                                    <p class="text-xs text-[color:var(--mist-dim)] mt-0.5">{{ $booking->boat->name }}</p>
                                    <div class="flex items-center gap-2 mt-2 font-mono text-[0.68rem] text-[color:var(--mist)]">
                                        <span>{{ $booking->date }}</span>
                                        <span>&middot;</span>
                                        <span>{{ $booking->pax }} pax</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ===== Main grid ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left: booking transmission log --}}
                <div class="lg:col-span-2 console-panel overflow-hidden">
                    <div class="panel-head">
                        <span class="panel-title">Recent Bookings</span>
                        <span class="font-mono text-[0.65rem] text-[color:var(--mist-dim)]">Showing {{ min($totalBookings, 10) }} of {{ $totalBookings }}</span>
                    </div>
                    @if($bookings->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 text-left">Passenger</th>
                                        <th class="px-5 py-3 text-left">Boat</th>
                                        <th class="px-5 py-3 text-left">Date</th>
                                        <th class="px-5 py-3 text-left">Pax</th>
                                        <th class="px-5 py-3 text-left">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings->take(10) as $booking)
                                        <tr class="log-row">
                                            <td class="px-5 py-3.5 whitespace-nowrap font-medium text-sm">{{ $booking->customer_name }}</td>
                                            <td class="px-5 py-3.5 whitespace-nowrap text-sm text-[color:var(--mist)]">{{ $booking->boat->name }}</td>
                                            <td class="px-5 py-3.5 whitespace-nowrap font-mono text-xs text-[color:var(--mist-dim)]">{{ $booking->date }}</td>
                                            <td class="px-5 py-3.5 whitespace-nowrap font-mono text-xs text-[color:var(--mist-dim)]">{{ $booking->pax }}</td>
                                            <td class="px-5 py-3.5 whitespace-nowrap">
                                                @if($booking->status === 'pending')
                                                    <span class="led" style="background: var(--amber); box-shadow: 0 0 5px var(--amber-glow);"></span><span class="font-mono text-xs uppercase" style="color: var(--amber);">Pending</span>
                                                @elseif($booking->status === 'confirmed')
                                                    <span class="led" style="background: var(--green); box-shadow: 0 0 5px var(--green-glow);"></span><span class="font-mono text-xs uppercase" style="color: var(--green);">Confirmed</span>
                                                @elseif($booking->status === 'rejected')
                                                    <span class="led" style="background: var(--red); box-shadow: 0 0 5px var(--red-glow);"></span><span class="font-mono text-xs uppercase" style="color: var(--red);">Rejected</span>
                                                @else
                                                    <span class="led" style="background: var(--mist-dim);"></span><span class="font-mono text-xs uppercase" style="color: var(--mist-dim);">Cancelled</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="px-5 py-14 text-center text-[color:var(--mist-dim)] text-sm">No bookings yet.</p>
                    @endif
                </div>

                {{-- Right: actions, registry, revenue --}}
                <div class="space-y-6">
                    <div class="console-panel p-5">
                        <span class="panel-title mb-4 block">Quick Actions</span>
                        <div class="space-y-2.5 mt-4">
                            <a href="{{ route('owner.boats.create') }}" class="console-btn is-primary">
                                <span class="console-btn-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </span>
                                <span class="flex-1 min-w-0">
                                    <span class="console-btn-title block">Add New Boat</span>
                                    <span class="console-btn-desc block">List a new boat for booking</span>
                                </span>
                            </a>
                            <a href="{{ route('owner.boats.index') }}" class="console-btn">
                                <span class="console-btn-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                                </span>
                                <span class="flex-1 min-w-0">
                                    <span class="console-btn-title block">Manage Boats</span>
                                    <span class="console-btn-desc block">View, edit or remove boats</span>
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="console-panel p-5">
                        <div class="flex items-center justify-between mb-1">
                            <span class="panel-title">My Boats</span>
                            <a href="{{ route('owner.boats.index') }}" class="font-mono text-[0.65rem] uppercase" style="color: var(--cyan);">View all</a>
                        </div>
                        <div class="mt-3">
                            @forelse($boats->take(5) as $boat)
                                <div class="registry-row">
                                    <span class="led" style="background: var(--cyan); box-shadow: 0 0 5px var(--cyan-glow);"></span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium truncate">{{ $boat->name }}</p>
                                        <span class="font-mono text-[0.65rem] text-[color:var(--mist-dim)]">{{ $boat->type }}</span>
                                    </div>
                                    <div class="capacity-bar" title="Capacity {{ $boat->capacity }}">
                                        @for($i = 0; $i < 5; $i++)
                                            <span class="capacity-seg {{ $i < min(5, ceil($boat->capacity / 4)) ? 'is-lit' : '' }}"></span>
                                        @endfor
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-[color:var(--mist-dim)] py-2">No boats added yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="lcd">
                        <span class="font-mono text-[0.65rem] uppercase tracking-widest text-[color:var(--mist-dim)]">Estimated Revenue</span>
                        <p class="lcd-value text-3xl mt-1" style="color: var(--cyan);">RM {{ number_format($confirmed * 150, 2) }}</p>
                        <span class="font-mono text-[0.65rem]" style="color: var(--green);">from {{ $confirmed }} confirmed booking{{ $confirmed === 1 ? '' : 's' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const el = document.getElementById('live-clock');
            if (el) el.textContent = new Date().toLocaleTimeString('en-US', { hour12: false });
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
</x-app-layout>
