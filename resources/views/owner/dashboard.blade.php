<x-app-layout>
    {{-- Custom styles --}}
    <style>
        /* Hide Laravel logo */
        .flex-shrink-0 { display: none !important; }

        /* Smooth scroll & font */
        html { scroll-behavior: smooth; }
        body { font-family: 'Pirata One', 'Georgia', serif; }

        /* Background gradient with subtle animation */
        .bg-pirate {
            background: linear-gradient(135deg, #0b1a2e, #1a2f3f, #0d1f2d);
            background-size: 400% 400%;
            animation: gradientShift 20s ease infinite;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float 10s ease-in-out infinite alternate;
        }
        @keyframes float {
            0% { transform: translate(0, 0); }
            100% { transform: translate(20px, -30px); }
        }

        /* Gold shimmer text */
        .gold-text {
            background: linear-gradient(135deg, #d4a017, #f5e6c8, #b8860b);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 4s ease-in-out infinite;
        }
        @keyframes shimmer {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Cards */
        .pirate-card {
            background: rgba(10, 22, 40, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(184, 134, 11, 0.3);
            border-radius: 1.5rem;
            transition: all 0.3s ease;
        }
        .pirate-card:hover {
            border-color: rgba(212, 160, 23, 0.7);
            box-shadow: 0 0 25px rgba(184, 134, 11, 0.15);
            transform: translateY(-2px);
        }

        /* Glowing button */
        .btn-gold {
            background: linear-gradient(135deg, #b8860b, #d4a017);
            border: none;
            color: #0b1a2e;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-gold:hover {
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(184, 134, 11, 0.4);
        }

        /* Table row hover */
        .pirate-row:hover {
            background: rgba(13, 31, 45, 0.6);
        }

        /* Treasure chest interactive */
        .treasure-chest {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .treasure-chest:hover {
            transform: scale(1.05);
        }
        .treasure-chest:active {
            transform: scale(0.95);
        }
    </style>

    {{-- Header slot --}}
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-3">
                <span class="text-3xl">⚓</span>
                <h2 class="text-2xl font-bold gold-text tracking-wide">
                    Captain’s Quarters
                </h2>
            </div>
            <div class="flex items-center gap-4">
                <!-- Live clock -->
                <div class="bg-[#0a1628]/60 backdrop-blur-md border border-[#b8860b]/40 rounded-full px-5 py-2 flex items-center gap-3 shadow-lg shadow-[#b8860b]/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#d4a017]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-[#d4a017] font-mono text-lg font-bold" id="live-clock">{{ now()->format('H:i:s') }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- Main content --}}
    <div class="py-12 relative bg-pirate min-h-screen">
        {{-- Orbs --}}
        <div class="orb w-[40vw] h-[40vw] top-[-10%] left-[-10%] bg-[#1a3a5c]/40"></div>
        <div class="orb w-[50vw] h-[50vw] bottom-[-20%] right-[-10%] bg-[#b8860b]/20" style="animation-delay: -3s;"></div>
        <div class="orb w-[30vw] h-[30vw] top-[40%] left-[60%] bg-[#8b6914]/25" style="animation-delay: -6s;"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            {{-- Greeting with interactive treasure chest --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-[#f5e6c8] text-lg font-serif flex items-center gap-2">
                        <span>🏴‍☠️ Ahoy,</span>
                        <span class="font-bold text-[#d4a017]">{{ auth()->user()->name }}</span>
                        <span class="text-[#c9a87c] text-sm">– yer shipyard awaits!</span>
                    </p>
                </div>
                {{-- Treasure chest --}}
                <div x-data="{ open: false, tip: '' }" class="relative">
                    <div @click="open = !open; tip = tips[Math.floor(Math.random() * tips.length)]"
                         class="treasure-chest bg-[#0a1628]/60 backdrop-blur-md border border-[#b8860b]/40 rounded-full px-5 py-2 flex items-center gap-3 hover:border-[#d4a017] transition-all">
                        <span class="text-2xl">📦</span>
                        <span class="text-[#c9a87c] text-sm font-serif">Captain’s Tip</span>
                    </div>
                    <div x-show="open" x-transition.duration.300ms
                         class="absolute right-0 mt-2 w-64 bg-[#0a1628] border border-[#b8860b]/50 rounded-xl p-4 shadow-2xl z-50">
                        <p class="text-[#f5e6c8] text-sm font-serif italic" x-text="tip || 'A wise captain always checks the tides.'"></p>
                        <div class="mt-2 text-right">
                            <button @click="open = false" class="text-[#d4a017] text-xs hover:underline">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Metrics --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                @php
                    $totalBoats = $boats->count();
                    $totalBookings = $bookings->count();
                    $pending = $bookings->where('status', 'pending')->count();
                    $confirmed = $bookings->where('status', 'confirmed')->count();
                @endphp
                <div class="pirate-card p-6">
                    <div class="flex items-center justify-between">
                        <span class="text-[#c9a87c] text-sm font-serif">Total Fleet</span>
                        <svg class="h-6 w-6 text-[#d4a017]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-4xl font-bold gold-text mt-2">{{ $totalBoats }}</p>
                    <span class="text-[#c9a87c] text-xs">⛵ vessels</span>
                </div>
                <div class="pirate-card p-6">
                    <div class="flex items-center justify-between">
                        <span class="text-[#c9a87c] text-sm font-serif">Total Bookings</span>
                        <svg class="h-6 w-6 text-[#d4a017]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-4xl font-bold gold-text mt-2">{{ $totalBookings }}</p>
                    <span class="text-[#c9a87c] text-xs">📜 total</span>
                </div>
                <div class="pirate-card p-6">
                    <div class="flex items-center justify-between">
                        <span class="text-[#c9a87c] text-sm font-serif">Pending</span>
                        <svg class="h-6 w-6 text-[#d4a017]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-4xl font-bold gold-text mt-2">{{ $pending }}</p>
                    <span class="text-[#c9a87c] text-xs">⏳ awaiting</span>
                </div>
                <div class="pirate-card p-6">
                    <div class="flex items-center justify-between">
                        <span class="text-[#c9a87c] text-sm font-serif">Confirmed</span>
                        <svg class="h-6 w-6 text-[#d4a017]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-4xl font-bold gold-text mt-2">{{ $confirmed }}</p>
                    <span class="text-[#c9a87c] text-xs">⚓ locked in</span>
                </div>
            </div>

            {{-- Main two-column layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left (2/3) – fleet & bookings --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Fleet table --}}
                    <div class="pirate-card overflow-hidden">
                        <div class="p-4 border-b border-[#b8860b]/30 flex justify-between items-center bg-[#0d1f2d]/50">
                            <span class="text-[#c9a87c] font-serif text-sm">⚓ Ships under yer command</span>
                            <a href="{{ route('owner.boats.index') }}" class="btn-gold text-xs px-4 py-2 rounded-full font-bold uppercase tracking-wider">
                                Manage Fleet
                            </a>
                        </div>
                        @if($boats->count())
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-[#b8860b]/20">
                                    <thead>
                                        <tr class="bg-[#0d1f2d]/40">
                                            <th class="px-6 py-3 text-left text-xs font-serif uppercase tracking-wider text-[#c9a87c]">Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-serif uppercase tracking-wider text-[#c9a87c]">Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-serif uppercase tracking-wider text-[#c9a87c]">Capacity</th>
                                            <th class="px-6 py-3 text-left text-xs font-serif uppercase tracking-wider text-[#c9a87c]">Price</th>
                                            <th class="px-6 py-3 text-left text-xs font-serif uppercase tracking-wider text-[#c9a87c]">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#b8860b]/20">
                                        @foreach($boats->take(10) as $boat)
                                            <tr class="pirate-row transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap font-serif text-[#f5e6c8]">{{ $boat->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap font-serif text-[#c9a87c]">{{ $boat->type }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-3 py-1 rounded-full text-xs font-serif bg-[#0d1f2d]/80 text-[#d4a017] border border-[#b8860b]/30">{{ $boat->capacity }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap font-serif text-[#d4a017]">
                                                    @if($boat->price_per_hour)
                                                        RM {{ number_format($boat->price_per_hour, 2) }}/hr
                                                    @elseif($boat->price_per_trip)
                                                        RM {{ number_format($boat->price_per_trip, 2) }}/trip
                                                    @else
                                                        <span class="text-[#c9a87c]/50">N/A</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-900/30 text-emerald-300 border border-emerald-700/30">
                                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                        Active
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="px-6 py-8 text-center text-[#c9a87c]/60 font-serif">No ships yet, Captain. <a href="{{ route('owner.boats.create') }}" class="text-[#d4a017] hover:underline">Add yer first vessel</a></p>
                        @endif
                    </div>

                    {{-- Recent bookings --}}
                    <div class="pirate-card overflow-hidden">
                        <div class="p-4 border-b border-[#b8860b]/30 bg-[#0d1f2d]/50">
                            <span class="text-[#c9a87c] font-serif text-sm">📜 Recent Bookings</span>
                        </div>
                        @if($bookings->count())
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-[#b8860b]/20">
                                    <thead>
                                        <tr class="bg-[#0d1f2d]/40">
                                            <th class="px-6 py-3 text-left text-xs font-serif uppercase tracking-wider text-[#c9a87c]">Passenger</th>
                                            <th class="px-6 py-3 text-left text-xs font-serif uppercase tracking-wider text-[#c9a87c]">Boat</th>
                                            <th class="px-6 py-3 text-left text-xs font-serif uppercase tracking-wider text-[#c9a87c]">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-serif uppercase tracking-wider text-[#c9a87c]">Pax</th>
                                            <th class="px-6 py-3 text-left text-xs font-serif uppercase tracking-wider text-[#c9a87c]">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#b8860b]/20">
                                        @foreach($bookings->take(10) as $booking)
                                            <tr class="pirate-row transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap font-serif text-[#f5e6c8]">{{ $booking->customer_name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap font-serif text-[#c9a87c]">{{ $booking->boat->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap font-mono text-sm text-[#d4a017]">{{ $booking->date }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap font-serif text-[#c9a87c]">{{ $booking->pax }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($booking->status === 'pending')
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-900/30 text-yellow-300 border border-yellow-700/30">
                                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Pending
                                                        </span>
                                                    @elseif($booking->status === 'confirmed')
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-900/30 text-emerald-300 border border-emerald-700/30">
                                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Confirmed
                                                        </span>
                                                    @elseif($booking->status === 'rejected')
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-900/30 text-red-300 border border-red-700/30">
                                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Rejected
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-700/30 text-slate-300 border border-slate-600/30">Cancelled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="px-6 py-8 text-center text-[#c9a87c]/60 font-serif">No passengers yet. Hoist the sails!</p>
                        @endif
                    </div>
                </div>

                {{-- Right (1/3) – quick actions, log, sea conditions --}}
                <div class="space-y-6">
                    {{-- Quick actions --}}
                    <div class="pirate-card p-6">
                        <h3 class="text-lg font-bold text-[#f5e6c8] flex items-center gap-2 mb-4">
                            <svg class="h-5 w-5 text-[#d4a017]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Captain’s Orders
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('owner.boats.index') }}" class="flex items-center justify-center w-full px-4 py-3 bg-[#0d1f2d]/60 hover:bg-[#0d1f2d]/80 rounded-lg border border-[#b8860b]/30 text-[#f5e6c8] transition-all">
                                <svg class="h-5 w-5 mr-2 text-[#d4a017]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                ⚓ Manage Fleet
                            </a>
                            <a href="{{ route('owner.boats.create') }}" class="flex items-center justify-center w-full px-4 py-3 bg-[#0d1f2d]/60 hover:bg-[#0d1f2d]/80 rounded-lg border border-[#b8860b]/30 text-[#f5e6c8] transition-all">
                                <svg class="h-5 w-5 mr-2 text-[#d4a017]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                🏴‍☠️ Add New Ship
                            </a>
                        </div>
                    </div>

                    {{-- Ship's log --}}
                    <div class="pirate-card p-6">
                        <h3 class="text-lg font-bold text-[#f5e6c8] flex items-center gap-2 mb-4">
                            <svg class="h-5 w-5 text-[#d4a017]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Ship’s Log
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between border-b border-[#b8860b]/20 pb-2">
                                <span class="text-[#c9a87c]">Total Vessels</span>
                                <span class="text-[#d4a017] font-bold">{{ $totalBoats }}</span>
                            </div>
                            <div class="flex justify-between border-b border-[#b8860b]/20 pb-2">
                                <span class="text-[#c9a87c]">Total Passengers</span>
                                <span class="text-[#d4a017] font-bold">{{ $bookings->sum('pax') }}</span>
                            </div>
                            <div class="flex justify-between border-b border-[#b8860b]/20 pb-2">
                                <span class="text-[#c9a87c]">Revenue (est.)</span>
                                <span class="text-[#d4a017] font-bold">RM {{ number_format($confirmed * 150, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#c9a87c]">Crew</span>
                                <span class="text-emerald-300 flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    All hands on deck
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Sea conditions --}}
                    <div class="pirate-card p-6">
                        <h3 class="text-lg font-bold text-[#f5e6c8] flex items-center gap-2 mb-4">
                            <svg class="h-5 w-5 text-[#d4a017]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                            Sea Conditions
                        </h3>
                        <div class="space-y-2 text-[#f5e6c8]">
                            <div class="flex justify-between"><span class="text-[#c9a87c]">Weather</span><span>⛅ Fair</span></div>
                            <div class="flex justify-between"><span class="text-[#c9a87c]">Tide</span><span>🌊 High</span></div>
                            <div class="flex justify-between"><span class="text-[#c9a87c]">Wind</span><span>🌬️ 12 knots NE</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alpine.js for treasure chest --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('treasure', () => ({
                open: false,
                tip: '',
                tips: [
                    'A calm sea never made a skilled sailor.',
                    'The best captain is the one who knows when to reef.',
                    'Treasure is found where the map ends.',
                    'Smooth seas do not make skillful sailors.',
                    'The anchor holds the ship, the captain holds the crew.',
                    'A ship is safe in harbor, but that\'s not what ships are for.',
                    'The wind and the waves are always on the side of the ablest navigators.'
                ]
            }));
        });

        // Live clock
        function updateClock() {
            const el = document.getElementById('live-clock');
            if (el) el.textContent = new Date().toLocaleTimeString('en-US', { hour12: false });
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
</x-app-layout>
