<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire — CharityLink</title>

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

        /* ─── Top bar ─── */
        .register-topbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            z-index: 50;
        }
        .register-back {
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
        .register-back:hover {
            color: var(--cl-red);
            border-color: rgba(230,57,70,0.2);
            background: var(--cl-red-glow);
        }
        .register-dark-toggle {
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
        .register-dark-toggle:hover {
            border-color: var(--cl-red);
            color: var(--cl-red);
            background: var(--cl-red-glow);
            transform: rotate(15deg);
        }
        .register-dark-toggle .icon-sun { display: none; }
        .register-dark-toggle .icon-moon { display: block; }
        html.dark .register-dark-toggle .icon-sun { display: block; }
        html.dark .register-dark-toggle .icon-moon { display: none; }

        /* ─── Container ─── */
        .register-container {
            width: 100%;
            max-width: 1060px;
            min-height: 680px;
            display: flex;
            background: var(--cl-card-bg);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            margin: 20px;
            border: 1px solid var(--cl-card-border);
            animation: fadeUp 0.6s cubic-bezier(0.22,1,0.36,1) both;
            transition: background-color 0.35s ease, border-color 0.35s ease;
        }

        /* ─── Left Panel ─── */
        .register-left {
            flex: 0 0 380px;
            background: linear-gradient(155deg, var(--cl-blue-dark) 0%, var(--cl-blue) 50%, #243F64 100%);
            color: white;
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .register-left::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(230,57,70,0.12) 0%, transparent 60%);
            border-radius: 50%;
            pointer-events: none;
        }
        .register-left::after {
            content: '';
            position: absolute;
            bottom: -50px; left: -50px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(45,198,83,0.08) 0%, transparent 60%);
            border-radius: 50%;
            pointer-events: none;
        }

        .register-logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            z-index: 1;
        }
        .register-logo-icon {
            width: 42px; height: 42px;
            background: var(--cl-red);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(230,57,70,0.3);
        }
        .register-logo-icon::after {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent 40%, rgba(255,255,255,0.15) 50%, transparent 60%);
            animation: shimmer 3s ease-in-out infinite;
            background-size: 200% 100%;
        }
        .register-logo-icon i { color: #fff; font-size: 1.15rem; position: relative; z-index: 1; }
        .register-logo-text {
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            color: white;
            letter-spacing: -0.03em;
        }
        .register-logo-text span { color: #FF7A84; }

        .register-left-content { z-index: 1; }
        .register-quote {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.25rem;
        }
        .register-quote em {
            color: #FF7A84;
            font-style: italic;
        }
        .register-quote-sub {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
        }

        .register-roles-list {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            z-index: 1;
            padding-top: 1.75rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .role-item {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.85rem 1rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: var(--radius-md);
            transition: all 0.2s ease;
        }
        .role-item:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.15);
        }
        .role-icon { font-size: 1.35rem; }
        .role-info h4 {
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            margin: 0;
        }
        .role-info p {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.45);
            margin: 0;
        }

        /* ─── Right Panel ─── */
        .register-right {
            flex: 1;
            padding: 2.5rem 2.5rem;
            overflow-y: auto;
            display: flex;
            align-items: center;
        }
        .register-form-box {
            width: 100%;
            max-width: 520px;
        }
        .register-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--cl-dark);
            margin-bottom: 0.35rem;
            transition: color 0.35s ease;
        }
        .register-subtitle {
            font-size: 0.9rem;
            color: var(--cl-muted);
            margin-bottom: 2rem;
            transition: color 0.35s ease;
        }
        .register-subtitle a {
            color: var(--cl-red);
            text-decoration: none;
            font-weight: 600;
        }
        .register-subtitle a:hover { text-decoration: underline; }

        .form-label {
            font-weight: 600;
            font-size: 0.84rem;
            color: var(--cl-dark);
            margin-bottom: 0.4rem;
            transition: color 0.35s ease;
        }
        .form-control,
        .form-select {
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-sm);
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: var(--cl-dark);
            background: var(--cl-white);
            transition: all 0.25s ease;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--cl-red);
            box-shadow: 0 0 0 3px rgba(230,57,70,0.08);
            background: var(--cl-white);
            color: var(--cl-dark);
        }
        .form-control::placeholder { color: var(--cl-muted-light); }

        /* ─── Role Selector ─── */
        .role-selector-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }
        .role-option input { display: none; }
        .role-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            padding: 1.15rem 0.75rem;
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all 0.25s ease;
            background: var(--cl-card-bg);
            text-align: center;
        }
        .role-option input:checked + label {
            border-color: var(--cl-red);
            background: var(--cl-red-soft);
            color: var(--cl-red);
            box-shadow: 0 0 0 3px rgba(230,57,70,0.06);
        }
        .role-option label:hover {
            border-color: var(--cl-red);
        }
        .role-option .emoji { font-size: 1.4rem; }
        .role-option .name {
            font-family: 'Inter', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
        }
        .role-option .role-desc {
            font-size: 0.65rem;
            color: var(--cl-muted);
            margin: 0;
        }
        .role-option input:checked + label .role-desc {
            color: var(--cl-red);
        }

        /* ─── Submit ─── */
        .btn-register {
            background: var(--cl-red);
            border: none;
            border-radius: var(--radius-full);
            padding: 0.8rem;
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
        .btn-register:hover {
            background: var(--cl-red-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(230,57,70,0.3);
            color: #fff;
        }

        .invalid-feedback { font-size: 0.8rem; }
        .text-danger { color: var(--cl-red) !important; }

        /* ─── Responsive ─── */
        @media (max-width: 991.98px) {
            .register-left { display: none; }
            .register-container { max-width: 520px; }
            .register-right { padding: 2.5rem 2rem; }
        }
        @media (max-width: 575.98px) {
            .register-container { margin: 0; border-radius: 0; min-height: 100vh; border: none; box-shadow: none; }
            .register-right { padding: 2rem 1.5rem; }
            .register-form-box { max-width: 100%; }
            .role-selector-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Top bar -->
    <div class="register-topbar">
        <a href="/" class="register-back">
            <i class="bi bi-arrow-left"></i>
            Accueil
        </a>
        <button class="register-dark-toggle" onclick="clToggleDark()" aria-label="Mode sombre">
            <i class="bi bi-moon-stars-fill icon-moon"></i>
            <i class="bi bi-sun-fill icon-sun"></i>
        </button>
    </div>

    <div class="register-container">
        <!-- Left Panel -->
        <div class="register-left">
            <a href="/" class="register-logo">
                <div class="register-logo-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <span class="register-logo-text">Charity<span>Link</span></span>
            </a>

            <div class="register-left-content">
                <h2 class="register-quote">
                    Rejoignez la<br>
                    communauté<br>
                    <em>solidaire.</em>
                </h2>
                <p class="register-quote-sub">
                    Choisissez votre rôle et commencez à contribuer à des causes humanitaires en Tunisie dès aujourd'hui.
                </p>
            </div>

            <div class="register-roles-list">
                <div class="role-item">
                    <div class="role-icon">💝</div>
                    <div class="role-info">
                        <h4>Donateur</h4>
                        <p>Dons financiers, en nature ou en compétences</p>
                    </div>
                </div>
                <div class="role-item">
                    <div class="role-icon">🏢</div>
                    <div class="role-info">
                        <h4>Association</h4>
                        <p>Publiez des campagnes et gerez des bénévoles</p>
                    </div>
                </div>
                <div class="role-item">
                    <div class="role-icon">🤝</div>
                    <div class="role-info">
                        <h4>Bénévole</h4>
                        <p>Offrez votre temps et vos compétences</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="register-right">
            <div class="register-form-box">
                <h1 class="register-title">Créer un compte 🎉</h1>
                <p class="register-subtitle">
                    Déjà membre ?
                    <a href="{{ route('login') }}">Se connecter</a>
                </p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nom complet</label>
                            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Prénom Nom" required autofocus autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="votre@email.tn" required autocomplete="username">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Téléphone <span style="color:var(--cl-muted);font-weight:400;">(optionnel)</span></label>
                            <input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+216 XX XXX XXX">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="language" class="form-label">Langue préférée</label>
                            <select name="language" id="language" class="form-select">
                                <option value="fr" {{ old('language','fr')=='fr'?'selected':'' }}>🇫🇷 Français</option>
                                <option value="ar" {{ old('language')=='ar'?'selected':'' }}>🇹🇳 العربية</option>
                                <option value="en" {{ old('language')=='en'?'selected':'' }}>🇬🇧 English</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Je suis un(e)</label>
                            <div class="role-selector-grid">
                                <div class="role-option">
                                    <input type="radio" name="role" id="role_donateur" value="donateur" {{ old('role','donateur')=='donateur'?'checked':'' }}>
                                    <label for="role_donateur">
                                        <span class="emoji">💝</span>
                                        <span class="name">Donateur</span>
                                        <span class="role-desc">Dons financiers & aide</span>
                                    </label>
                                </div>
                                <div class="role-option">
                                    <input type="radio" name="role" id="role_association" value="association" {{ old('role')=='association'?'checked':'' }}>
                                    <label for="role_association">
                                        <span class="emoji">🏢</span>
                                        <span class="name">Association</span>
                                        <span class="role-desc">Campagnes & gestion</span>
                                    </label>
                                </div>
                                <div class="role-option">
                                    <input type="radio" name="role" id="role_benevole" value="benevole" {{ old('role')=='benevole'?'checked':'' }}>
                                    <label for="role_benevole">
                                        <span class="emoji">🤝</span>
                                        <span class="name">Bénévole</span>
                                        <span class="role-desc">Temps & compétences</span>
                                    </label>
                                </div>
                            </div>
                            @error('role')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimum 8 caractères" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmation</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Reprendre le mot de passe" required autocomplete="new-password">
                        </div>
                    </div>

                    <button type="submit" class="btn-register">
                        Créer mon compte <i class="bi bi-arrow-right"></i>
                    </button>
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
