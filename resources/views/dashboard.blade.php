<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label"><i class="bi bi-grid-1x2-fill"></i> Dashboard</div>
            <h2 class="mb-0" style="font-size:1.5rem; letter-spacing:-0.02em;">Tableau de bord</h2>
            <p class="header-sub mb-0">
                @php $user = auth()->user(); @endphp
                @if($user->isDonateur())
                    Résumé de vos contributions solidaires
                @elseif($user->isAssociation())
                    Gestion de vos besoins et demandes
                @elseif($user->isAdmin())
                    Supervision de la plateforme
                @elseif($user->isBenevole())
                    Vos missions et disponibilités
                @else
                    Espace utilisateur
                @endif
            </p>
        </div>
    </x-slot>

    @php $user = auth()->user(); @endphp

    {{-- ═══ DONATEUR ═══ --}}
    @if($user->isDonateur())
        <div class="db-content">
            @include('dashboard.donateur')
        </div>

    {{-- ═══ ASSOCIATION ═══ --}}
    @elseif($user->isAssociation())
        <div class="db-content">
            @include('dashboard.association')
        </div>

    {{-- ═══ ADMIN ═══ --}}
    @elseif($user->isAdmin())
        <div class="db-content">
            @include('dashboard.admin')
        </div>

    {{-- ═══ BÉNÉVOLE ═══ --}}
    @elseif($user->isBenevole())
        <div class="db-content">
            @include('dashboard.benevole')
        </div>

    {{-- ═══ FALLBACK ═══ --}}
    @else
        <div class="db-content db-content--center">
            <div class="db-fallback">
                <div class="db-fallback-icon">
                    <i class="bi bi-hand-wave"></i>
                </div>
                <h3 class="db-fallback-title">Bienvenue sur CharityLink</h3>
                <p class="db-fallback-text">
                    Votre compte n'a pas encore de rôle assigné.
                    Contactez un administrateur pour accéder à votre espace.
                </p>
                <a href="{{ route('home') }}" class="db-fallback-btn">
                    <i class="bi bi-house-fill"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    @endif

</x-app-layout>

<style>
    /* ════════════════ CONTENT WRAPPER ════════════════ */
    .db-content {
        padding: 1.5rem 0 3rem;
        animation: db-fade-in 0.4s ease both;
    }
    .db-content--center {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 220px);
        padding: 2rem 1rem;
    }
    @keyframes db-fade-in {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ════════════════ FALLBACK CARD ════════════════ */
    .db-fallback {
        max-width: 400px;
        width: 100%;
        text-align: center;
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl);
        padding: 2.75rem 2rem;
        box-shadow: var(--shadow-md);
        transition: all 0.35s ease;
    }

    /* Icon */
    .db-fallback-icon {
        width: 68px; height: 68px;
        border-radius: var(--radius-lg);
        background: var(--cl-red-glow);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(230,57,70,0.06);
        transition: all 0.35s ease;
    }
    .db-fallback-icon i {
        font-size: 1.65rem;
        color: var(--cl-red);
    }

    /* Title */
    .db-fallback-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--cl-dark);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        transition: color 0.35s ease;
    }

    /* Text */
    .db-fallback-text {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: var(--cl-muted);
        line-height: 1.7;
        margin-bottom: 1.75rem;
        transition: color 0.35s ease;
    }

    /* Button */
    .db-fallback-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.5rem;
        background: var(--cl-red);
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.82rem;
        border-radius: var(--radius-md);
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(230,57,70,0.2);
    }
    .db-fallback-btn i { font-size: 0.85rem; }
    .db-fallback-btn:hover {
        background: var(--cl-red-hover);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(230,57,70,0.28);
        text-decoration: none;
    }
    .db-fallback-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(230,57,70,0.2);
    }

    /* ════════════════ RESPONSIVE ════════════════ */
    @media (max-width: 575.98px) {
        .db-content {
            padding: 1rem 0 2rem;
        }
        .db-content--center {
            min-height: calc(100vh - 180px);
            padding: 1rem 0.75rem;
        }
        .db-fallback {
            padding: 2rem 1.5rem;
            border-radius: var(--radius-lg);
        }
        .db-fallback-icon {
            width: 60px; height: 60px;
            border-radius: var(--radius-md);
        }
        .db-fallback-icon i { font-size: 1.4rem; }
        .db-fallback-title { font-size: 1.15rem; }
    }
</style>
