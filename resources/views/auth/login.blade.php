{{--resources\views\auth\login.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — CharityLink</title>

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
            --cl-blue-dark: #152B47;
            --cl-green: #2DC653;
            --cl-dark: #111827;
            --cl-body: #374151;
            --cl-muted: #6b7280;
            --cl-muted-light: #9ca3af;
            --cl-light: #f9fafb;
            --cl-border: #e5e7eb;
            --cl-white: #ffffff;
            --cl-card-bg: var(--cl-white);
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
            --cl-dark: #f1f5f9;
            --cl-body: #cbd5e1;
            --cl-muted: #94a3b8;
            --cl-muted-light: #64748b;
            --cl-light: #1e293b;
            --cl-border: #334155;
            --cl-white: #0f172a;
            --cl-card-bg: #1e293b;
            --shadow-xl: 0 20px 50px -12px rgba(0,0,0,0.5);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--cl-light);
            color: var(--cl-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-font-smoothing: antialiased;
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

        /* ─── Top bar ─── */
        .login-topbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            z-index: 50;
        }
        .login-back {
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
        .login-back:hover {
            color: var(--cl-red);
            border-color: rgba(230,57,70,0.2);
            background: var(--cl-red-glow);
        }
        .login-dark-toggle {
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
        .login-dark-toggle:hover {
            border-color: var(--cl-red);
            color: var(--cl-red);
            background: var(--cl-red-glow);
            transform: rotate(15deg);
        }
        .login-dark-toggle .icon-sun { display: none; }
        .login-dark-toggle .icon-moon { display: block; }
        html.dark .login-dark-toggle .icon-sun { display: block; }
        html.dark .login-dark-toggle .icon-moon { display: none; }

        /* ─── Container ─── */
        .login-container {
            width: 100%;
            max-width: 1000px;
            min-height: 620px;
            display: flex;
            background: var(--cl-card-bg);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            margin: 20px;
            border: 1px solid var(--cl-border);
            animation: fadeUp 0.6s cubic-bezier(0.22,1,0.36,1) both;
            transition: background-color 0.35s ease, border-color 0.35s ease;
        }

        /* ─── Left Panel ─── */
        .login-left {
            flex: 1;
            background: linear-gradient(155deg, var(--cl-blue-dark) 0%, var(--cl-blue) 50%, #243F64 100%);
            color: white;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .login-left::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(230,57,70,0.12) 0%, transparent 60%);
            border-radius: 50%;
            pointer-events: none;
        }
        .login-left::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -40px;
            width: 250px; height: 250px;
            background: radial-gradient(circle, rgba(45,198,83,0.08) 0%, transparent 60%);
            border-radius: 50%;
            pointer-events: none;
        }

        .login-logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            z-index: 1;
        }
        .login-logo-icon {
            width: 42px; height: 42px;
            background: var(--cl-red);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(230,57,70,0.3);
        }
        .login-logo-icon::after {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent 40%, rgba(255,255,255,0.15) 50%, transparent 60%);
            animation: shimmer 3s ease-in-out infinite;
            background-size: 200% 100%;
        }
        .login-logo-icon i { color: #fff; font-size: 1.15rem; position: relative; z-index: 1; }
        .login-logo-text {
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            color: white;
            letter-spacing: -0.03em;
        }
        .login-logo-text span { color: #FF7A84; }

        .login-left-content { z-index: 1; }

        .login-quote {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.25rem;
        }
        .login-quote em {
            color: #FF7A84;
            font-style: italic;
        }
        .login-quote-sub {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
            max-width: 360px;
        }

        .login-stats {
            display: flex;
            gap: 2.5rem;
            z-index: 1;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: #fff;
        }
        .stat-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 0.15rem;
        }

        /* ─── Right Panel ─── */
        .login-right {
            flex: 1;
            padding: 3rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-form-box {
            width: 100%;
            max-width: 370px;
        }
        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--cl-dark);
            margin-bottom: 0.35rem;
            transition: color 0.35s ease;
        }
        .login-subtitle {
            font-size: 0.9rem;
            color: var(--cl-muted);
            margin-bottom: 2rem;
            transition: color 0.35s ease;
        }
        .login-subtitle a {
            color: var(--cl-red);
            text-decoration: none;
            font-weight: 600;
        }
        .login-subtitle a:hover { text-decoration: underline; }

        /* ─── Alert ─── */
        .login-alert {
            background: var(--cl-green-soft);
            border: none;
            border-radius: var(--radius-md);
            padding: 0.85rem 1rem;
            font-size: 0.88rem;
            color: #166534;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        html.dark .login-alert {
            background: rgba(45,198,83,0.12);
            color: #4ade80;
        }

        /* ─── Form ─── */
        .login-form-box .form-label {
            font-weight: 600;
            font-size: 0.84rem;
            color: var(--cl-dark);
            margin-bottom: 0.4rem;
            transition: color 0.35s ease;
        }
        .login-form-box .form-control {
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-sm);
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: var(--cl-dark);
            background: var(--cl-white);
            transition: all 0.25s ease;
        }
        .login-form-box .form-control:focus {
            border-color: var(--cl-red);
            box-shadow: 0 0 0 3px rgba(230,57,70,0.08);
            background: var(--cl-white);
            color: var(--cl-dark);
        }
        .login-form-box .form-control::placeholder { color: var(--cl-muted-light); }
        .login-form-box .form-check-input {
            background-color: var(--cl-light);
            border: 1px solid var(--cl-border);
            transition: all 0.2s ease;
        }
        html.dark .login-form-box .form-check-input {
            background-color: #1e293b;
            border-color: #334155;
        }
        .login-form-box .form-check-input:checked {
            background-color: var(--cl-red);
            border-color: var(--cl-red);
        }
        .login-form-box .form-check-label {
            font-size: 0.84rem;
            color: var(--cl-muted);
        }

        .forgot-link {
            font-size: 0.84rem;
            color: var(--cl-red);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .forgot-link:hover { text-decoration: underline; }

        .btn-login {
            background: var(--cl-red);
            border: none;
            border-radius: var(--radius-full);
            padding: 0.75rem;
            font-weight: 700;
            font-size: 0.95rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            transition: all 0.25s ease;
            margin-top: 0.5rem;
        }
        .btn-login:hover {
            background: var(--cl-red-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(230,57,70,0.3);
            color: #fff;
        }

        .login-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
            color: var(--cl-muted);
            font-size: 0.78rem;
            font-weight: 500;
        }
        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--cl-border);
        }

        .btn-register-alt {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.7rem;
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-full);
            background: var(--cl-card-bg);
            color: var(--cl-body);
            font-weight: 600;
            font-size: 0.92rem;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .btn-register-alt:hover {
            border-color: var(--cl-red);
            color: var(--cl-red);
            background: var(--cl-red-glow);
        }

        .invalid-feedback { font-size: 0.8rem; }

        /* ─── Responsive ─── */
        @media (max-width: 991.98px) {
            .login-container { max-width: 480px; }
            .login-left { display: none; }
            .login-right { padding: 2.5rem 2rem; }
        }
        @media (max-width: 575.98px) {
            .login-container { margin: 0; border-radius: 0; min-height: 100vh; border: none; box-shadow: none; }
            .login-right { padding: 2rem 1.5rem; }
            .login-form-box { max-width: 100%; }
            .login-topbar { padding: 0.75rem 1rem; }
        }
    </style>
</head>
<body>

    <!-- Top bar -->
    <div class="login-topbar">
        <a href="/" class="login-back">
            <i class="bi bi-arrow-left"></i>
            Accueil
        </a>
        <button class="login-dark-toggle" onclick="clToggleDark()" aria-label="Mode sombre">
            <i class="bi bi-moon-stars-fill icon-moon"></i>
            <i class="bi bi-sun-fill icon-sun"></i>
        </button>
    </div>

    <div class="login-container">
        <!-- Left Panel -->
        <div class="login-left">
            <a href="/" class="login-logo">
                <div class="login-logo-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <span class="login-logo-text">Charity<span>Link</span></span>
            </a>

            <div class="login-left-content">
                <h2 class="login-quote">
                    La solidarité,<br>
                    commence par<br>
                    un <em>geste simple.</em>
                </h2>
                <p class="login-quote-sub">
                    Rejoignez des milliers de Tunisiens qui contribuent chaque jour à des causes humanitaires grâce à CharityLink.
                </p>
            </div>

            @php
                $totalDons = \App\Models\Donation::count();
                $totalAssoc = \App\Models\Association::where('status','validee')->count();
            @endphp

            <div class="login-stats">
                <div>
                    <div class="stat-num">{{ $totalAssoc }}</div>
                    <div class="stat-label">Associations</div>
                </div>
                <div>
                    <div class="stat-num">{{ $totalDons }}</div>
                    <div class="stat-label">Dons effectués</div>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="login-right">
            <div class="login-form-box">
                <h1 class="login-title">Bon retour 👋</h1>
                <p class="login-subtitle">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}">S'inscrire gratuitement</a>
                </p>

                @if (session('status'))
                    <div class="login-alert">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="votre@email.tn" required autofocus autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Oublié ?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-login">
                        Se connecter <i class="bi bi-arrow-right"></i>
                    </button>

                    <div class="login-divider">
                        <span>ou</span>
                    </div>

                    <a href="{{ route('register') }}" class="btn-register-alt">
                        <i class="bi bi-person-plus"></i>
                        Créer un compte gratuit
                    </a>
                </form>
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
