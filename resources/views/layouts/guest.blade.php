<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>
            (function(){
                var t=localStorage.getItem('cl-theme');
                if(!t) t=window.matchMedia('(prefers-color-scheme:dark)').matches?'dark':'light';
                if(t==='dark') document.documentElement.classList.add('dark');
            })();
        </script>

        <title>{{ config('app.name', 'CharityLink') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --cl-red: #E63946;
                --cl-red-hover: #d32f3d;
                --cl-red-soft: #fef2f2;
                --cl-red-glow: rgba(230, 57, 70, 0.08);
                --cl-blue: #1D3557;
                --cl-blue-soft: #f0f4f8;
                --cl-green: #2DC653;
                --cl-green-soft: #edfcf1;
                --cl-dark: #111827;
                --cl-body: #374151;
                --cl-muted: #6b7280;
                --cl-muted-light: #9ca3af;
                --cl-light: #f9fafb;
                --cl-border: #e5e7eb;
                --cl-white: #ffffff;
                --cl-card-bg: var(--cl-white);
                --cl-card-border: var(--cl-border);
                --shadow-sm: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03);
                --shadow-lg: 0 10px 25px -3px rgba(0,0,0,0.07);
                --shadow-xl: 0 20px 50px -12px rgba(0,0,0,0.12);
                --radius-sm: 8px;
                --radius-md: 12px;
                --radius-lg: 16px;
                --radius-xl: 24px;
                --radius-full: 9999px;
            }

            html.dark {
                --cl-red-soft: rgba(230, 57, 70, 0.12);
                --cl-red-glow: rgba(230, 57, 70, 0.14);
                --cl-blue-soft: rgba(29, 53, 87, 0.2);
                --cl-green-soft: rgba(45, 198, 83, 0.12);
                --cl-dark: #f1f5f9;
                --cl-body: #cbd5e1;
                --cl-muted: #94a3b8;
                --cl-muted-light: #64748b;
                --cl-light: #1e293b;
                --cl-border: #334155;
                --cl-white: #0f172a;
                --cl-card-bg: #1e293b;
                --cl-card-border: #334155;
                --shadow-sm: 0 1px 3px rgba(0,0,0,0.25), 0 1px 2px rgba(0,0,0,0.15);
                --shadow-lg: 0 10px 25px -3px rgba(0,0,0,0.35);
                --shadow-xl: 0 20px 50px -12px rgba(0,0,0,0.5);
            }

            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                background: var(--cl-white);
                color: var(--cl-body);
                line-height: 1.6;
                -webkit-font-smoothing: antialiased;
                overflow-x: hidden;
                transition: background-color 0.35s ease, color 0.35s ease;
            }

            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
            html.dark ::-webkit-scrollbar-thumb { background: #475569; }

            @keyframes shimmer {
                0% { background-position: -200% 0; }
                100% { background-position: 200% 0; }
            }
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-8px); }
            }
            @keyframes fadeUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            /* ─── Guest Layout ─── */
            .guest-wrapper {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2rem 1rem;
                position: relative;
                overflow: hidden;
            }

            /* Background decorations */
            .guest-wrapper::before {
                content: '';
                position: absolute;
                top: -20%; right: -10%;
                width: 500px; height: 500px;
                background: radial-gradient(circle, rgba(230,57,70,0.06) 0%, transparent 60%);
                border-radius: 50%;
                pointer-events: none;
            }
            .guest-wrapper::after {
                content: '';
                position: absolute;
                bottom: -15%; left: -10%;
                width: 400px; height: 400px;
                background: radial-gradient(circle, rgba(29,53,87,0.05) 0%, transparent 60%);
                border-radius: 50%;
                pointer-events: none;
            }
            html.dark .guest-wrapper::before { opacity: 0.3; }
            html.dark .guest-wrapper::after { opacity: 0.3; }

            .guest-grid {
                position: absolute;
                inset: 0;
                background-image:
                    linear-gradient(rgba(0,0,0,0.015) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(0,0,0,0.015) 1px, transparent 1px);
                background-size: 60px 60px;
                pointer-events: none;
            }
            html.dark .guest-grid {
                background-image:
                    linear-gradient(rgba(255,255,255,0.012) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.012) 1px, transparent 1px);
            }

            /* ─── Logo ─── */
            .guest-logo {
                display: flex;
                align-items: center;
                gap: 0.65rem;
                text-decoration: none;
                position: relative;
                z-index: 2;
                animation: fadeUp 0.6s cubic-bezier(0.22,1,0.36,1) both;
                margin-bottom: 2rem;
            }
            .guest-logo-icon {
                width: 48px; height: 48px;
                background: var(--cl-red);
                border-radius: var(--radius-md);
                display: flex; align-items: center; justify-content: center;
                position: relative;
                overflow: hidden;
                box-shadow: 0 4px 14px rgba(230,57,70,0.3);
            }
            .guest-logo-icon::after {
                content: '';
                position: absolute;
                top: -50%; left: -50%;
                width: 200%; height: 200%;
                background: linear-gradient(45deg, transparent 40%, rgba(255,255,255,0.15) 50%, transparent 60%);
                animation: shimmer 3s ease-in-out infinite;
                background-size: 200% 100%;
            }
            .guest-logo-icon i { color: #fff; font-size: 1.3rem; position: relative; z-index: 1; }
            .guest-logo-text {
                font-family: 'Inter', sans-serif;
                font-weight: 800;
                font-size: 1.4rem;
                color: var(--cl-dark);
                letter-spacing: -0.03em;
                transition: color 0.35s ease;
            }
            .guest-logo-text span { color: var(--cl-red); }

            /* ─── Card ─── */
            .guest-card {
                width: 100%;
                max-width: 440px;
                background: var(--cl-card-bg);
                border: 1px solid var(--cl-card-border);
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-xl);
                padding: 2.5rem 2rem;
                position: relative;
                z-index: 2;
                transition: background-color 0.35s ease, border-color 0.35s ease;
                animation: fadeUp 0.6s 0.1s cubic-bezier(0.22,1,0.36,1) both;
            }
            .guest-card::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 3px;
                background: linear-gradient(90deg, var(--cl-red), #f87171, var(--cl-red));
                border-radius: var(--radius-xl) var(--radius-xl) 0 0;
            }

            /* ─── Dark Toggle ─── */
            .guest-dark-toggle {
                position: fixed;
                top: 1.25rem; right: 1.25rem;
                width: 40px; height: 40px;
                border-radius: var(--radius-sm);
                border: 1px solid var(--cl-border);
                background: var(--cl-card-bg);
                color: var(--cl-body);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.05rem;
                cursor: pointer;
                transition: all 0.25s ease;
                z-index: 50;
            }
            .guest-dark-toggle:hover {
                border-color: var(--cl-red);
                color: var(--cl-red);
                background: var(--cl-red-glow);
                transform: rotate(15deg);
            }
            .guest-dark-toggle .icon-sun { display: none; }
            .guest-dark-toggle .icon-moon { display: block; }
            html.dark .guest-dark-toggle .icon-sun { display: block; }
            html.dark .guest-dark-toggle .icon-moon { display: none; }

            /* ─── Back to home ─── */
            .guest-back {
                position: fixed;
                top: 1.25rem; left: 1.25rem;
                display: flex;
                align-items: center;
                gap: 0.4rem;
                color: var(--cl-muted);
                text-decoration: none;
                font-size: 0.85rem;
                font-weight: 500;
                padding: 0.45rem 0.85rem;
                border-radius: var(--radius-sm);
                border: 1px solid var(--cl-border);
                background: var(--cl-card-bg);
                transition: all 0.2s ease;
                z-index: 50;
            }
            .guest-back:hover {
                color: var(--cl-red);
                border-color: rgba(230,57,70,0.2);
                background: var(--cl-red-glow);
            }

            /* ─── Card headings ─── */
            .guest-card h1,
            .guest-card h2 {
                font-family: 'Playfair Display', Georgia, serif;
                font-weight: 700;
                color: var(--cl-dark);
                font-size: 1.5rem;
                margin-bottom: 0.35rem;
                transition: color 0.35s ease;
            }
            .guest-card .guest-subtitle {
                font-size: 0.9rem;
                color: var(--cl-muted);
                margin-bottom: 1.75rem;
                transition: color 0.35s ease;
            }

            /* ─── Form overrides for guest card ─── */
            .guest-card .form-control,
            .guest-card .form-select {
                border: 1.5px solid var(--cl-border);
                border-radius: var(--radius-sm);
                padding: 0.7rem 1rem;
                font-size: 0.9rem;
                font-family: 'Inter', sans-serif;
                color: var(--cl-dark);
                background: var(--cl-white);
                transition: all 0.25s ease;
            }
            .guest-card .form-control:focus,
            .guest-card .form-select:focus {
                border-color: var(--cl-red);
                box-shadow: 0 0 0 3px rgba(230,57,70,0.08);
                background: var(--cl-white);
                color: var(--cl-dark);
            }
            .guest-card .form-control::placeholder { color: var(--cl-muted-light); }
            .guest-card .form-label {
                font-weight: 600;
                font-size: 0.85rem;
                color: var(--cl-dark);
                margin-bottom: 0.4rem;
                transition: color 0.35s ease;
            }

            /* ─── Buttons ─── */
            .guest-card .btn-primary {
                --bs-btn-bg: var(--cl-red);
                --bs-btn-border-color: var(--cl-red);
                --bs-btn-hover-bg: var(--cl-red-hover);
                --bs-btn-hover-border-color: var(--cl-red-hover);
                font-weight: 600;
                border-radius: var(--radius-full);
                padding: 0.7rem 1.6rem;
                font-size: 0.92rem;
                width: 100%;
                transition: all 0.25s ease;
            }
            .guest-card .btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 20px rgba(230,57,70,0.3);
            }

            .guest-card .btn-link {
                font-weight: 500;
                font-size: 0.88rem;
                color: var(--cl-red);
                text-decoration: none;
                padding: 0.4rem 0;
                transition: all 0.2s ease;
            }
            .guest-card .btn-link:hover {
                color: var(--cl-red-hover);
                text-decoration: underline;
            }

            /* ─── Divider ─── */
            .guest-divider {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin: 1.5rem 0;
                color: var(--cl-muted);
                font-size: 0.78rem;
                font-weight: 500;
            }
            .guest-divider::before,
            .guest-divider::after {
                content: '';
                flex: 1;
                height: 1px;
                background: var(--cl-border);
            }

            /* ─── Links inside card ─── */
            .guest-card a {
                color: var(--cl-red);
                text-decoration: none;
                font-weight: 500;
                transition: color 0.2s ease;
            }
            .guest-card a:hover {
                color: var(--cl-red-hover);
                text-decoration: underline;
            }

            /* ─── Footer text ─── */
            .guest-footer {
                position: relative;
                z-index: 2;
                margin-top: 2rem;
                text-align: center;
                animation: fadeUp 0.6s 0.2s cubic-bezier(0.22,1,0.36,1) both;
            }
            .guest-footer p {
                font-size: 0.82rem;
                color: var(--cl-muted);
                margin: 0;
                transition: color 0.35s ease;
            }
            .guest-footer a {
                color: var(--cl-red);
                text-decoration: none;
                font-weight: 600;
            }
            .guest-footer a:hover { text-decoration: underline; }

            /* ─── Social buttons (register page) ─── */
            .guest-card .social-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                width: 100%;
                padding: 0.65rem 1rem;
                border: 1.5px solid var(--cl-border);
                border-radius: var(--radius-sm);
                background: var(--cl-card-bg);
                color: var(--cl-body);
                font-size: 0.88rem;
                font-weight: 500;
                font-family: 'Inter', sans-serif;
                cursor: pointer;
                transition: all 0.2s ease;
                text-decoration: none;
            }
            .guest-card .social-btn:hover {
                border-color: var(--cl-muted-light);
                background: var(--cl-light);
                color: var(--cl-dark);
            }

            /* ─── Responsive ─── */
            @media (max-width: 575.98px) {
                .guest-card { padding: 2rem 1.5rem; }
                .guest-card h1,
                .guest-card h2 { font-size: 1.3rem; }
            }
        </style>
    </head>
    <body>
        <button class="guest-dark-toggle" onclick="clToggleDark()" aria-label="Mode sombre">
            <i class="bi bi-moon-stars-fill icon-moon"></i>
            <i class="bi bi-sun-fill icon-sun"></i>
        </button>

        <a href="/" class="guest-back">
            <i class="bi bi-arrow-left"></i>
            Accueil
        </a>

        <div class="guest-wrapper">
            <div class="guest-grid"></div>

            <a href="/" class="guest-logo">
                <div class="guest-logo-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <span class="guest-logo-text">Charity<span>Link</span></span>
            </a>

            <div class="guest-card">
                {{ $slot }}
            </div>

            <div class="guest-footer">
                <p>&copy; {{ date('Y') }} <a href="/">CharityLink</a> — Ensemble pour une Tunisie plus solidaire.</p>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            (function(){
                var t = localStorage.getItem('cl-theme');
                if (!t) t = window.matchMedia('(prefers-color-scheme:dark)').matches ? 'dark' : 'light';
                document.documentElement.classList.toggle('dark', t === 'dark');
            })();

            function clToggleDark() {
                var isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('cl-theme', isDark ? 'dark' : 'light');
            }

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                if (!localStorage.getItem('cl-theme')) {
                    document.documentElement.classList.toggle('dark', e.matches);
                }
            });
        </script>
    </body>
</html>
