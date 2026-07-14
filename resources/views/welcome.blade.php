<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boatbuku — Find &amp; Book Boats for Fishing</title>
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
            --yellow: #f59e0b;
            --red: #ef4444;
            --radius: 12px;
        }
        * { -webkit-font-smoothing: antialiased; }
        body { font-family: 'Inter', system-ui, sans-serif; background: var(--bg); color: var(--text); line-height: 1.5; }
        .container { max-width: 1120px; margin: 0 auto; padding: 0 24px; }

        /* Navbar */
        .nav { position: sticky; top: 0; z-index: 50; border-bottom: 1px solid var(--border); background: rgba(11, 15, 25, 0.9); backdrop-filter: blur(12px); }
        .nav-inner { max-width: 1120px; margin: 0 auto; padding: 0 24px; height: 64px; display: flex; align-items: center; justify-content: space-between; }
        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-logo-icon { width: 32px; height: 32px; border-radius: 8px; background: var(--accent); display: flex; align-items: center; justify-content: center; }
        .nav-logo-text { font-weight: 600; font-size: 16px; color: var(--text); }
        .nav-links { display: flex; gap: 16px; align-items: center; }
        .nav-link { font-size: 14px; color: var(--text); text-decoration: none; transition: color 0.15s; }
        .nav-link:hover { color: var(--accent); }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 20px; border-radius: var(--radius); font-size: 14px; font-weight: 500; border: none; cursor: pointer; transition: all 0.15s; text-decoration: none; }
        .btn-primary { background: var(--accent); color: #000; }
        .btn-primary:hover { background: var(--accent-hover); }
        .btn-secondary { background: transparent; color: var(--text-muted); border: 1px solid var(--border); }
        .btn-secondary:hover { border-color: var(--border-hover); color: var(--text); }

        /* Cards */
        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); transition: border-color 0.15s; }
        .card:hover { border-color: var(--border-hover); }

        /* Grid */
        .grid-3 { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px; }

        /* Hero */
        .hero { padding: 80px 0 64px; text-align: center; }
        .hero-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; padding: 6px 14px; border-radius: 999px; color: var(--accent); background: rgba(6, 182, 212, 0.08); border: 1px solid rgba(6, 182, 212, 0.15); margin-bottom: 24px; }
        .hero h1 { font-size: 44px; font-weight: 600; letter-spacing: -0.03em; line-height: 1.1; margin: 0 0 16px; }
        .hero p { font-size: 16px; color: var(--text-muted); max-width: 480px; margin: 0 auto 32px; line-height: 1.6; }
        .hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        /* Section */
        .section { padding: 64px 0; }
        .section-alt { background: var(--bg-elevated); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
        .section-title { font-size: 28px; font-weight: 600; letter-spacing: -0.02em; margin: 0 0 8px; text-align: center; }
        .section-subtitle { font-size: 14px; color: var(--text-muted); text-align: center; margin: 0 0 40px; }

        /* Steps */
        .steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; justify-content: center; }
        .step { text-align: center; padding: 24px; }
        .step-icon { width: 48px; height: 48px; border-radius: 12px; background: rgba(6, 182, 212, 0.08); border: 1px solid rgba(6, 182, 212, 0.15); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .step h3 { font-size: 16px; font-weight: 600; margin: 0 0 8px; }
        .step p { font-size: 13px; color: var(--text-muted); margin: 0; line-height: 1.5; }

        /* CTA */
        .cta-box { text-align: center; padding: 48px 32px; border-radius: 16px; background: var(--bg-elevated); border: 1px solid var(--border); }
        .cta-box h2 { font-size: 28px; font-weight: 600; letter-spacing: -0.02em; margin: 0 0 12px; }
        .cta-box p { font-size: 14px; color: var(--text-muted); max-width: 440px; margin: 0 auto 24px; line-height: 1.6; }

        /* Footer */
        .footer { border-top: 1px solid var(--border); padding: 24px 0; }
        .footer-inner { max-width: 1120px; margin: 0 auto; padding: 0 24px; display: flex; justify-content: space-between; align-items: center; }
        .footer-text { font-size: 13px; color: var(--text-muted); }

        /* Star */
        .star { color: #f59e0b; }
        .star-dim { color: #334155; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

        @media (max-width: 768px) {
            .hero h1 { font-size: 32px; }
            .grid-3 { grid-template-columns: 1fr; }
            .steps { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="nav">
        <div class="nav-inner">
            <a href="{{ route('welcome') }}" class="nav-logo">
                <div class="nav-logo-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #000;">
                        <path d="M2 20l1.5-3L7 12l3.5 5L12 20l1.5-3L17 12l3.5 5L22 20"/>
                        <path d="M12 3L2 12h3v8h6v-5h2v5h6v-8h3L12 3z"/>
                    </svg>
                </div>
                <span class="nav-logo-text">Boatbuku</span>
            </a>
            <div class="nav-links">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 13px;">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Log in</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="hero">
        <div class="container">
            <div class="hero-badge">
                <svg width="14" height="14" viewBox="0 0 20 20" fill="#f59e0b"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Trusted by fishing enthusiasts
            </div>
            <h1>Find the perfect<br>boat for your trip</h1>
            <p>Browse available boats, compare prices, and book instantly. From fishing charters to day cruises.</p>
            <div class="hero-actions">
                <a href="{{ auth()->check() ? route('dashboard') : route('register', ['role' => 'customer']) }}" class="btn btn-primary" style="min-width: 160px;">
                    {{ auth()->check() ? 'Browse Boats' : 'Book a Boat' }}
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="{{ auth()->check() ? route('owner.dashboard') : route('register', ['role' => 'owner']) }}" class="btn btn-secondary" style="min-width: 160px;">
                    List Your Boat
                </a>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="section section-alt">
        <div class="container">
            <h2 class="section-title">How it works</h2>
            <p class="section-subtitle">Book a boat in three simple steps</p>
            <div class="steps">
                <div class="step">
                    <div class="step-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="1.5"><path d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                    </div>
                    <h3>Search</h3>
                    <p>Browse boats by location, type, and capacity. Filter to find exactly what you need.</p>
                </div>
                <div class="step">
                    <div class="step-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="1.5"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3>Book</h3>
                    <p>Choose your date, select a time slot, and submit your booking request.</p>
                </div>
                <div class="step">
                    <div class="step-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="1.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3>Set Sail</h3>
                    <p>Get confirmed, meet your captain, and enjoy your fishing adventure.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Boats --}}
    <section id="boats" class="section">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; margin-bottom: 32px; flex-wrap: wrap;">
                <div>
                    <h2 class="section-title" style="text-align: left;">Available Boats</h2>
                    <p class="section-subtitle" style="text-align: left; margin: 4px 0 0;">Browse our fleet of verified vessels</p>
                </div>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;">View All</a>
                @endauth
            </div>

            @php
                $boats = \App\Models\Boat::withCount('reviews')->withAvg('reviews', 'rating')->where('status', 'active')->orderBy('reviews_avg_rating', 'desc')->limit(6)->get();
                $totalBoats = \App\Models\Boat::where('status', 'active')->count();
            @endphp

            @if($boats->count())
                <div class="grid-3">
                    @foreach($boats as $boat)
                        @php
                            $rating = round($boat->reviews_avg_rating ?? 0);
                            $reviewCount = $boat->reviews_count ?? 0;
                        @endphp
                        <div class="card">
                            <div style="height: 140px; display: flex; align-items: center; justify-content: center; background: var(--bg-elevated); border-bottom: 1px solid var(--border); position: relative;">
                                <span style="font-size: 40px; font-weight: 600; color: rgba(6, 182, 212, 0.1);">{{ strtoupper(substr($boat->name, 0, 1)) }}</span>
                                @if($boat->location)
                                    <span style="position: absolute; top: 10px; left: 10px; font-size: 11px; color: var(--text-muted); background: rgba(0,0,0,0.3); padding: 3px 8px; border-radius: 6px;">{{ $boat->location }}</span>
                                @endif
                            </div>
                            <div style="padding: 14px;">
                                <h3 style="font-size: 14px; font-weight: 600; margin: 0;">{{ $boat->name }}</h3>
                                <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">{{ $boat->type }}</p>

                                <div style="display: flex; align-items: center; gap: 3px; margin-top: 8px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg width="12" height="12" viewBox="0 0 20 20" fill="{{ $i <= $rating ? '#f59e0b' : '#334155' }}"><path d="M10 1.5l2.6 5.6 6.1.6-4.6 4.1 1.3 6-5.4-3.2-5.4 3.2 1.3-6-4.6-4.1 6.1-.6z"/></svg>
                                    @endfor
                                    <span style="font-size: 11px; color: var(--text-muted); margin-left: 4px;">
                                        {{ $rating > 0 ? number_format($boat->reviews_avg_rating, 1) : 'No reviews' }}{{ $reviewCount ? " ({$reviewCount})" : '' }}
                                    </span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border);">
                                    @if($boat->price_per_hour)
                                        <span style="font-size: 16px; font-weight: 600;">RM {{ number_format($boat->price_per_hour, 0) }}</span>
                                        <span style="font-size: 12px; color: var(--text-muted);">/hr</span>
                                    @elseif($boat->price_per_trip)
                                        <span style="font-size: 16px; font-weight: 600;">RM {{ number_format($boat->price_per_trip, 0) }}</span>
                                        <span style="font-size: 12px; color: var(--text-muted);">/trip</span>
                                    @else
                                        <span style="font-size: 12px; color: var(--text-muted);">Price on request</span>
                                    @endif
                                    <span style="font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        {{ $boat->capacity }} pax
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($totalBoats > 6)
                    <p style="text-align: center; font-size: 13px; color: var(--text-muted); margin-top: 24px;">And {{ $totalBoats - 6 }} more boats available</p>
                @endif
            @else
                <div class="card" style="text-align: center; padding: 48px 24px;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--text-muted); margin-bottom: 12px;">
                        <path d="M2 20l1.5-3L7 12l3.5 5L12 20l1.5-3L17 12l3.5 5L22 20"/>
                    </svg>
                    <p style="font-size: 15px; font-weight: 500; margin: 0 0 4px;">No boats available yet</p>
                    <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Check back soon or <a href="{{ route('register', ['role' => 'owner']) }}" style="color: var(--accent); text-decoration: none;">sign up</a> to get listed.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="section section-alt">
        <div class="container">
            <div class="cta-box">
                <h2>Own a boat?</h2>
                <p>List your vessel on Boatbuku and reach thousands of fishing enthusiasts. Manage bookings, set availability, and grow your business.</p>
                <a href="{{ route('register', ['role' => 'owner']) }}" class="btn btn-primary">
                    Register as Owner
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="footer">
        <div class="footer-inner">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div class="nav-logo-icon" style="width: 24px; height: 24px; border-radius: 6px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #000;">
                        <path d="M2 20l1.5-3L7 12l3.5 5L12 20l1.5-3L17 12l3.5 5L22 20"/>
                    </svg>
                </div>
                <span style="font-size: 14px; font-weight: 600;">Boatbuku</span>
            </div>
            <p class="footer-text">2025 Boatbuku. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
