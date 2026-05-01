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
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --cl-red: #E63946;
                --cl-red-hover: #d32f3d;
                --cl-red-deep: #b52d38;
                --cl-red-soft: #fef2f2;
                --cl-red-glow: rgba(230, 57, 70, 0.08);
                --cl-blue: #1D3557;
                --cl-blue-soft: #f0f4f8;
                --cl-blue-mid: rgba(29, 53, 87, 0.06);
                --cl-green: #2DC653;
                --cl-green-soft: #edfcf1;
                --cl-green-glow: rgba(45, 198, 83, 0.08);
                --cl-dark: #111827;
                --cl-body: #374151;
                --cl-muted: #6b7280;
                --cl-muted-light: #9ca3af;
                --cl-light: #f9fafb;
                --cl-border: #e5e7eb;
                --cl-border-light: #f3f4f6;
                --cl-white: #ffffff;
                --cl-nav-bg: rgba(255,255,255,0.85);
                --cl-nav-scrolled: rgba(255,255,255,0.95);
                --cl-nav-shadow: 0 1px 12px rgba(0,0,0,0.06);
                --cl-nav-border: rgba(0,0,0,0.04);
                --cl-card-border: var(--cl-border);
                --cl-card-bg: var(--cl-white);
                --shadow-xs: 0 1px 2px rgba(0,0,0,0.04);
                --shadow-sm: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03);
                --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.06), 0 2px 4px -2px rgba(0,0,0,0.04);
                --shadow-lg: 0 10px 25px -3px rgba(0,0,0,0.07), 0 4px 6px -4px rgba(0,0,0,0.04);
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
                --cl-blue-mid: rgba(29, 53, 87, 0.14);
                --cl-green-soft: rgba(45, 198, 83, 0.12);
                --cl-green-glow: rgba(45, 198, 83, 0.14);
                --cl-dark: #f1f5f9;
                --cl-body: #cbd5e1;
                --cl-muted: #94a3b8;
                --cl-muted-light: #64748b;
                --cl-light: #1e293b;
                --cl-border: #334155;
                --cl-border-light: #1e293b;
                --cl-white: #0f172a;
                --cl-nav-bg: rgba(15,23,42,0.82);
                --cl-nav-scrolled: rgba(15,23,42,0.95);
                --cl-nav-shadow: 0 1px 16px rgba(0,0,0,0.3);
                --cl-nav-border: rgba(255,255,255,0.06);
                --cl-card-border: #334155;
                --cl-card-bg: #1e293b;
                --shadow-xs: 0 1px 2px rgba(0,0,0,0.2);
                --shadow-sm: 0 1px 3px rgba(0,0,0,0.25), 0 1px 2px rgba(0,0,0,0.15);
                --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.3), 0 2px 4px -2px rgba(0,0,0,0.2);
                --shadow-lg: 0 10px 25px -3px rgba(0,0,0,0.35), 0 4px 6px -4px rgba(0,0,0,0.2);
                --shadow-xl: 0 20px 50px -12px rgba(0,0,0,0.5);
            }

            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            html { scroll-behavior: smooth; }

            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                background: var(--cl-white);
                color: var(--cl-body);
                line-height: 1.6;
                -webkit-font-smoothing: antialiased;
                overflow-x: hidden;
                transition: background-color 0.35s ease, color 0.35s ease;
            }

            h1, h2, h3, h4, h5, h6 {
                font-family: 'Playfair Display', Georgia, serif;
                color: var(--cl-dark);
                transition: color 0.35s ease;
            }

            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
            html.dark ::-webkit-scrollbar-thumb { background: #475569; }

            @keyframes shimmer {
                0% { background-position: -200% 0; }
                100% { background-position: 200% 0; }
            }

            .navbar-cl {
                background: var(--cl-nav-bg);
                backdrop-filter: blur(20px) saturate(180%);
                -webkit-backdrop-filter: blur(20px) saturate(180%);
                border-bottom: 1px solid var(--cl-nav-border);
                padding: 0.75rem 0;
                transition: all 0.35s ease;
                z-index: 1050;
            }
            .navbar-cl.scrolled {
                background: var(--cl-nav-scrolled);
                box-shadow: var(--cl-nav-shadow);
            }
            .navbar-cl .nav-link {
                font-weight: 500;
                color: var(--cl-body);
                padding: 0.5rem 0.85rem !important;
                font-size: 0.875rem;
                border-radius: var(--radius-sm);
                transition: all 0.2s ease;
            }
            .navbar-cl .nav-link:hover {
                color: var(--cl-red);
                background: var(--cl-red-glow);
            }
            .navbar-cl .nav-link.active { color: var(--cl-red); font-weight: 600; }

            .nav-brand {
                display: flex;
                align-items: center;
                gap: 0.6rem;
                text-decoration: none;
            }
            .nav-logo-icon {
                width: 40px; height: 40px;
                background: var(--cl-red);
                border-radius: var(--radius-sm);
                display: flex; align-items: center; justify-content: center;
                position: relative;
                overflow: hidden;
            }
            .nav-logo-icon::after {
                content: '';
                position: absolute;
                top: -50%; left: -50%;
                width: 200%; height: 200%;
                background: linear-gradient(45deg, transparent 40%, rgba(255,255,255,0.15) 50%, transparent 60%);
                animation: shimmer 3s ease-in-out infinite;
                background-size: 200% 100%;
            }
            .nav-logo-icon i { color: #fff; font-size: 1.1rem; position: relative; z-index: 1; }
            .nav-brand-name {
                font-family: 'Inter', sans-serif;
                font-weight: 800;
                font-size: 1.2rem;
                color: var(--cl-dark);
                letter-spacing: -0.03em;
                transition: color 0.35s ease;
            }
            .nav-brand-name b { color: var(--cl-red); font-weight: 800; }

            .nav-btn-cta {
                background: var(--cl-red);
                color: #fff;
                border: none;
                border-radius: var(--radius-full);
                padding: 0.55rem 1.35rem;
                font-weight: 600;
                font-size: 0.85rem;
                transition: all 0.25s ease;
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
            }
            .nav-btn-cta:hover {
                background: var(--cl-red-hover);
                color: #fff;
                transform: translateY(-1px);
                box-shadow: 0 4px 14px rgba(230,57,70,0.35);
            }
            .nav-btn-ghost {
                background: none;
                border: none;
                color: var(--cl-muted);
                font-weight: 500;
                font-size: 0.875rem;
                padding: 0.55rem 0.75rem;
                border-radius: var(--radius-sm);
                transition: all 0.2s ease;
                text-decoration: none;
            }
            .nav-btn-ghost:hover { color: var(--cl-dark); background: var(--cl-red-glow); }

            .navbar-toggler {
                border: 1px solid var(--cl-border);
                border-radius: var(--radius-sm);
                padding: 0.4rem 0.6rem;
            }
            .navbar-toggler:hover { border-color: var(--cl-red); }
            .navbar-toggler:focus { box-shadow: none; border-color: var(--cl-red); }

            .dark-toggle {
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
                flex-shrink: 0;
            }
            .dark-toggle:hover {
                border-color: var(--cl-red);
                color: var(--cl-red);
                background: var(--cl-red-glow);
                transform: rotate(15deg);
            }
            .dark-toggle .icon-sun { display: none; }
            .dark-toggle .icon-moon { display: block; }
            html.dark .dark-toggle .icon-sun { display: block; }
            html.dark .dark-toggle .icon-moon { display: none; }

            .page-header {
                background: var(--cl-card-bg);
                border-bottom: 1px solid var(--cl-border);
                padding: 1.75rem 0;
                transition: all 0.35s ease;
            }
            .page-header h2 {
                margin: 0;
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--cl-dark);
            }
            .header-sub {
                font-family: 'Inter', sans-serif;
                font-size: 0.88rem;
                color: var(--cl-muted);
                font-weight: 400;
                margin-top: 0.3rem;
            }

            .main-content { min-height: calc(100vh - 260px); }

            .btn-primary {
                --bs-btn-bg: var(--cl-red);
                --bs-btn-border-color: var(--cl-red);
                --bs-btn-hover-bg: var(--cl-red-hover);
                --bs-btn-hover-border-color: var(--cl-red-hover);
                --bs-btn-active-bg: var(--cl-red-deep);
                --bs-btn-active-border-color: var(--cl-red-deep);
                font-weight: 600;
                border-radius: var(--radius-full);
                padding: 0.6rem 1.6rem;
                transition: all 0.25s ease;
            }
            .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(230,57,70,0.3); }

            .btn-outline-primary {
                --bs-btn-color: var(--cl-red);
                --bs-btn-border-color: var(--cl-red);
                --bs-btn-hover-bg: var(--cl-red);
                --bs-btn-hover-border-color: var(--cl-red);
                --bs-btn-hover-color: #FFF;
                border-radius: var(--radius-full);
                font-weight: 600;
                padding: 0.6rem 1.6rem;
            }

            .btn-success {
                --bs-btn-bg: var(--cl-green);
                --bs-btn-border-color: var(--cl-green);
                --bs-btn-hover-bg: #26A847;
                --bs-btn-hover-border-color: #26A847;
                border-radius: var(--radius-full);
                font-weight: 600;
            }

            .btn-danger {
                --bs-btn-bg: var(--cl-red);
                --bs-btn-border-color: var(--cl-red);
                --bs-btn-hover-bg: var(--cl-red-hover);
                --bs-btn-hover-border-color: var(--cl-red-hover);
                border-radius: var(--radius-full);
                font-weight: 600;
            }

            .btn-secondary {
                border-radius: var(--radius-full);
                font-weight: 500;
                border-color: var(--cl-border);
                color: var(--cl-body);
                background: var(--cl-card-bg);
                transition: all 0.2s ease;
            }
            .btn-secondary:hover {
                background: var(--cl-red-glow);
                border-color: var(--cl-red);
                color: var(--cl-red);
            }

            .form-control, .form-select {
                border: 1.5px solid var(--cl-border);
                border-radius: var(--radius-sm);
                padding: 0.65rem 1rem;
                font-size: 0.9rem;
                font-family: 'Inter', sans-serif;
                color: var(--cl-dark);
                background: var(--cl-white);
                transition: all 0.25s ease;
            }
            .form-control:focus, .form-select:focus {
                border-color: var(--cl-red);
                box-shadow: 0 0 0 3px rgba(230,57,70,0.08);
                background: var(--cl-white);
                color: var(--cl-dark);
            }
            .form-control::placeholder { color: var(--cl-muted-light); }
            .form-label {
                font-weight: 600;
                font-size: 0.85rem;
                color: var(--cl-dark);
                margin-bottom: 0.4rem;
            }
            .form-text { font-size: 0.8rem; color: var(--cl-muted); }
            .input-group-text {
                background: var(--cl-light);
                border: 1.5px solid var(--cl-border);
                color: var(--cl-body);
            }

            .card {
                border: 1px solid var(--cl-card-border);
                border-radius: var(--radius-lg);
                box-shadow: var(--shadow-sm);
                background: var(--cl-card-bg);
                transition: all 0.35s ease, background-color 0.35s ease, border-color 0.35s ease;
            }
            .card:hover {
                box-shadow: var(--shadow-xl);
                border-color: transparent;
            }
            .card-header {
                background: var(--cl-card-bg);
                border-bottom: 1px solid var(--cl-border);
                padding: 1rem 1.25rem;
                font-weight: 600;
                color: var(--cl-dark);
                transition: all 0.35s ease;
            }
            .card-body { padding: 1.25rem; }
            .card-footer {
                background: var(--cl-light);
                border-top: 1px solid var(--cl-border);
                padding: 0.85rem 1.25rem;
                transition: all 0.35s ease;
            }

            .table { font-size: 0.9rem; color: var(--cl-body); }
            .table > :not(caption) > * > * > * { border-color: var(--cl-border); }
            .table > thead th {
                font-family: 'Inter', sans-serif;
                font-weight: 600;
                font-size: 0.78rem;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                color: var(--cl-muted);
                border-bottom-width: 1.5px;
                padding: 0.85rem 1rem;
                background: var(--cl-light);
            }
            .table tbody td {
                padding: 0.85rem 1rem;
                vertical-align: middle;
                border-bottom-color: var(--cl-border);
            }
            .table-hover > tbody > tr:hover > td,
            .table-hover > tbody > tr:hover > th {
                background: var(--cl-red-glow) !important;
                color: var(--cl-dark);
            }

            .badge {
                font-weight: 600;
                font-size: 0.7rem;
                letter-spacing: 0.02em;
                padding: 0.35em 0.75em;
                border-radius: var(--radius-full);
            }
            .bg-danger { background-color: var(--cl-red) !important; }
            .bg-success { background-color: var(--cl-green) !important; }
            .bg-warning { background-color: #FDE68A !important; color: #92400E !important; }
            html.dark .bg-info { background-color: rgba(29,53,87,0.5) !important; color: #93bbfd !important; }
            html.dark .bg-primary { background-color: rgba(29,53,87,0.5) !important; color: #93bbfd !important; }
            html.dark .bg-secondary { background-color: var(--cl-light) !important; color: var(--cl-body) !important; }

            .pagination .page-link {
                border-radius: var(--radius-sm);
                margin: 0 3px;
                border: 1px solid var(--cl-border);
                color: var(--cl-body);
                font-weight: 500;
                font-size: 0.88rem;
                padding: 0.45rem 0.85rem;
                background: var(--cl-card-bg);
            }
            .pagination .page-link:hover { background: var(--cl-light); color: var(--cl-dark); }
            .pagination .page-item.active .page-link {
                background: var(--cl-red);
                border-color: var(--cl-red);
                color: #FFF;
            }

            .alert { border-radius: var(--radius-md); border: none; font-size: 0.9rem; padding: 0.9rem 1.1rem; }
            .alert-success { background: var(--cl-green-soft); color: #1A8C38; }
            .alert-danger { background: var(--cl-red-soft); color: #C12A35; }
            .alert-warning { background: #FEF3C7 !important; color: #92400E !important; }
            .alert-info { background: var(--cl-blue-soft) !important; color: var(--cl-blue) !important; }

            .modal-content {
                border: none;
                border-radius: var(--radius-xl);
                box-shadow: 0 16px 48px rgba(0,0,0,0.15);
                background: var(--cl-card-bg);
            }
            .modal-header {
                background: var(--cl-card-bg);
                border-bottom: 1px solid var(--cl-border);
                padding: 1.25rem 1.5rem;
            }
            .modal-header .modal-title { color: var(--cl-dark); }
            .modal-header .btn-close { color: var(--cl-muted); opacity: 0.5; }
            .modal-footer {
                border-top: 1px solid var(--cl-border);
                padding: 1rem 1.5rem;
                background: var(--cl-card-bg);
            }
            .modal-body { padding: 1.5rem; }

            .text-cl-red { color: var(--cl-red) !important; }
            .text-cl-blue { color: var(--cl-blue) !important; }
            html.dark .text-cl-blue { color: #93bbfd !important; }
            .text-cl-green { color: var(--cl-green) !important; }
            .text-cl-muted { color: var(--cl-muted) !important; }

            .section-label {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.73rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--cl-red);
                margin-bottom: 0.5rem;
            }
            .section-label::before {
                content: '';
                display: inline-block;
                width: 20px; height: 2px;
                background: var(--cl-red);
                border-radius: 2px;
            }

            .app-footer {
                border-top: 1px solid var(--cl-border);
                margin-top: 3rem;
                padding: 1.5rem 0;
            }
            .app-footer p { margin: 0; font-size: 0.82rem; color: var(--cl-muted); }

            html.dark .bg-white { background-color: #1e293b !important; }
            html.dark .bg-light { background-color: #1e293b !important; }
            html.dark .bg-body { background-color: #0f172a !important; }
            html.dark .bg-transparent { background-color: transparent !important; }

            html.dark .table { --bs-table-color: #cbd5e1; color: #cbd5e1; }
            html.dark .table > :not(caption) > * > * > * { border-color: #334155; }
            html.dark .table > thead th { background: #1e293b; color: #94a3b8; }

            html.dark .list-group-item {
                background-color: #1e293b;
                border-color: #334155;
                color: #cbd5e1;
            }
            html.dark .list-group-item:hover { background-color: #334155; }
            html.dark .list-group-item.active {
                background-color: rgba(230,57,70,0.14);
                border-color: rgba(230,57,70,0.2);
                color: var(--cl-red);
            }

            html.dark .dropdown-menu {
                background-color: #1e293b;
                border: 1px solid #334155;
                box-shadow: 0 10px 25px rgba(0,0,0,0.35);
            }
            html.dark .dropdown-item { color: #cbd5e1; }
            html.dark .dropdown-item:hover { background: #334155; color: #f1f5f9; }

            html.dark .form-check-input { background-color: #1e293b; border-color: #334155; color: #cbd5e1; }
            html.dark .form-check-input:checked { background-color: var(--cl-red); border-color: var(--cl-red); }
            html.dark .form-check-label { color: #cbd5e1; }

            html.dark .text-muted { color: #94a3b8 !important; }
            html.dark .text-body { color: #cbd5e1 !important; }
            html.dark .text-dark { color: #f1f5f9 !important; }
            html.dark .text-secondary { color: #94a3b8 !important; }
            html.dark .text-gray-500,
            html.dark .text-gray-600 { color: #94a3b8 !important; }
            html.dark .text-gray-700,
            html.dark .text-gray-800 { color: #cbd5e1 !important; }
            html.dark .text-gray-900,
            html.dark .text-black { color: #f1f5f9 !important; }

            html.dark .shadow-sm { box-shadow: 0 1px 3px rgba(0,0,0,0.25) !important; }
            html.dark .shadow { box-shadow: 0 4px 6px rgba(0,0,0,0.3) !important; }
            html.dark .bg-gradient-to-br,
            html.dark .bg-gradient-to-bl { background: linear-gradient(135deg, #1e293b, #334155) !important; }

            @media (max-width: 991.98px) {
                .navbar-cl .nav-btn-cta { width: 100%; justify-content: center; }
            }
            @media (max-width: 767.98px) {
                .page-header { padding: 1.25rem 0; }
                .page-header h2 { font-size: 1.25rem; }
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen d-flex flex-column">
            @include('layouts.navigation')

            @isset($header)
                <header class="page-header">
                    <div class="container">{{ $header }}</div>
                </header>
            @endisset

            <main class="main-content py-4 flex-grow-1">
                <div class="container">{{ $slot }}</div>
            </main>

            <footer class="app-footer">
                <div class="container text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} <strong>Charity</strong><span class="text-cl-red"><strong>Link</strong></span> — Ensemble pour une Tunisie plus solidaire.</p>
                </div>
            </footer>
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

            function clToggleDropdown(e) {
                e.stopPropagation();
                var dd = document.getElementById('clDropdown');
                var btn = document.getElementById('clUserBtn');
                if (dd) {
                    var open = dd.classList.toggle('open');
                    btn.setAttribute('aria-expanded', open);
                }
            }

            function clToggleBurger() {
                var burger = document.getElementById('clBurger');
                var mobile = document.getElementById('clMobile');
                var dd = document.getElementById('clDropdown');
                if (!burger || !mobile) return;
                var open = burger.classList.toggle('open');
                mobile.classList.toggle('open', open);
                burger.setAttribute('aria-expanded', open);
                mobile.setAttribute('aria-hidden', !open);
                document.body.style.overflow = open ? 'hidden' : '';
                if (dd) dd.classList.remove('open');
            }

            document.addEventListener('click', function(e) {
                var dd = document.getElementById('clDropdown');
                if (dd && dd.classList.contains('open') && !e.target.closest('.cl-dropdown') && !e.target.closest('#clUserBtn')) {
                    dd.classList.remove('open');
                    var btn = document.getElementById('clUserBtn');
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                }
            });

            var mobileEl = document.getElementById('clMobile');
            if (mobileEl) {
                mobileEl.querySelectorAll('a, button[type="submit"]').forEach(function(el) {
                    el.addEventListener('click', function() {
                        var burger = document.getElementById('clBurger');
                        var mobile = document.getElementById('clMobile');
                        if (burger) burger.classList.remove('open');
                        if (mobile) mobile.classList.remove('open');
                        document.body.style.overflow = '';
                    });
                });
            }

            window.addEventListener('scroll', function() {
                var nav = document.getElementById('clNav');
                var progress = document.getElementById('clProgress');
                if (nav) nav.classList.toggle('scrolled', window.scrollY > 20);
                if (progress) {
                    var max = document.documentElement.scrollHeight - window.innerHeight;
                    progress.style.width = (max > 0 ? (window.scrollY / max) * 100 : 0) + '%';
                }
            }, { passive: true });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 991) {
                    var burger = document.getElementById('clBurger');
                    var mobile = document.getElementById('clMobile');
                    if (burger) burger.classList.remove('open');
                    if (mobile) mobile.classList.remove('open');
                    document.body.style.overflow = '';
                }
            });

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                if (!localStorage.getItem('cl-theme')) {
                    document.documentElement.classList.toggle('dark', e.matches);
                }
            });
        </script>
    </body>
</html>
