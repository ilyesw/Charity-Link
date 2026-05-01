{{--resources\views\welcome.blade.php  --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CharityLink — Solidarité Numérique Tunisienne</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* ══════════════ LIGHT MODE (default) ══════════════ */
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
            --cl-hero-pattern: rgba(0,0,0,0.015);
            --cl-card-border: var(--cl-border);
            --cl-card-bg: var(--cl-white);
            --cl-input-bg: var(--cl-white);
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

        /* ══════════════ DARK MODE ══════════════ */
        html.dark {
            --cl-red-soft: rgba(230, 57, 70, 0.12);
            --cl-red-glow: rgba(230, 57, 70, 0.14);
            --cl-blue-soft: rgba(29, 53, 87, 0.25);
            --cl-blue-mid: rgba(29, 53, 87, 0.18);
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
            --cl-hero-pattern: rgba(255,255,255,0.012);
            --cl-card-border: var(--cl-border);
            --cl-card-bg: #1e293b;
            --cl-input-bg: #1e293b;
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
            -moz-osx-font-smoothing: grayscale;
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
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
        html.dark ::-webkit-scrollbar-thumb { background: #475569; }
        html.dark ::-webkit-scrollbar-thumb:hover { background: #64748b; }
        img { max-width: 100%; }

        /* ══════════════ ANIMATIONS ══════════════ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.9); opacity: 1; }
            100% { transform: scale(1.6); opacity: 0; }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes count-up {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .anim-fade-up { animation: fadeUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .anim-fade-up-d1 { animation: fadeUp 0.7s 0.1s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .anim-fade-up-d2 { animation: fadeUp 0.7s 0.2s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .anim-fade-up-d3 { animation: fadeUp 0.7s 0.3s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .anim-fade-up-d4 { animation: fadeUp 0.7s 0.4s cubic-bezier(0.22, 1, 0.36, 1) both; }

        /* ══════════════ DARK MODE TOGGLE ══════════════ */
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

        /* ══════════════ NAVBAR ══════════════ */
        .navbar-main {
            background: var(--cl-nav-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--cl-nav-border);
            padding: 0.75rem 0;
            transition: all 0.35s ease;
            z-index: 1050;
        }
        .navbar-main.scrolled {
            background: var(--cl-nav-scrolled);
            box-shadow: var(--cl-nav-shadow);
        }
        .navbar-main .nav-link {
            font-weight: 500;
            color: var(--cl-body);
            padding: 0.5rem 0.85rem !important;
            font-size: 0.875rem;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
        }
        .navbar-main .nav-link:hover {
            color: var(--cl-red);
            background: var(--cl-red-glow);
        }
        .navbar-main .nav-link .nav-icon-ai {
            font-size: 0.95rem;
            margin-right: 0.15rem;
            transition: transform 0.3s ease;
        }
        .navbar-main .nav-link:hover .nav-icon-ai {
            transform: rotate(15deg) scale(1.1);
        }

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
        .nav-brand-name span { color: var(--cl-red); }

        .nav-btn-donate {
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
        .nav-btn-donate:hover {
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
            transition: all 0.2s ease;
        }
        .navbar-toggler:hover { border-color: var(--cl-red); }
        .navbar-toggler:focus { box-shadow: none; border-color: var(--cl-red); }

        /* ══════════════ HERO ══════════════ */
        .hero {
            background: var(--cl-white);
            position: relative;
            overflow: visible;
            transition: background-color 0.35s ease;
        }
        .hero-bg-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.4;
            background-image:
                radial-gradient(circle at 15% 20%, rgba(230,57,70,0.06) 0%, transparent 50%),
                radial-gradient(circle at 85% 80%, rgba(29,53,87,0.05) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(45,198,83,0.03) 0%, transparent 40%);
            pointer-events: none;
        }
        html.dark .hero-bg-pattern { opacity: 0.25; }
        .hero-grid-pattern {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(var(--cl-hero-pattern) 1px, transparent 1px),
                linear-gradient(90deg, var(--cl-hero-pattern) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        .hero-content { position: relative; z-index: 2; }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--cl-red-soft);
            border: 1px solid rgba(230,57,70,0.15);
            border-radius: var(--radius-full);
            padding: 0.4rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--cl-red);
            transition: all 0.35s ease;
        }
        .hero-tag .pulse-dot {
            width: 6px; height: 6px;
            background: var(--cl-green);
            border-radius: 50%;
            position: relative;
        }
        .hero-tag .pulse-dot::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            border: 1.5px solid var(--cl-green);
            animation: pulse-ring 2s ease-out infinite;
        }

        .hero-title {
            font-size: clamp(2.4rem, 5.5vw, 3.8rem);
            font-weight: 900;
            line-height: 1.05;
            letter-spacing: -0.03em;
            color: var(--cl-dark);
            margin: 1.5rem 0;
        }
        .hero-title .accent {
            position: relative;
            color: var(--cl-red);
            display: inline-block;
        }
        .hero-title .accent::after {
            content: '';
            position: absolute;
            bottom: 2px; left: -4px; right: -4px;
            height: 8px;
            background: var(--cl-red-glow);
            border-radius: 4px;
            z-index: -1;
        }

        .hero-desc {
            font-size: 1.1rem;
            color: var(--cl-muted);
            line-height: 1.75;
            max-width: 500px;
            transition: color 0.35s ease;
        }

        .hero-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 2rem; }
        .btn-hero-primary {
            background: var(--cl-red);
            color: #fff;
            border: none;
            border-radius: var(--radius-full);
            padding: 0.85rem 2rem;
            font-weight: 700;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            position: relative;
            overflow: hidden;
        }
        .btn-hero-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .btn-hero-primary:hover {
            background: var(--cl-red-hover);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(230,57,70,0.35);
        }
        .btn-hero-primary:hover::before { opacity: 1; }

        .btn-hero-secondary {
            background: var(--cl-card-bg);
            color: var(--cl-dark);
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-full);
            padding: 0.8rem 1.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
        }
        .btn-hero-secondary:hover {
            border-color: var(--cl-red);
            color: var(--cl-red);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Hero Stats */
        .hero-stats {
            display: flex;
            gap: 0;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid var(--cl-border);
            transition: border-color 0.35s ease;
        }
        .hero-stat {
            flex: 1;
            padding-right: 1.5rem;
            position: relative;
        }
        .hero-stat:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0; top: 4px; bottom: 4px;
            width: 1px;
            background: var(--cl-border);
            transition: background 0.35s ease;
        }
        .hero-stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--cl-dark);
            line-height: 1.1;
            animation: count-up 0.6s ease both;
            transition: color 0.35s ease;
        }
        .hero-stat-label {
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--cl-muted);
            margin-top: 0.2rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: color 0.35s ease;
        }

        /* Hero Cards */
        .hero-cards-col { position: relative; z-index: 2; }

        .hero-card {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-lg);
            padding: 1.25rem;
            margin-bottom: 0.875rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.35s cubic-bezier(0.22, 1, 0.36, 1), background-color 0.35s ease, border-color 0.35s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        .hero-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--cl-red), var(--cl-red-hover));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .hero-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: var(--shadow-xl);
            border-color: transparent;
        }
        .hero-card:hover::before { transform: scaleX(1); }
        .hero-card:last-child { margin-bottom: 0; }

        .hero-card-badge {
            display: inline-block;
            background: var(--cl-red-soft);
            color: var(--cl-red);
            font-size: 0.68rem;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: var(--radius-full);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.6rem;
            transition: all 0.35s ease;
        }
        .hero-card-title {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 0.92rem;
            color: var(--cl-dark);
            margin-bottom: 0.25rem;
            line-height: 1.35;
            transition: color 0.35s ease;
        }
        .hero-card-meta {
            font-size: 0.78rem;
            color: var(--cl-muted);
            margin-bottom: 0.75rem;
            transition: color 0.35s ease;
        }
        .hero-card-meta i { color: var(--cl-green); margin-right: 0.2rem; }

        .progress-bar-cl {
            height: 5px;
            background: var(--cl-light);
            border-radius: var(--radius-full);
            overflow: hidden;
            transition: background 0.35s ease;
        }
        .progress-bar-cl .bar {
            height: 100%;
            background: linear-gradient(90deg, var(--cl-red), #f87171);
            border-radius: var(--radius-full);
            transition: width 1.2s cubic-bezier(0.22, 1, 0.36, 1);
            position: relative;
        }
        .progress-bar-cl .bar::after {
            content: '';
            position: absolute;
            right: 0; top: 0; bottom: 0;
            width: 20px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4));
            border-radius: 0 var(--radius-full) var(--radius-full) 0;
        }

        .hero-card-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
        }
        .hero-card-amount {
            font-weight: 700;
            font-size: 0.88rem;
            color: var(--cl-dark);
            transition: color 0.35s ease;
        }
        .hero-card-percent {
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--cl-red);
            background: var(--cl-red-soft);
            padding: 0.15rem 0.5rem;
            border-radius: var(--radius-full);
            transition: all 0.35s ease;
        }

        .hero-empty-state {
            background: var(--cl-light);
            border: 2px dashed var(--cl-border);
            border-radius: var(--radius-lg);
            padding: 3rem 2rem;
            text-align: center;
            transition: all 0.35s ease;
        }
        .hero-empty-state .icon-wrap {
            width: 64px; height: 64px;
            background: var(--cl-red-soft);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
        }
        .hero-empty-state .icon-wrap i { font-size: 1.5rem; color: var(--cl-red); }
        .hero-empty-state p { color: var(--cl-muted); font-size: 0.92rem; margin: 0; }

        /* Floating badges */
        .hero-float-badge {
            position: absolute;
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-md);
            padding: 0.6rem 1rem;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--cl-dark);
            z-index: 5;
            white-space: nowrap;
            transition: all 0.35s ease;
        }
        .hero-float-badge .fb-icon {
            width: 28px; height: 28px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        .fb-icon-green { background: var(--cl-green-soft); }
        .fb-icon-blue { background: var(--cl-blue-soft); }
        html.dark .fb-icon-blue i,
        html.dark .cc-badge { color: #93bbfd !important; }
        .hero-float-badge.badge-ai {
            top: -16px; right: -8px;
            animation: float 5s ease-in-out infinite;
            animation-delay: 0.5s;
        }
        .hero-float-badge.badge-trust {
            bottom: -16px; right: -8px;
            animation: float 5s ease-in-out infinite;
            animation-delay: 1.2s;
        }

        /* ══════════════ TRUST STRIP ══════════════ */
        .trust-strip {
            background: var(--cl-light);
            border-top: 1px solid var(--cl-border);
            border-bottom: 1px solid var(--cl-border);
            padding: 1.25rem 0;
            transition: all 0.35s ease;
        }
        .trust-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--cl-muted);
            transition: color 0.35s ease;
        }
        .trust-item i { font-size: 1rem; color: var(--cl-green); }

        /* ══════════════ SECTION COMMONS ══════════════ */
        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--cl-red);
            margin-bottom: 0.75rem;
        }
        .section-eyebrow i { font-size: 0.7rem; }
        .section-heading {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 700;
            line-height: 1.15;
            letter-spacing: -0.02em;
            margin-bottom: 0.6rem;
        }
        .section-desc {
            font-size: 1rem;
            color: var(--cl-muted);
            line-height: 1.7;
            max-width: 520px;
            transition: color 0.35s ease;
        }

        /* ══════════════ HOW IT WORKS ══════════════ */
        .how-section {
            background: var(--cl-white);
            position: relative;
            transition: background-color 0.35s ease;
        }
        .how-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: var(--cl-border);
            transition: background 0.35s ease;
        }
        .step-card {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-xl);
            padding: 2rem 1.75rem;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1), background-color 0.35s ease, border-color 0.35s ease;
            position: relative;
        }
        .step-card:hover {
            border-color: transparent;
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }
        .step-card-icon {
            width: 56px; height: 56px;
            border-radius: var(--radius-lg);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease, background 0.35s ease;
        }
        .step-card:hover .step-card-icon { transform: scale(1.1) rotate(-3deg); }
        .step-icon-red { background: var(--cl-red-soft); }
        .step-icon-green { background: var(--cl-green-soft); }
        .step-icon-blue { background: var(--cl-blue-soft); }
        .step-num {
            font-family: 'Playfair Display', serif;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--cl-muted);
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-bottom: 0.5rem;
            transition: color 0.35s ease;
        }
        .step-card h3 { font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; }
        .step-card p { font-size: 0.9rem; color: var(--cl-muted); line-height: 1.7; margin: 0; transition: color 0.35s ease; }

        /* ══════════════ CAMPAIGNS ══════════════ */
        .campaigns-section {
            background: var(--cl-light);
            transition: background-color 0.35s ease;
        }
        .campaign-card {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-xl);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1), background-color 0.35s ease, border-color 0.35s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .campaign-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-xl);
            border-color: transparent;
        }
        .campaign-card-inner {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .campaign-card-inner .cc-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: var(--cl-blue-soft);
            color: var(--cl-blue);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.3rem 0.65rem;
            border-radius: var(--radius-full);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            align-self: flex-start;
            margin-bottom: 0.85rem;
            transition: all 0.35s ease;
        }
        .campaign-card-inner h5 {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1.02rem;
            line-height: 1.4;
            color: var(--cl-dark);
            margin-bottom: 0.3rem;
            transition: color 0.35s ease;
        }
        .campaign-card-inner .cc-org {
            font-size: 0.82rem;
            color: var(--cl-muted);
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            transition: color 0.35s ease;
        }
        .campaign-card-inner .cc-org i { font-size: 0.7rem; color: var(--cl-green); }
        .cc-footer {
            margin-top: auto;
            padding-top: 1.25rem;
            border-top: 1px solid var(--cl-border);
            transition: border-color 0.35s ease;
        }
        .cc-progress { margin-bottom: 0.6rem; }
        .cc-progress .track { height: 6px; background: var(--cl-light); border-radius: var(--radius-full); overflow: hidden; transition: background 0.35s ease; }
        .cc-progress .bar { height: 6px; background: linear-gradient(90deg, var(--cl-red), #f87171); border-radius: var(--radius-full); position: relative; }
        .cc-progress .bar::after { content: ''; position: absolute; right: 0; top: 0; bottom: 0; width: 16px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5)); border-radius: 0 var(--radius-full) var(--radius-full) 0; }
        .cc-amounts { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .cc-raised { font-weight: 700; font-size: 1rem; color: var(--cl-dark); transition: color 0.35s ease; }
        .cc-goal { font-size: 0.8rem; color: var(--cl-muted); transition: color 0.35s ease; }
        .cc-goal strong { color: var(--cl-body); transition: color 0.35s ease; }
        .btn-donate-card {
            background: var(--cl-red); color: #fff; border: none; border-radius: var(--radius-full);
            padding: 0.7rem 0; font-weight: 700; font-size: 0.9rem; width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 0.4rem;
            transition: all 0.25s ease;
        }
        .btn-donate-card:hover { background: var(--cl-red-hover); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 16px rgba(230,57,70,0.3); }
        .campaigns-empty-state { text-align: center; padding: 4rem 2rem; }
        .campaigns-empty-state .empty-icon { width: 72px; height: 72px; background: var(--cl-light); border: 2px dashed var(--cl-border); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; transition: all 0.35s ease; }
        .campaigns-empty-state .empty-icon i { font-size: 1.75rem; color: var(--cl-border); }
        .campaigns-empty-state p { color: var(--cl-muted); font-size: 0.95rem; margin: 0; }
        .btn-see-all {
            background: var(--cl-card-bg); color: var(--cl-dark); border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-full); padding: 0.6rem 1.5rem; font-weight: 600; font-size: 0.875rem;
            display: inline-flex; align-items: center; gap: 0.4rem; text-decoration: none;
            transition: all 0.25s ease;
        }
        .btn-see-all:hover { border-color: var(--cl-red); color: var(--cl-red); transform: translateY(-1px); box-shadow: var(--shadow-md); }

        /* ══════════════ CHATBOT CTA ══════════════ */
        .chatbot-section { background: var(--cl-white); transition: background-color 0.35s ease; }
        .chatbot-cta-card {
            background: var(--cl-blue);
            border-radius: var(--radius-xl);
            position: relative;
            overflow: hidden;
        }
        .chatbot-cta-card::before { content: ''; position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(230,57,70,0.12) 0%, transparent 60%); border-radius: 50%; pointer-events: none; }
        .chatbot-cta-card::after { content: ''; position: absolute; bottom: -60px; left: 30%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(45,198,83,0.08) 0%, transparent 60%); border-radius: 50%; pointer-events: none; }
        .chatbot-cta-card > * { position: relative; z-index: 1; }
        .chatbot-cta-card h2 { color: #fff; font-size: clamp(1.5rem, 3.5vw, 2.2rem); font-weight: 700; line-height: 1.2; margin-bottom: 0.75rem; }
        .chatbot-cta-card p { color: rgba(255,255,255,0.55); font-size: 1rem; line-height: 1.7; margin: 0; }
        .btn-chatbot {
            background: #fff; color: var(--cl-blue); border: none; border-radius: var(--radius-full);
            padding: 0.85rem 2rem; font-weight: 700; font-size: 0.95rem;
            display: inline-flex; align-items: center; gap: 0.6rem;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .btn-chatbot:hover { transform: translateY(-3px); box-shadow: 0 10px 35px rgba(0,0,0,0.25); color: var(--cl-blue); }
        .btn-chatbot .robot-icon { font-size: 1.2rem; animation: float 3s ease-in-out infinite; }

        /* ══════════════ ACTORS ══════════════ */
        .actors-section { background: var(--cl-light); transition: background-color 0.35s ease; }
        .actor-card {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-lg);
            padding: 1.75rem 1.25rem;
            text-align: center;
            transition: all 0.35s cubic-bezier(0.22, 1, 0.36, 1), background-color 0.35s ease, border-color 0.35s ease;
            height: 100%;
        }
        .actor-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); border-color: var(--cl-red); }
        .actor-card-icon {
            width: 52px; height: 52px;
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem;
            margin: 0 auto 1rem;
            transition: transform 0.3s ease, background 0.35s ease;
        }
        .actor-card:hover .actor-card-icon { transform: scale(1.1); }
        .actor-icon-1 { background: var(--cl-red-soft); }
        .actor-icon-2 { background: var(--cl-blue-soft); }
        .actor-icon-3 { background: var(--cl-blue-soft); }
        .actor-icon-4 { background: var(--cl-green-soft); }
        .actor-icon-5 { background: var(--cl-red-soft); }
        .actor-card .actor-name { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.9rem; color: var(--cl-dark); margin-bottom: 0.35rem; transition: color 0.35s ease; }
        .actor-card .actor-desc { font-size: 0.8rem; color: var(--cl-muted); line-height: 1.6; margin: 0; transition: color 0.35s ease; }

        /* ══════════════ FOOTER ══════════════ */
        .footer-main { background: #0c1222; position: relative; }
        html.dark .footer-main { background: #060a14; }
        .footer-main::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent); }
        .footer-main a { color: rgba(255,255,255,0.4); text-decoration: none; font-size: 0.875rem; transition: color 0.2s ease; }
        .footer-main a:hover { color: rgba(255,255,255,0.9); }
        .footer-brand-name { font-family: 'Inter', sans-serif; font-weight: 800; font-size: 1.15rem; color: #fff; letter-spacing: -0.02em; }
        .footer-brand-name span { color: var(--cl-red); }
        .footer-heading { font-family: 'Inter', sans-serif; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.15em; color: rgba(255,255,255,0.5); margin-bottom: 1.25rem; }
        .footer-links { list-style: none; padding: 0; margin: 0; }
        .footer-links li { margin-bottom: 0.65rem; }
        .footer-links a { display: inline-flex; align-items: center; gap: 0.35rem; }
        .footer-links a i { font-size: 0.6rem; opacity: 0; transition: opacity 0.2s ease; }
        .footer-links a:hover i { opacity: 1; }
        .footer-desc { color: rgba(255,255,255,0.3); font-size: 0.875rem; line-height: 1.7; }
        .footer-divider { border: none; height: 1px; background: rgba(255,255,255,0.06); margin: 2rem 0 1.5rem; }
        .footer-bottom { color: rgba(255,255,255,0.25); font-size: 0.8rem; }
        .footer-bottom .hl { color: rgba(255,255,255,0.5); }

        /* ══════════════ RESPONSIVE ══════════════ */
        @media (max-width: 1199.98px) {
            .hero-float-badge { display: none !important; }
        }
        @media (max-width: 991.98px) {
            .hero-cards-col { margin-top: 3rem; }
            .hero-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0; }
            .hero-stat { padding-right: 0; text-align: center; padding: 0 0.5rem; }
            .hero-stat:not(:last-child)::after { display: none; }
            .hero-stat-value { font-size: 1.35rem; }
            .hero-stat-label { font-size: 0.68rem; }
            .navbar-main .nav-btn-donate { width: 100%; justify-content: center; }
        }
        @media (max-width: 767.98px) {
            .hero-title { font-size: 2rem; }
            .hero-desc { font-size: 0.95rem; }
            .hero-actions { flex-direction: column; }
            .hero-actions .btn-hero-primary,
            .hero-actions .btn-hero-secondary { width: 100%; justify-content: center; }
            .section-heading { font-size: 1.55rem; }
            .step-card { padding: 1.5rem 1.25rem; }
            .campaign-card-inner { padding: 1.25rem; }
            .chatbot-cta-card { padding: 2rem 1.5rem !important; }
            .actor-card { padding: 1.25rem 1rem; }
        }
        @media (max-width: 575.98px) {
            .hero-stat-value { font-size: 1.15rem; }
            .hero-stat-label { font-size: 0.6rem; letter-spacing: 0.02em; }
        }
    </style>
</head>
<body>

    <!-- ══════════════════ NAVBAR ══════════════════ -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-main sticky-top" id="mainNav">
        <div class="container">
            <a href="/" class="navbar-brand nav-brand">
                <div class="nav-logo-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <span class="nav-brand-name">Charity<span>Link</span></span>
            </a>
            <div class="d-flex align-items-center gap-2 d-lg-none">
                <button class="dark-toggle" id="darkToggleMobile" aria-label="Mode sombre">
                    <i class="bi bi-moon-stars-fill icon-moon"></i>
                    <i class="bi bi-sun-fill icon-sun"></i>
                </button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav mx-auto mb-3 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('associations.index') }}">Associations</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('campaigns.index') }}">Campagnes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('taches.index') }}">Bénévolat</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('besoins.create') }}">Besoin d'aide</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('chatbot.index') }}"><i class="bi bi-robot nav-icon-ai"></i> Assistant IA</a></li>
                </ul>
                <div class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center gap-2">
                    <button class="dark-toggle d-none d-lg-flex" id="darkToggleDesktop" aria-label="Mode sombre">
                        <i class="bi bi-moon-stars-fill icon-moon"></i>
                        <i class="bi bi-sun-fill icon-sun"></i>
                    </button>
                    @auth
                        <a href="{{ route('dashboard') }}" class="nav-btn-donate">Mon espace <i class="bi bi-arrow-right"></i></a>
                    @else
                        <a href="{{ route('login') }}" class="nav-btn-ghost">Connexion</a>
                        <a href="{{ route('register') }}" class="nav-btn-donate">S'inscrire <i class="bi bi-arrow-right"></i></a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ══════════════════ HERO ══════════════════ -->
    <header class="hero">
        <div class="hero-bg-pattern"></div>
        <div class="hero-grid-pattern"></div>
        <div class="container">
            <div class="row align-items-center py-5 my-lg-2">
                <div class="col-lg-6 hero-content mb-4 mb-lg-0">
                    <div class="hero-tag anim-fade-up">
                        <span class="pulse-dot"></span>
                        🇹🇳 Plateforme Humanitaire Tunisienne
                    </div>
                    <h1 class="hero-title anim-fade-up-d1">
                        La Solidarité,<br><span class="accent">Numérique</span><br>et Intelligente.
                    </h1>
                    <p class="hero-desc anim-fade-up-d2">
                        Charity-Link connecte donateurs, associations et bénévoles pour un impact humanitaire réel en Tunisie. Guidé par l'Intelligence Artificielle.
                    </p>
                    <div class="hero-actions anim-fade-up-d3">
                        <a href="{{ route('campaigns.index') }}" class="btn-hero-primary">
                            <i class="bi bi-heart-fill"></i> Faire un don
                        </a>
                        <a href="{{ route('besoins.create') }}" class="btn-hero-secondary">
                            <i class="bi bi-megaphone-fill"></i> J'ai besoin d'aide
                        </a>
                    </div>
                    @php
                        $totalAssociations = \App\Models\Association::where('status', 'validee')->count();
                        $totalDons         = \App\Models\Donation::count();
                        $totalCollected    = \App\Models\Donation::where('type', 'financier')->sum('amount');
                    @endphp
                    <div class="hero-stats anim-fade-up-d4">
                        <div class="hero-stat">
                            <div class="hero-stat-value">{{ $totalAssociations }}</div>
                            <div class="hero-stat-label">Associations</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-value">{{ $totalDons }}</div>
                            <div class="hero-stat-label">Dons effectués</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-value">{{ number_format($totalCollected, 0) }} DT</div>
                            <div class="hero-stat-label">Collectés</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 offset-lg-1 hero-cards-col">
                    <div class="hero-float-badge badge-ai d-none d-xl-flex">
                        <div class="fb-icon fb-icon-blue"><i class="bi bi-stars" style="color:var(--cl-blue);"></i></div>
                        Propulsé par l'IA
                    </div>

                    @php $heroCampaigns = \App\Models\Campaign::active()->with('association')->latest()->take(3)->get(); @endphp
                    @if($heroCampaigns->isEmpty())
                        <div class="hero-empty-state anim-fade-up-d2">
                            <div class="icon-wrap"><i class="bi bi-heart"></i></div>
                            <p>Les premières campagnes arrivent bientôt.</p>
                        </div>
                    @else
                        @foreach($heroCampaigns as $hc)
                        <div class="hero-card anim-fade-up-{{ $loop->iteration }}">
                            <div class="hero-card-badge">{{ ucfirst($hc->association->category ?? 'Humanitaire') }}</div>
                            <div class="hero-card-title">{{ Str::limit($hc->title, 52) }}</div>
                            <div class="hero-card-meta"><i class="bi bi-geo-alt-fill"></i> {{ $hc->association->name }} · {{ $hc->association->region }}</div>
                            <div class="progress-bar-cl">
                                <div class="bar" role="progressbar" style="width: {{ $hc->progressPercentage() }}%;" aria-valuenow="{{ $hc->progressPercentage() }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="hero-card-stats">
                                <span class="hero-card-amount">{{ number_format($hc->current_amount, 0) }} DT</span>
                                <span class="hero-card-percent">{{ $hc->progressPercentage() }}%</span>
                            </div>
                        </div>
                        @endforeach
                    @endif

                    <div class="hero-float-badge badge-trust d-none d-xl-flex">
                        <div class="fb-icon fb-icon-green"><i class="bi bi-patch-check-fill" style="color:var(--cl-green);"></i></div>
                        Associations vérifiées
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ══════════════════ TRUST STRIP ══════════════════ -->
    <div class="trust-strip">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <div class="d-flex flex-wrap justify-content-center gap-4 gap-lg-5">
                        <div class="trust-item"><i class="bi bi-shield-check"></i> Associations vérifiées</div>
                        <div class="trust-item"><i class="bi bi-lock-fill"></i> Paiements sécurisés</div>
                        <div class="trust-item"><i class="bi bi-eye-fill"></i> Transparence totale</div>
                        <div class="trust-item"><i class="bi bi-people-fill"></i> 100% tunisien</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════════════ HOW IT WORKS ══════════════════ -->
    <section class="how-section py-5 py-lg-6">
        <div class="container py-4 py-lg-5">
            <div class="text-center mb-5">
                <div class="section-eyebrow"><i class="bi bi-arrow-repeat"></i> Comment ça marche</div>
                <h2 class="section-heading">Simple. Transparent. Impactant.</h2>
                <p class="section-desc mx-auto">Trois étapes pour changer une vie en Tunisie.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-card-icon step-icon-red">🔍</div>
                        <div class="step-num">Étape 01</div>
                        <h3>Découvrez</h3>
                        <p>Parcourez les associations validées et les campagnes actives. Notre assistant IA vous guide vers la cause la plus adaptée à vos valeurs.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-card-icon step-icon-green">🤲</div>
                        <div class="step-num">Étape 02</div>
                        <h3>Contribuez</h3>
                        <p>Don financier simulé, objets en nature (vêtements, médicaments…) ou partage de compétences professionnelles. Chaque geste compte.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-card-icon step-icon-blue">📊</div>
                        <div class="step-num">Étape 03</div>
                        <h3>Suivez l'impact</h3>
                        <p>Barres de progression en temps réel, tableau de bord personnalisé et notifications automatiques pour chaque étape de votre don.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════ CAMPAIGNS ══════════════════ -->
    <section class="campaigns-section py-5 py-lg-6">
        <div class="container py-4 py-lg-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-end mb-4 gap-3">
                <div>
                    <div class="section-eyebrow"><i class="bi bi-fire"></i> Campagnes actives</div>
                    <h2 class="section-heading mb-0">Soutenez ces causes urgentes</h2>
                </div>
                <a href="{{ route('campaigns.index') }}" class="btn-see-all flex-shrink-0">
                    Voir toutes <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @php $campaigns = \App\Models\Campaign::active()->with('association')->latest()->take(3)->get(); @endphp
            @if($campaigns->isEmpty())
                <div class="campaigns-empty-state">
                    <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                    <p>Aucune campagne active pour le moment.</p>
                </div>
            @else
            <div class="row g-4">
                @foreach($campaigns as $campaign)
                <div class="col-md-6 col-lg-4">
                    <div class="campaign-card">
                        <div class="campaign-card-inner">
                            <div class="cc-badge">
                                <i class="bi bi-tag-fill"></i>
                                {{ ucfirst($campaign->association->category ?? 'Humanitaire') }}
                            </div>
                            <h5>{{ Str::limit($campaign->title, 55) }}</h5>
                            <p class="cc-org"><i class="bi bi-buildings"></i> {{ $campaign->association->name }}</p>
                            <div class="cc-footer">
                                <div class="cc-progress">
                                    <div class="track">
                                        <div class="bar" role="progressbar" style="width: {{ $campaign->progressPercentage() }}%;"></div>
                                    </div>
                                </div>
                                <div class="cc-amounts">
                                    <span class="cc-raised">{{ number_format($campaign->current_amount, 0) }} DT</span>
                                    <span class="cc-goal">Objectif : <strong>{{ number_format($campaign->goal_amount, 0) }} DT</strong> · {{ $campaign->progressPercentage() }}%</span>
                                </div>
                                <a href="{{ route('campaigns.show', $campaign) }}" class="btn-donate-card">
                                    <i class="bi bi-heart-fill"></i> Contribuer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    <!-- ══════════════════ CHATBOT CTA ══════════════════ -->
    <section class="chatbot-section py-4 py-lg-5">
        <div class="container">
            <div class="chatbot-cta-card p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <h2>Vous ne savez pas quelle cause soutenir ?</h2>
                        <p>Notre assistant IA analyse votre intention et vous recommande l'association tunisienne la plus adaptée. Gratuit, instantané, intelligent.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('chatbot.index') }}" class="btn-chatbot">
                            <i class="bi bi-robot robot-icon"></i>
                            Parler à l'assistant
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════ ACTORS ══════════════════ -->
    <section class="actors-section py-5 py-lg-6">
        <div class="container py-4 py-lg-5">
            <div class="text-center mb-5">
                <div class="section-eyebrow"><i class="bi bi-diagram-3"></i> Notre écosystème</div>
                <h2 class="section-heading">5 acteurs, 1 mission solidaire</h2>
            </div>
            <div class="row g-3 g-lg-4 justify-content-center">
                <div class="col-6 col-lg">
                    <div class="actor-card">
                        <div class="actor-card-icon actor-icon-1">💰</div>
                        <div class="actor-name">Donateur</div>
                        <p class="actor-desc">Fait des dons financiers, en nature ou en compétences.</p>
                    </div>
                </div>
                <div class="col-6 col-lg">
                    <div class="actor-card">
                        <div class="actor-card-icon actor-icon-2">🏢</div>
                        <div class="actor-name">Association</div>
                        <p class="actor-desc">Publie des campagnes et gère les bénévoles.</p>
                    </div>
                </div>
                <div class="col-6 col-lg">
                    <div class="actor-card">
                        <div class="actor-card-icon actor-icon-3">🛡️</div>
                        <div class="actor-name">Administrateur</div>
                        <p class="actor-desc">Valide les associations et modère la plateforme.</p>
                    </div>
                </div>
                <div class="col-6 col-lg">
                    <div class="actor-card">
                        <div class="actor-card-icon actor-icon-4">🤝</div>
                        <div class="actor-name">Bénévole</div>
                        <p class="actor-desc">Prend des tâches et offre ses compétences.</p>
                    </div>
                </div>
                <div class="col-6 col-lg d-none d-lg-block">
                    <div class="actor-card">
                        <div class="actor-card-icon actor-icon-5">🆘</div>
                        <div class="actor-name">Internaute</div>
                        <p class="actor-desc">Déclare un besoin d'aide sans inscription.</p>
                    </div>
                </div>
                <div class="col-12 d-lg-none">
                    <div class="actor-card">
                        <div class="actor-card-icon actor-icon-5">🆘</div>
                        <div class="actor-name">Internaute</div>
                        <p class="actor-desc">Déclare un besoin d'aide sans inscription.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════════ FOOTER ══════════════════ -->
    <footer class="footer-main pt-5 pb-4">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="nav-logo-icon" style="width:34px;height:34px;border-radius:8px;">
                            <i class="bi bi-heart-pulse-fill" style="font-size:0.9rem;"></i>
                        </div>
                        <span class="footer-brand-name">Charity<span>Link</span></span>
                    </div>
                    <p class="footer-desc">
                        Vers une Solidarité Numérique Intelligente au Service des Associations Tunisiennes.
                    </p>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="footer-heading">Plateforme</div>
                    <ul class="footer-links">
                        <li><a href="{{ route('associations.index') }}"><i class="bi bi-chevron-right"></i> Associations</a></li>
                        <li><a href="{{ route('campaigns.index') }}"><i class="bi bi-chevron-right"></i> Campagnes</a></li>
                        <li><a href="{{ route('taches.index') }}"><i class="bi bi-chevron-right"></i> Bénévolat</a></li>
                        <li><a href="{{ route('chatbot.index') }}"><i class="bi bi-chevron-right"></i> Assistant IA</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-4">
                    <div class="footer-heading">Actions</div>
                    <ul class="footer-links">
                        <li><a href="{{ route('register') }}"><i class="bi bi-chevron-right"></i> S'inscrire</a></li>
                        <li><a href="{{ route('login') }}"><i class="bi bi-chevron-right"></i> Connexion</a></li>
                        <li><a href="{{ route('besoins.create') }}"><i class="bi bi-chevron-right"></i> Déclarer un besoin</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-divider"></div>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 footer-bottom">
                <p class="mb-0">© {{ date('Y') }} <span class="hl">CharityLink</span> — Tous droits réservés</p>
                <p class="mb-0">Made with <span style="color:var(--cl-red);">♥</span> in Tunisia</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ═══════════ DARK MODE ═══════════
        function getTheme() {
            return localStorage.getItem('cl-theme') ||
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        }
        function applyTheme(theme) {
            document.documentElement.classList.toggle('dark', theme === 'dark');
            localStorage.setItem('cl-theme', theme);
        }
        function toggleTheme() {
            const next = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
            applyTheme(next);
        }

        // Apply on load (before paint to avoid flash)
        applyTheme(getTheme());

        // Toggle buttons
        document.getElementById('darkToggleDesktop').addEventListener('click', toggleTheme);
        document.getElementById('darkToggleMobile').addEventListener('click', toggleTheme);

        // Listen for system preference changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('cl-theme')) {
                applyTheme(e.matches ? 'dark' : 'light');
            }
        });

        // ═══════════ NAVBAR SCROLL ═══════════
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 20);
        }, { passive: true });

        // ═══════════ PROGRESS BARS ANIMATE ═══════════
        const observerBars = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.querySelectorAll('.bar').forEach(bar => {
                        const w = bar.style.width;
                        bar.style.width = '0%';
                        requestAnimationFrame(() => {
                            requestAnimationFrame(() => { bar.style.width = w; });
                        });
                    });
                    observerBars.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });
        document.querySelectorAll('.hero-card, .campaign-card').forEach(c => observerBars.observe(c));

        // ═══════════ SCROLL REVEAL ═══════════
        const observerFade = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observerFade.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('.step-card, .actor-card, .campaign-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s cubic-bezier(0.22,1,0.36,1), transform 0.6s cubic-bezier(0.22,1,0.36,1)';
            observerFade.observe(el);
        });

        document.querySelectorAll('.row').forEach(row => {
            const cards = row.querySelectorAll('.step-card, .actor-card, .campaign-card');
            cards.forEach((card, i) => { card.style.transitionDelay = `${i * 0.08}s`; });
        });
    </script>
</body>
</html>
