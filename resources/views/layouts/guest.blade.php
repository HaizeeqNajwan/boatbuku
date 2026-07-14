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
            --red: #ef4444;
            --radius: 12px;
        }
        * { -webkit-font-smoothing: antialiased; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .guest-container {
            width: 100%;
            max-width: 400px;
            padding: 32px 24px;
        }

        .guest-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
            justify-content: center;
        }
        .guest-logo-icon {
            width: 36px; height: 36px; border-radius: 9px;
            background: var(--accent);
            display: flex; align-items: center; justify-content: center;
        }
        .guest-logo-text { font-weight: 600; font-size: 18px; letter-spacing: -0.02em; }

        .guest-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 32px;
        }
        .guest-title {
            font-size: 18px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 4px;
        }
        .guest-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 24px;
        }

        .input {
            width: 100%; padding: 10px 14px; border-radius: var(--radius);
            border: 1px solid var(--border); background: var(--bg-elevated);
            color: var(--text); font-size: 14px; font-family: inherit;
            transition: all 0.15s; outline: none;
        }
        .input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1); }
        .input::placeholder { color: var(--text-muted); }

        .label { font-size: 13px; font-weight: 500; color: var(--text-muted); margin-bottom: 6px; display: block; }

        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px 20px; border-radius: var(--radius); font-size: 14px; font-weight: 500;
            border: none; cursor: pointer; transition: all 0.15s; text-decoration: none;
        }
        .btn-primary { background: var(--accent); color: #000; width: 100%; }
        .btn-primary:hover { background: var(--accent-hover); }
        .btn-secondary { background: transparent; color: var(--text-muted); border: 1px solid var(--border); }
        .btn-secondary:hover { border-color: var(--border-hover); color: var(--text); }

        .link { color: var(--accent); text-decoration: none; font-size: 14px; }
        .link:hover { text-decoration: underline; }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .session-status {
            padding: 10px 14px; border-radius: var(--radius);
            font-size: 13px; margin-bottom: 16px;
        }
        .session-success { background: rgba(16, 185, 129, 0.1); color: var(--green); border: 1px solid rgba(16, 185, 129, 0.2); }
        .session-error { background: rgba(239, 68, 68, 0.1); color: var(--red); border: 1px solid rgba(239, 68, 68, 0.2); }

        .error-text { color: var(--red); font-size: 12px; margin-top: 4px; display: block; }
        .error-list { list-style: none; padding: 0; margin: 0 0 16px; }
        .error-list li { padding: 8px 12px; border-radius: 8px; background: rgba(239, 68, 68, 0.1); color: var(--red); font-size: 13px; margin-bottom: 6px; border: 1px solid rgba(239, 68, 68, 0.2); }

        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 20px 0; color: var(--text-muted); font-size: 12px;
        }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
    </style>
</head>
<body>
    <div class="guest-container">
        <div class="guest-logo">
            <div class="guest-logo-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #000;">
                    <path d="M2 20l1.5-3L7 12l3.5 5L12 20l1.5-3L17 12l3.5 5L22 20"/>
                    <path d="M12 3L2 12h3v8h6v-5h2v5h6v-8h3L12 3z"/>
                </svg>
            </div>
            <span class="guest-logo-text">Boatbuku</span>
        </div>

        <div class="guest-card">
            {{ $slot }}
        </div>

        <div class="auth-footer">
            &copy; {{ date('Y') }} Boatbuku. All rights reserved.
        </div>
    </div>
</body>
</html>
