<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --abyss: #070C13;
                --panel: #0D1620;
                --panel-2: #111C28;
                --edge: #223244;
                --cyan: #4FD8E0;
                --cyan-dim: #1F5A5E;
                --cyan-glow: rgba(79,216,224,0.35);
                --brass: #C9A16A;
                --brass-dim: #8A6E45;
                --foam: #D8ECEF;
                --mist: #9FB4C4;
                --mist-dim: #5C7286;
                --text: #E7F0F4;
            }

            /* Dark shell throughout — no light gray/white ever shows through,
               regardless of page height, overscroll, or whether a header slot is used. */
            html, body { background: var(--abyss); }
            body { font-family: 'Inter', 'Figtree', system-ui, sans-serif; color: var(--text); }

            /* ===== Navbar shell ===== */
            .hud-nav {
                background: rgba(13,22,32,0.94);
                backdrop-filter: blur(10px);
                position: sticky; top: 0; z-index: 40;
                border-bottom: 1px solid var(--edge);
            }

            /* Waterline: the navbar's edge is drawn as a wave, not a flat rule */
            .waterline {
                position: absolute; left: 0; right: 0; bottom: -7px; height: 8px;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='8' viewBox='0 0 60 8'%3E%3Cpath d='M0 4 Q 7.5 0 15 4 T 30 4 T 45 4 T 60 4' fill='none' stroke='%234FD8E0' stroke-width='1' opacity='0.55'/%3E%3C/svg%3E");
                background-repeat: repeat-x;
                background-size: 60px 8px;
                pointer-events: none;
            }
            @media (prefers-reduced-motion: no-preference) {
                .waterline { animation: drift 9s linear infinite; }
            }
            @keyframes drift { from { background-position-x: 0; } to { background-position-x: 60px; } }

            .hud-nav-wrap { position: relative; }

            /* ===== Binnacle compass logo mount ===== */
            .compass-mount { position: relative; width: 3rem; height: 3rem; flex-shrink: 0; }
            .compass-ring { position: absolute; inset: -7px; color: var(--brass); }
            @media (prefers-reduced-motion: no-preference) {
                .compass-ring { animation: compass-spin 100s linear infinite; }
            }
            @keyframes compass-spin { to { transform: rotate(360deg); } }

            .hud-logo-mark {
                position: absolute; inset: 0; border-radius: 50%; overflow: hidden;
                border: 1.5px solid var(--brass-dim);
                box-shadow: inset 0 0 0 2px var(--abyss), 0 0 0 1px rgba(201,161,106,0.25);
                background: var(--panel-2);
            }
            .hud-logo-mark img { width: 100%; height: 100%; object-fit: cover; }
            .hud-logo-mark::after {
                content: ""; position: absolute; inset: 0; border-radius: 50%;
                background: radial-gradient(circle at 32% 28%, rgba(255,255,255,0.22), transparent 55%);
                pointer-events: none;
            }

            .hud-brand-text { font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 1.05rem; color: var(--text); line-height: 1; letter-spacing: 0.01em; }
            .hud-brand-sub {
                font-family: 'JetBrains Mono', monospace; font-size: 0.58rem; letter-spacing: 0.2em;
                text-transform: uppercase; color: var(--brass);
            }

            /* ===== Nav tabs ===== */
            .hud-navlink {
                position: relative;
                font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; letter-spacing: 0.08em; text-transform: uppercase;
                color: var(--mist); padding: 0.6rem 1rem 0.7rem; border-radius: 0.35rem;
                display: flex; align-items: center; gap: 0.55rem; transition: color 0.15s ease, background 0.15s ease;
            }
            .hud-navlink::before {
                content: ""; width: 5px; height: 5px; border-radius: 50%;
                background: var(--brass-dim); flex-shrink: 0; transition: all 0.15s ease;
            }
            .hud-navlink:hover { color: var(--text); background: rgba(201,161,106,0.06); }
            .hud-navlink:hover::before { background: var(--brass); }
            .hud-navlink.is-active { color: var(--foam); }
            .hud-navlink.is-active::before { background: var(--cyan); box-shadow: 0 0 6px var(--cyan-glow); }
            .hud-navlink.is-active::after {
                content: ""; position: absolute; left: 0.7rem; right: 0.7rem; bottom: 3px; height: 2px;
                background: linear-gradient(90deg, var(--cyan), var(--foam));
                border-radius: 2px; box-shadow: 0 0 6px var(--cyan-glow);
            }

            /* ===== Vessel call-sign badge ===== */
            .callsign {
                font-family: 'JetBrains Mono', monospace; font-size: 0.62rem; letter-spacing: 0.1em;
                color: var(--brass); border: 1px solid var(--brass-dim); border-radius: 0.3rem;
                padding: 0.2rem 0.5rem; display: inline-flex; align-items: center; gap: 0.4rem;
            }
            .callsign .dot { width: 5px; height: 5px; border-radius: 50%; background: var(--cyan); box-shadow: 0 0 5px var(--cyan-glow); }
            @media (prefers-reduced-motion: no-preference) {
                .callsign .dot { animation: pulse-op 1.8s ease-in-out infinite; }
            }
            @keyframes pulse-op { 0%,100% { opacity: 1; } 50% { opacity: 0.35; } }

            .hud-clock { font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; color: var(--mist-dim); letter-spacing: 0.04em; }

            /* ===== Porthole avatar ===== */
            .porthole {
                width: 2.2rem; height: 2.2rem; border-radius: 50%;
                background: radial-gradient(circle at 32% 28%, rgba(255,255,255,0.15), rgba(79,216,224,0.05) 60%);
                border: 1.5px solid var(--brass-dim);
                box-shadow: inset 0 0 0 2px var(--abyss);
                display: flex; align-items: center; justify-content: center;
                font-family: 'JetBrains Mono', monospace; font-weight: 600; font-size: 0.72rem; color: var(--cyan);
            }

            .hud-dropdown {
                background: var(--panel); border: 1px solid var(--edge); border-radius: 0.6rem;
                box-shadow: 0 12px 32px rgba(0,0,0,0.5);
            }
            .hud-dropdown-item {
                font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; letter-spacing: 0.05em; text-transform: uppercase;
                color: var(--mist); padding: 0.65rem 1rem; display: flex; align-items: center; gap: 0.6rem;
                transition: all 0.15s ease;
            }
            .hud-dropdown-item:hover { color: var(--cyan); background: rgba(79,216,224,0.06); }

            .hud-mobile-btn {
                width: 2.3rem; height: 2.3rem; border-radius: 0.4rem; border: 1px solid var(--edge);
                display: flex; align-items: center; justify-content: center; color: var(--mist);
            }
            .hud-mobile-btn:focus-visible,
            .hud-navlink:focus-visible,
            .hud-dropdown-item:focus-visible {
                outline: 2px solid var(--cyan); outline-offset: 2px;
            }

            /* ===== Page header (only renders on pages that pass an x-slot header) =====
               Styled to sit flush with the dark theme instead of a white bar. */
            .hud-page-header {
                background: var(--panel);
                border-bottom: 1px solid var(--edge);
            }
        </style>
    </head>
    <body class="font-sans antialiased" x-data="{ mobileOpen: false, userOpen: false }">
        <div class="min-h-screen" style="background: var(--abyss);">

            {{-- ===== Navbar: ship's instrument rail ===== --}}
            <nav class="hud-nav">
                <div class="hud-nav-wrap">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16 items-center">

                            <div class="flex items-center gap-5">
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                                    <span class="compass-mount">
                                        <svg class="compass-ring" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="32" cy="32" r="30" stroke="currentColor" stroke-width="1" opacity="0.45"/>
                                            <path d="M32 2 L34.5 9 L29.5 9 Z" fill="currentColor" opacity="0.9"/>
                                            <line x1="32" y1="6" x2="32" y2="11" stroke="currentColor" stroke-width="1" opacity="0.6"/>
                                            <line x1="32" y1="53" x2="32" y2="58" stroke="currentColor" stroke-width="1" opacity="0.6"/>
                                            <line x1="6" y1="32" x2="11" y2="32" stroke="currentColor" stroke-width="1" opacity="0.6"/>
                                            <line x1="53" y1="32" x2="58" y2="32" stroke="currentColor" stroke-width="1" opacity="0.6"/>
                                            <line x1="12.7" y1="12.7" x2="16" y2="16" stroke="currentColor" stroke-width="0.75" opacity="0.4"/>
                                            <line x1="48" y1="16" x2="51.3" y2="12.7" stroke="currentColor" stroke-width="0.75" opacity="0.4"/>
                                            <line x1="12.7" y1="51.3" x2="16" y2="48" stroke="currentColor" stroke-width="0.75" opacity="0.4"/>
                                            <line x1="48" y1="48" x2="51.3" y2="51.3" stroke="currentColor" stroke-width="0.75" opacity="0.4"/>
                                        </svg>
                                        <span class="hud-logo-mark">
                                            <img src="{{ asset('Boat.jpg') }}" alt="Boatbuku">
                                        </span>
                                    </span>
                                    <span class="hidden sm:block">
                                        <span class="hud-brand-text block">Boatbuku</span>
                                        <span class="hud-brand-sub block">Fleet &amp; Charter Desk</span>
                                    </span>
                                </a>

                                <div class="hidden md:flex items-center gap-1 ml-3">
                                    <a href="{{ route('dashboard') }}" class="hud-navlink {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">Dashboard</a>
                                    <a href="{{ route('owner.boats.index') }}" class="hud-navlink {{ request()->routeIs('owner.boats.*') ? 'is-active' : '' }}">My Boats</a>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="callsign hidden lg:inline-flex">
                                    <span class="dot"></span>
                                    OWNER
                                </span>
                                <span class="hud-clock hidden lg:inline" id="nav-clock">{{ now()->format('H:i:s') }}</span>

                                <div class="relative" @click.outside="userOpen = false">
                                    <button @click="userOpen = !userOpen" class="flex items-center gap-2" aria-label="Account menu">
                                        <span class="porthole">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                                        <svg class="w-3.5 h-3.5 hidden sm:block text-[color:var(--mist-dim)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </button>

                                    <div x-show="userOpen" x-transition x-cloak class="hud-dropdown absolute right-0 mt-3 w-52 py-1.5 z-50">
                                        <div class="px-4 py-2.5 border-b" style="border-color: var(--edge);">
                                            <p class="text-sm font-medium text-[color:var(--text)] truncate">{{ auth()->user()->name }}</p>
                                            <p class="font-mono text-[0.65rem] text-[color:var(--mist-dim)] truncate">{{ auth()->user()->email }}</p>
                                        </div>
                                        <a href="{{ route('profile.edit') }}" class="hud-dropdown-item">Profile</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="hud-dropdown-item w-full text-left" style="color: #FF6B6B;">Sign Out</button>
                                        </form>
                                    </div>
                                </div>

                                <button @click="mobileOpen = !mobileOpen" class="hud-mobile-btn md:hidden" aria-label="Toggle menu">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" x-show="!mobileOpen"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" x-show="mobileOpen" x-cloak><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div x-show="mobileOpen" x-transition x-cloak class="md:hidden">
                        <div class="px-4 py-3 space-y-1 border-t" style="border-color: var(--edge);">
                            <a href="{{ route('dashboard') }}" class="hud-navlink {{ request()->routeIs('dashboard') ? 'is-active' : '' }} justify-start">Dashboard</a>
                            <a href="{{ route('owner.boats.index') }}" class="hud-navlink {{ request()->routeIs('owner.boats.*') ? 'is-active' : '' }} justify-start">My Boats</a>
                            <a href="{{ route('owner.boats.create') }}" class="hud-navlink {{ request()->routeIs('owner.boats.create') ? 'is-active' : '' }} justify-start">Add Boat</a>
                        </div>
                    </div>

                    <div class="waterline" aria-hidden="true"></div>
                </div>
            </nav>

            {{-- Page Heading — only renders if a page passes <x-slot name="header">, now styled to match the dark theme instead of a white bar --}}
            @isset($header)
                <header class="hud-page-header">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            function updateNavClock() {
                const el = document.getElementById('nav-clock');
                if (el) el.textContent = new Date().toLocaleTimeString('en-US', { hour12: false });
            }
            updateNavClock();
            setInterval(updateNavClock, 1000);
        </script>
    </body>
</html>
