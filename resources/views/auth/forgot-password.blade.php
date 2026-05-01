<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié — CharityLink</title>

    <script>
        (function(){
            var t=localStorage.getItem('cl-theme');
            if(!t) t=window.matchMedia('(prefers-color-scheme:dark)').matches?'dark':'light';
            if(t==='dark') document.documentElement.classList.add('dark');
        })();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --cl-red: #E63946;
            --cl-red-hover: #d32f3d;
            --cl-red-soft: #fef2f2;
            --cl-red-glow: rgba(230, 57, 70, 0.08);
            --cl-blue: #1D3557;
            --cl-blue-soft: #f0f4f8;
            --cl-blue-mid: rgba(29, 53, 87, 0.06);
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
            --cl-dark: #f1f5f9;
            --cl-body: #cbd5e1;
            --cl-muted: #94a3b8;
            --cl-muted-light: #64748b;
            --cl-light: #1e293b;
            --cl-border: #334155;
            --cl-white: #0f172a;
            --cl-card-bg: #1e293b;
            --cl-card-border: #334155;
            --shadow-xl: 0 20px 50px -12px rgba(0,0,0,0.5);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--cl-light);
            color: var(--cl-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.9); opacity: 1; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        /* ─── Background ─── */
        .forgot-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }
        .forgot-bg::before {
            content: '';
            position: absolute;
            top: -20%; right: -10%;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(230,57,70,0.05) 0%, transparent 55%);
            border-radius: 50%;
            pointer-events: none;
        }
        .forgot-bg::after {
            content: '';
            position: absolute;
            bottom: -15%; left: -10%;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(29,53,87,0.04) 0%, transparent 55%);
            border-radius: 50%;
            pointer-events: none;
        }
        html.dark .forgot-bg::before { opacity: 0.3; }
        html.dark .forgot-bg::after { opacity: 0.3; }
        .forgot-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(0,0,0,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,0,0,0.02) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
        }
        html.dark .forgot-grid {
            background-image:
                linear-gradient(rgba(255,255,255,0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.015) 1px, transparent 1px);
        }

        /* ─── Top bar ─── */
        .forgot-topbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            z-index: 50;
        }
        .forgot-back {
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
        }
        .forgot-back:hover {
            color: var(--cl-red);
            border-color: rgba(230,57,70,0.2);
            background: var(--cl-red-glow);
        }
        .forgot-dark-toggle {
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
        }
        .forgot-dark-toggle:hover {
            border-color: var(--cl-red);
            color: var(--cl-red);
            background: var(--cl-red-glow);
            transform: rotate(15deg);
        }
        .forgot-dark-toggle .icon-sun { display: none; }
        .forgot-dark-toggle .icon-moon { display: block; }
        html.dark .forgot-dark-toggle .icon-sun { display: block; }
        html.dark .forgot-dark-toggle .icon-moon { display: none; }

        /* ─── Container ─── */
        .forgot-container {
            width: 100%;
            max-width: 460px;
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
            margin: 20px;
            padding: 3rem 2.5rem;
            text-align: center;
            position: relative;
            z-index: 2;
            animation: fadeUp 0.6s cubic-bezier(0.22,1,0.36,1) both;
            transition: background-color 0.35s ease, border-color 0.35s ease;
        }
        .forgot-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--cl-blue), var(--cl-red), var(--cl-green));
            border-radius: var(--radius-xl) var(--radius-xl) 0 0;
        }

        /* ─── Shield Icon ─── */
        .forgot-shield {
            width: 88px; height: 88px;
            background: var(--cl-blue-soft);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.75rem;
            position: relative;
        }
        html.dark .forgot-shield { background: rgba(29,53,87,0.2); }
        .forgot-shield i {
            font-size: 2rem;
            color: var(--cl-blue);
        }
        .forgot-shield::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 2px solid var(--cl-blue);
            opacity: 0.2;
            animation: pulse-ring 3s ease-out infinite;
        }
        html.dark .forgot-shield::after { border-color: rgba(93,187,253,0.3); }

        /* ─── Title ─── */
        .forgot-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--cl-dark);
            margin-bottom: 0.5rem;
            transition: color 0.35s ease;
        }

        /* ─── Description ─── */
        .forgot-desc {
            font-size: 0.92rem;
            color: var(--cl-muted);
            line-height: 1.7;
            max-width: 380px;
            margin: 0 auto 2.25rem;
            transition: color 0.35s ease;
        }

        /* ─── Alert ─── */
        .forgot-alert {
            background: var(--cl-green-soft);
            border: none;
            border-radius: var(--radius-md);
            padding: 0.85rem 1.1rem;
            font-size: 0.88rem;
            color: #166534;
            margin-bottom: 2rem;
            text-align: left;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
        }
        html.dark .forgot-alert {
            background: rgba(45,198,83,0.12);
            color: #4ade80;
        }
        .forgot-alert i {
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* ─── Form ─── */
        .forgot-form .form-label {
            font-weight: 600;
            font-size: 0.84rem;
            color: var(--cl-dark);
            text-align: left;
            margin-bottom: 0.4rem;
            transition: color 0.35s ease;
        }
        .forgot-form .form-control {
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-sm);
            padding: 0.8rem 1rem;
            font-size: 0.92rem;
            font-family: 'Inter', sans-serif;
            color: var(--cl-dark);
            background: var(--cl-white);
            transition: all 0.25s ease;
            text-align: left;
        }
        .forgot-form .form-control:focus {
            border-color: var(--cl-red);
            box-shadow: 0 0 0 3px rgba(230,57,70,0.08);
            background: var(--cl-white);
            color: var(--cl-dark);
        }
        .forgot-form .form-control::placeholder { color: var(--cl-muted-light); }
        .invalid-feedback {
            font-size: 0.8rem;
            text-align: left;
        }

        /* ─── Submit ─── */
        .btn-reset {
            background: var(--cl-red);
            border: none;
            border-radius: var(--radius-full);
            padding: 0.85rem 2rem;
            font-weight: 700;
            font-size: 0.95rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-reset::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .btn-reset:hover {
            background: var(--cl-red-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(230,57,70,0.3);
            color: #fff;
        }
        .btn-reset:hover::before { opacity: 1; }

        /* ─── Back to login ─── */
        .forgot-login-link {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            color: var(--cl-body);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            padding: 0.5rem 0;
            margin-top: 2rem;
            transition: color 0.2s ease;
        }
        .forgot-login-link:hover { color: var(--cl-red); }

        /* ─── Security badges ─── */
        .security-badges {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid var(--cl-border);
        }
        .sec-badge {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        .sec-badge-icon {
            width: 40px; height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        .sec-badge-icon.sec-green { background: var(--cl-green-soft); color: var(--cl-green); }
        html.dark .sec-badge-icon.sec-green { background: rgba(45,198,83,0.12); }
        .sec-badge-icon.sec-blue { background: var(--cl-blue-soft); color: var(--cl-blue); }
        html.dark .sec-badge-icon.sec-blue { background: rgba(29,53,87,0.2); }
        .sec-badge-icon.sec-red { background: var(--cl-red-soft); color: var(--cl-red); }
        html.dark .sec-badge-icon.sec-red { background: rgba(230,57,70,0.12); }
        .sec-badge-text {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--cl-muted);
        }

        /* ─── Responsive ─── */
        @media (max-width: 575.98px) {
            .forgot-container {
                margin: 0;
                border-radius: 0;
                min-height: 100vh;
                border: none;
                box-shadow: none;
                padding: 2.5rem 1.5rem;
            }
            .forgot-title { font-size: 1.4rem; }
            .forgot-desc { font-size: 0.88rem; }
            .security-badges { gap: 1rem; }
            .security-badges { flex-wrap: wrap; }
        }
    </style>
</head>
<body>

    <!-- Top bar -->
    <div class="forgot-topbar">
        <a href="/" class="forgot-back">
            <i class="bi bi-arrow-left"></i>
            Accueil
        </a>
        <button class="forgot-dark-toggle" onclick="clToggleDark()" aria-label="Mode sombre">
            <i class="bi bi-moon-stars-fill icon-moon"></i>
            <i class="bi bi-sun-fill icon-sun"></i>
        </button>
    </div>

    <!-- Background -->
    <div class="forgot-bg">
        <div class="forgot-grid"></div>
    </div>

    <!-- Content -->
    <div class="forgot-container">
        <!-- Shield Icon -->
        <div class="forgot-shield">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <!-- Title -->
        <h1 class="forgot-title">Mot de passe oublié ?</h1>
        <p class="forgot-desc">
            Pas de panique. Entrez votre email et nous vous enverrons un lien pour réinitialiser votre mot de passe en quelques secondes.
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="forgot-alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('status') }}
            </div>
        @endif

        <!-- Form -->
        <form class="forgot-form" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">Adresse email</label>
                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="votre@email.tn" required autofocus autocomplete="email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-reset">
                <i class="bi bi-envelope-fill"></i>
                Envoyer le lien
            </button>

            <div class="forgot-login-link">
                <i class="bi bi-arrow-left"></i>
                <a href="{{ route('login') }}">Retour à la connexion</a>
            </div>
        </form>

        <!-- Security badges -->
        <div class="security-badges">
            <div class="sec-badge">
                <div class="sec-badge-icon sec-green"><i class="bi bi-shield-check"></i></div>
                <span class="sec-badge-text">Envoyé<br>sécurisé</span>
            </div>
            <div class="sec-badge">
                <div class="sec-badge-icon sec-blue"><i class="bi bi-lock-fill"></i></div>
                <span class="sec-badge-text">Lien à usage<br>unique</span>
            </div>
            <div class="sec-badge">
                <div class="sec-badge-icon sec-red"><i class="bi bi-clock-history"></i></div>
                <span class="sec-badge-text">Expire<br>en 1 heure</span>
            </div>
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
            localStorage.setItem('cl-themed', isDark ? 'dark' : 'light');
        }

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
            if (!localStorage.getItem('cl-theme')) {
                document.documentElement.classList.toggle('dark', e.matches);
            }
        });
    </script>
</body>
</html>
