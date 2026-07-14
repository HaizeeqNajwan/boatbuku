<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Boatbuku') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --bg: #0b0f19;
            --bg-elevated: #111827;
            --bg-card: #151b2b;
            --border: #1e293b;
            --border-hover: #334155;
            --text: #f1f5f9;
            --text-muted: #64748b;
            --accent: #06b6d4;
            --accent-hover: #22d3ee;
            --green: #10b981;
            --green-bg: rgba(16, 185, 129, 0.1);
            --yellow: #f59e0b;
            --yellow-bg: rgba(245, 158, 11, 0.1);
            --red: #ef4444;
            --red-bg: rgba(239, 68, 68, 0.1);
            --radius: 12px;
        }

        * { -webkit-font-smoothing: antialiased; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
        }

        /* Layout */
        .page-container { max-width: 1120px; margin: 0 auto; padding: 0 24px; }

        /* Navbar */
        .nav {
            position: sticky; top: 0; z-index: 50;
            border-bottom: 1px solid var(--border);
            background: rgba(11, 15, 25, 0.9);
            backdrop-filter: blur(12px);
        }
        .nav-inner { max-width: 1120px; margin: 0 auto; padding: 0 24px; height: 64px; display: flex; align-items: center; justify-content: space-between; }
        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-logo-icon {
            width: 32px; height: 32px; border-radius: 8px;
            background: var(--accent);
            display: flex; align-items: center; justify-content: center;
        }
        .nav-logo-text { font-weight: 600; font-size: 16px; color: var(--text); letter-spacing: -0.02em; }
        .nav-links { display: flex; gap: 4px; align-items: center; }
        .nav-link {
            padding: 8px 14px; border-radius: 8px; font-size: 14px; font-weight: 500;
            color: var(--text-muted); text-decoration: none; transition: all 0.15s;
        }
        .nav-link:hover { color: var(--text); background: rgba(255,255,255,0.04); }
        .nav-link.active { color: var(--accent); background: rgba(6, 182, 212, 0.08); }

        /* User menu */
        .user-menu { position: relative; }
        .user-btn {
            display: flex; align-items: center; gap: 10px; padding: 6px 12px 6px 6px;
            border-radius: 999px; border: none; background: transparent; cursor: pointer;
            transition: background 0.15s;
        }
        .user-btn:hover { background: rgba(255,255,255,0.04); }
        .user-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--accent); color: #000; font-weight: 600; font-size: 13px;
            display: flex; align-items: center; justify-content: center;
        }
        .user-name { font-size: 14px; font-weight: 500; color: var(--text); }
        .user-dropdown {
            position: absolute; right: 0; top: 100%; margin-top: 8px;
            width: 220px; border-radius: var(--radius);
            border: 1px solid var(--border); background: var(--bg-elevated);
            overflow: hidden; z-index: 100;
        }
        .user-dropdown-header { padding: 16px; border-bottom: 1px solid var(--border); }
        .user-dropdown-name { font-size: 14px; font-weight: 600; }
        .user-dropdown-email { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
        .user-dropdown-role { font-size: 11px; color: var(--accent); margin-top: 4px; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 500; }
        .user-dropdown a, .user-dropdown form button {
            display: block; width: 100%; text-align: left; padding: 10px 16px;
            font-size: 14px; border: none; background: none; cursor: pointer;
            color: var(--text-muted); transition: all 0.15s;
        }
        .user-dropdown a:hover, .user-dropdown form button:hover { background: rgba(255,255,255,0.04); color: var(--text); }
        .user-dropdown form button { color: var(--red); }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px 20px; border-radius: var(--radius); font-size: 14px; font-weight: 500;
            border: none; cursor: pointer; transition: all 0.15s; text-decoration: none;
        }
        .btn-primary { background: var(--accent); color: #000; }
        .btn-primary:hover { background: var(--accent-hover); }
        .btn-secondary { background: transparent; color: var(--text-muted); border: 1px solid var(--border); }
        .btn-secondary:hover { border-color: var(--border-hover); color: var(--text); background: rgba(255,255,255,0.02); }
        .btn-sm { padding: 6px 12px; font-size: 13px; }
        .btn-xs { padding: 4px 10px; font-size: 12px; border-radius: 8px; }

        /* Cards */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            transition: border-color 0.15s;
        }
        .card:hover { border-color: var(--border-hover); }

        /* Inputs */
        .input {
            width: 100%; padding: 10px 14px; border-radius: var(--radius);
            border: 1px solid var(--border); background: var(--bg-elevated);
            color: var(--text); font-size: 14px; font-family: inherit;
            transition: all 0.15s; outline: none;
        }
        .input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1); }
        .input::placeholder { color: var(--text-muted); }
        .input-sm { padding: 8px 12px; font-size: 13px; }

        /* Labels */
        .label { font-size: 13px; font-weight: 500; color: var(--text-muted); margin-bottom: 6px; display: block; }

        /* Status badges */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 500;
        }
        .badge-green { background: var(--green-bg); color: var(--green); }
        .badge-yellow { background: var(--yellow-bg); color: var(--yellow); }
        .badge-red { background: var(--red-bg); color: var(--red); }
        .badge-gray { background: rgba(255,255,255,0.04); color: var(--text-muted); }

        /* Stats */
        .stat {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 20px;
        }
        .stat-value { font-size: 28px; font-weight: 600; letter-spacing: -0.02em; line-height: 1; }
        .stat-label { font-size: 12px; color: var(--text-muted); margin-top: 6px; text-transform: uppercase; letter-spacing: 0.05em; }

        /* Tables */
        .table { width: 100%; border-collapse: collapse; }
        .table th { text-align: left; padding: 12px 16px; font-size: 12px; font-weight: 500; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid var(--border); }
        .table td { padding: 14px 16px; font-size: 14px; border-bottom: 1px solid var(--border); }
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover td { background: rgba(255,255,255,0.01); }

        /* Typography */
        .heading-xl { font-size: 40px; font-weight: 600; letter-spacing: -0.03em; line-height: 1.1; }
        .heading-lg { font-size: 28px; font-weight: 600; letter-spacing: -0.02em; line-height: 1.2; }
        .heading-md { font-size: 20px; font-weight: 600; letter-spacing: -0.01em; }
        .heading-sm { font-size: 16px; font-weight: 600; }

        /* Section */
        .section { padding: 40px 0; }

        /* Grid */
        .grid-3 { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px; }
        .grid-4 { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; }

        /* Error / Session */
        .error-text { color: var(--red); font-size: 12px; margin-top: 4px; display: block; }
        .session-success { background: var(--green-bg); color: var(--green); border: 1px solid rgba(16, 185, 129, 0.2); padding: 10px 14px; border-radius: var(--radius); font-size: 13px; }
        .session-error { background: var(--red-bg); color: var(--red); border: 1px solid rgba(239, 68, 68, 0.2); padding: 10px 14px; border-radius: var(--radius); font-size: 13px; }

        /* Mobile menu */
        .mobile-menu { display: none; }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .mobile-menu { display: block; }
            .grid-3 { grid-template-columns: 1fr; }
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

        /* Page header */
        .page-header { padding: 32px 0 24px; border-bottom: 1px solid var(--border); }
        .page-header-inner { max-width: 1120px; margin: 0 auto; padding: 0 24px; }
        .page-header h2 { font-size: 20px; font-weight: 600; margin: 0; }
        .page-header p { font-size: 14px; color: var(--text-muted); margin-top: 4px; }
        .page-header-actions { display: flex; gap: 8px; align-items: flex-start; }
        .page-header-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap; }

        /* Footer */
        .footer { border-top: 1px solid var(--border); padding: 24px 0; margin-top: auto; }
        .footer-inner { max-width: 1120px; margin: 0 auto; padding: 0 24px; display: flex; justify-content: space-between; align-items: center; }
        .footer-text { font-size: 13px; color: var(--text-muted); }
    </style>
</head>
<body class="min-h-screen flex flex-col" x-data="{ userOpen: false }">
    {{-- Navbar --}}
    <nav class="nav">
        <div class="nav-inner">
            <div style="display: flex; align-items: center; gap: 32px;">
                <a href="{{ route('dashboard') }}" class="nav-logo">
                    <div class="nav-logo-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #000;">
                            <path d="M2 20l1.5-3L7 12l3.5 5L12 20l1.5-3L17 12l3.5 5L22 20"/>
                            <path d="M12 3L2 12h3v8h6v-5h2v5h6v-8h3L12 3z"/>
                        </svg>
                    </div>
                    <span class="nav-logo-text">Boatbuku</span>
                </a>
                <div class="nav-links">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.boats.index') }}" class="nav-link {{ request()->routeIs('owner.boats.*') ? 'active' : '' }}">Fleet</a>
                        <a href="{{ route('owner.bookings') }}" class="nav-link {{ request()->routeIs('owner.bookings') || request()->routeIs('owner.dashboard') ? 'active' : '' }}">Bookings</a>
                    @endif
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <div class="user-menu">
                    <button @click="userOpen = !userOpen" class="user-btn">
                        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="user-dropdown" x-show="userOpen" x-cloak @click.outside="userOpen = false" @keydown.escape="userOpen = false">
                        <div class="user-dropdown-header">
                            <div class="user-dropdown-name">{{ auth()->user()->name }}</div>
                            <div class="user-dropdown-email">{{ auth()->user()->email }}</div>
                            <div class="user-dropdown-role">{{ auth()->user()->isOwner() ? 'Owner' : 'Customer' }}</div>
                        </div>
                        <a href="{{ route('profile.edit') }}">Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Sign Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Page Header --}}
    @isset($header)
        <div class="page-header">
            <div class="page-header-inner">
                {{ $header }}
            </div>
        </div>
    @endisset

    {{-- Content --}}
    <main class="flex-1">
        <div class="page-container" style="padding-top: 32px; padding-bottom: 32px;">
            {{ $slot }}
        </div>
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <div class="footer-inner">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div class="nav-logo-icon" style="width: 24px; height: 24px; border-radius: 6px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #000;">
                        <path d="M2 20l1.5-3L7 12l3.5 5L12 20l1.5-3L17 12l3.5 5L22 20"/>
                    </svg>
                </div>
                <span class="footer-text" style="font-weight: 600; color: var(--text);">Boatbuku</span>
            </div>
            <p class="footer-text">2025 Boatbuku. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
