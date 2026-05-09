<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Mon profil
            </div>
            <h2 class="mb-0" style="font-size:1.5rem;">Paramètres du compte</h2>
            <p class="header-sub mb-0">Gérez vos informations personnelles et la sécurité.</p>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">

                {{-- ✅ Avatar Hero avec upload --}}
                <div class="pf-hero">
                    <div class="pf-hero-avatar">

                        {{-- Formulaire avatar caché --}}
                        <form id="avatarForm" action="{{ route('profile.avatar') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="file" id="avatarInput" name="avatar"
                                   accept=".jpg,.jpeg,.png,.webp"
                                   style="display:none"
                                   onchange="submitAvatarForm(this)">
                        </form>

                        {{-- Avatar cliquable --}}
                        <div class="pf-avatar-circle" onclick="document.getElementById('avatarInput').click()"
                             title="Cliquer pour changer la photo" style="cursor:pointer;">
                            @if(Auth::user()->avatar)
                                <img id="avatarPreview"
                                     src="{{ Storage::url(Auth::user()->avatar) }}"
                                     alt="Avatar"
                                     style="width:100%;height:100%;object-fit:cover;border-radius:var(--radius-full);">
                            @else
                                <span id="avatarLetter">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                <img id="avatarPreview" src="#" alt="Avatar"
                                     style="display:none;width:100%;height:100%;object-fit:cover;border-radius:var(--radius-full);">
                            @endif
                        </div>

                        {{-- Badge caméra --}}
                        <div class="pf-avatar-badge" onclick="document.getElementById('avatarInput').click()"
                             style="cursor:pointer;" title="Changer la photo">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        </div>
                    </div>

                    <div class="pf-hero-info">
                        <h3 class="pf-hero-name">{{ Auth::user()->name }}</h3>
                        <p class="pf-hero-email">{{ Auth::user()->email }}</p>
                        <span class="pf-hero-role">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            {{ ucfirst(Auth::user()->role ?? 'Membre') }}
                        </span>
                        <p class="pf-avatar-hint">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            Cliquez sur la photo pour la modifier
                        </p>

                        {{-- Message succès avatar --}}
                        @if(session('status') === 'avatar-updated')
                            <span class="pf-avatar-success">✅ Photo mise à jour !</span>
                        @endif
                    </div>
                </div>

                {{-- Informations personnelles --}}
                <div class="pf-section">
                    <div class="pf-section-head">
                        <div class="pf-section-icon pf-section-icon--blue">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <div>
                            <h4 class="pf-section-title">Informations personnelles</h4>
                            <p class="pf-section-desc">Mettez à jour votre nom et votre adresse email.</p>
                        </div>
                    </div>
                    <div class="pf-section-body">
                        <div class="pf-form-wrap">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                {{-- Mot de passe --}}
                <div class="pf-section">
                    <div class="pf-section-head">
                        <div class="pf-section-icon pf-section-icon--orange">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <div>
                            <h4 class="pf-section-title">Sécurité du compte</h4>
                            <p class="pf-section-desc">Utilisez un mot de passe long et aléatoire.</p>
                        </div>
                    </div>
                    <div class="pf-section-body">
                        <div class="pf-form-wrap">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                {{-- Zone dangereuse --}}
                <div class="pf-section pf-section--danger">
                    <div class="pf-section-head">
                        <div class="pf-section-icon pf-section-icon--red">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        </div>
                        <div>
                            <h4 class="pf-section-title pf-section-title--red">Zone dangereuse</h4>
                            <p class="pf-section-desc">La suppression est définitive et irréversible.</p>
                        </div>
                    </div>
                    <div class="pf-section-body">
                        <div class="pf-form-wrap">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* ─── Avatar Hero ─── */
        .pf-hero {
            display: flex; align-items: center; gap: 1.25rem;
            padding: 1.5rem 1.5rem;
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1rem;
        }
        .pf-hero-avatar { position: relative; flex-shrink: 0; }
        .pf-avatar-circle {
            width: 80px; height: 80px;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, var(--cl-blue), #2a4a7a);
            color: #fff;
            font-family: 'Playfair Display', serif;
            font-weight: 700; font-size: 1.8rem;
            display: flex; align-items: center; justify-content: center;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: opacity 0.2s ease;
        }
        .pf-avatar-circle:hover { opacity: 0.85; }
        .pf-avatar-badge {
            position: absolute; bottom: 0; right: 0;
            width: 28px; height: 28px;
            background: var(--cl-red);
            border: 2px solid var(--cl-card-bg);
            border-radius: var(--radius-full);
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            box-shadow: var(--shadow-xs);
            transition: transform 0.2s ease;
        }
        .pf-avatar-badge:hover { transform: scale(1.1); }
        .pf-hero-info { min-width: 0; }
        .pf-hero-name {
            font-family: 'Inter', sans-serif;
            font-weight: 700; font-size: 1.1rem;
            color: var(--cl-dark);
            margin-bottom: 0.15rem;
        }
        .pf-hero-email { font-size: 0.85rem; color: var(--cl-muted); margin-bottom: 0.5rem; }
        .pf-hero-role {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.3rem 0.7rem;
            background: rgba(29,53,87,0.08);
            color: var(--cl-blue);
            border-radius: var(--radius-sm);
            font-size: 0.7rem; font-weight: 700;
            letter-spacing: 0.05em; text-transform: uppercase;
        }
        html.dark .pf-hero-role { background: rgba(29,53,87,0.2); color: #93bbfd; }
        .pf-avatar-hint {
            font-size: 0.72rem; color: var(--cl-muted);
            display: flex; align-items: center; gap: 0.3rem;
            margin-top: 0.5rem; margin-bottom: 0;
        }
        .pf-avatar-success {
            display: inline-block;
            margin-top: 0.4rem;
            font-size: 0.78rem;
            color: #1A8C38;
            font-weight: 600;
        }

        /* ─── Sections ─── */
        .pf-section {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.35s ease;
        }
        .pf-section--danger {
            border-color: rgba(230,57,70,0.12);
            background: var(--cl-red-soft);
        }
        html.dark .pf-section--danger {
            background: rgba(230,57,70,0.06);
            border-color: rgba(230,57,70,0.15);
        }
        .pf-section-head {
            display: flex; align-items: center; gap: 0.85rem;
            padding: 1.35rem 1.5rem 0;
        }
        .pf-section-icon {
            width: 42px; height: 42px;
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .pf-section-icon--blue { background: rgba(29,53,87,0.08); color: var(--cl-blue); }
        html.dark .pf-section-icon--blue { background: rgba(29,53,87,0.2); color: #93bbfd; }
        .pf-section-icon--orange { background: rgba(245,166,35,0.08); color: #B8860B; }
        .pf-section-icon--red { background: var(--cl-red-glow); color: var(--cl-red); }
        .pf-section-title {
            font-family: 'Inter', sans-serif;
            font-weight: 700; font-size: 0.95rem;
            color: var(--cl-dark);
            margin-bottom: 0.1rem;
        }
        .pf-section-title--red { color: var(--cl-red); }
        .pf-section-desc { font-size: 0.82rem; color: var(--cl-muted); margin: 0; }
        .pf-section-body { padding: 1.15rem 1.5rem 1.5rem; }

        /* ─── Form wrapper ─── */
        .pf-form-wrap form { max-width: 100%; }
        .pf-form-wrap input,
        .pf-form-wrap select,
        .pf-form-wrap textarea {
            width: 100%;
            border: 1.5px solid var(--cl-border) !important;
            border-radius: var(--radius-md) !important;
            padding: 0.6rem 0.85rem !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 0.88rem !important;
            color: var(--cl-dark) !important;
            background: var(--cl-light) !important;
            transition: all 0.25s ease !important;
            outline: none !important;
            box-shadow: none !important;
        }
        .pf-form-wrap input:focus,
        .pf-form-wrap select:focus,
        .pf-form-wrap textarea:focus {
            border-color: var(--cl-red) !important;
            box-shadow: 0 0 0 3px rgba(230,57,70,0.08) !important;
            background: var(--cl-card-bg) !important;
        }
        .pf-form-wrap input::placeholder,
        .pf-form-wrap textarea::placeholder { color: var(--cl-muted-light) !important; }
        .pf-form-wrap label {
            display: block;
            font-family: 'Inter', sans-serif !important;
            font-weight: 600 !important;
            font-size: 0.82rem !important;
            color: var(--cl-body) !important;
            margin-bottom: 0.35rem !important;
        }
        .pf-form-wrap .form-text,
        .pf-form-wrap small { font-size: 0.78rem !important; color: var(--cl-muted) !important; }
        .pf-form-wrap button[type="submit"] {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.6rem 1.4rem !important;
            font-family: 'Inter', sans-serif !important;
            font-weight: 600 !important;
            font-size: 0.84rem !important;
            border: none !important;
            border-radius: var(--radius-md) !important;
            cursor: pointer;
            transition: all 0.25s ease !important;
            outline: none !important;
            box-shadow: none !important;
            background: var(--cl-blue) !important;
            color: #fff !important;
            margin-top: 0.85rem !important;
        }
        .pf-form-wrap button[type="submit"]:hover {
            background: #2a4a7a !important;
            color: #fff !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(29,53,87,0.2) !important;
        }
        .pf-form-wrap .btn-danger,
        .pf-form-wrap button[class*="danger"],
        .pf-form-wrap button[class*="red"],
        .pf-section--danger .pf-form-wrap button[type="submit"] {
            background: var(--cl-red) !important;
            color: #fff !important;
        }
        .pf-form-wrap .btn-danger:hover,
        .pf-form-wrap button[class*="danger"]:hover,
        .pf-section--danger .pf-form-wrap button[type="submit"]:hover {
            background: var(--cl-red-hover) !important;
            color: #fff !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(230,57,70,0.25) !important;
        }

        /* ─── Responsive ─── */
        @media (max-width: 767.98px) {
            .pf-hero {
                flex-direction: column; text-align: center;
                padding: 1.5rem 1.25rem;
                border-radius: var(--radius-lg);
                box-shadow: none; border: none;
            }
            .pf-avatar-circle { width: 68px; height: 68px; font-size: 1.5rem; }
            .pf-avatar-hint { justify-content: center; }
            .pf-section {
                border-radius: var(--radius-lg);
                box-shadow: none; border: none;
                margin-bottom: 0.65rem;
            }
            .pf-section--danger { border: 1px solid rgba(230,57,70,0.15) !important; }
            .pf-section-head { padding: 1.15rem 1.15rem 0; }
            .pf-section-body { padding: 1rem 1.15rem 1.25rem; }
            .pf-form-wrap button[type="submit"] { width: 100%; justify-content: center; }
        }
    </style>

    <script>
        function submitAvatarForm(input) {
            if (!input.files || !input.files[0]) return;

            const file = input.files[0];

            // Aperçu immédiat
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                const letter = document.getElementById('avatarLetter');
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (letter) letter.style.display = 'none';
            };
            reader.readAsDataURL(file);

            // Soumettre le formulaire
            document.getElementById('avatarForm').submit();
        }
    </script>

</x-app-layout>
