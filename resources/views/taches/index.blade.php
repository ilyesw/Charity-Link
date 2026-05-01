<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label"><i class="bi bi-people-fill"></i> Bénévolat</div>
            <h2 class="mb-0" style="font-size:1.5rem;">Missions disponibles</h2>
            <p class="header-sub mb-0">Trouvez des missions adaptées à vos compétences.</p>
        </div>
        <div class="d-none d-md-flex gap-2">
            @auth
                @if(auth()->user()->isAssociation())
                    <a href="{{ route('taches.create') }}" class="ls-header-btn ls-header-btn--red">
                        <i class="bi bi-plus-lg"></i> Créer une tâche
                    </a>
                @endif
                @if(auth()->user()->isBenevole())
                    <a href="{{ route('taches.mes_taches') }}" class="ls-header-btn ls-header-btn--ghost">
                        Mes tâches <i class="bi bi-arrow-right"></i>
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="ls-flash ls-flash--success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="ls-flash ls-flash--error">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Mobile actions --}}
    @auth
        <div class="d-flex d-md-none gap-2 mb-3">
            @if(auth()->user()->isAssociation())
                <a href="{{ route('taches.create') }}" class="ls-header-btn ls-header-btn--red ls-header-btn--full">
                    <i class="bi bi-plus-lg"></i> Créer
                </a>
            @endif
            @if(auth()->user()->isBenevole())
                <a href="{{ route('taches.mes_taches') }}" class="ls-header-btn ls-header-btn--ghost ls-header-btn--full">
                    Mes tâches <i class="bi bi-arrow-right"></i>
                </a>
            @endif
        </div>
    @endauth

    {{-- Count --}}
    <div class="ls-count">
        <strong>{{ $taches->total() }}</strong> tâche(s) disponible(s)
    </div>

    @if($taches->isEmpty())
        <div class="ls-empty-card">
            <div class="ls-empty-icon">
                <i class="bi bi-people"></i>
            </div>
            <h3 class="ls-empty-title">Aucune tâche disponible</h3>
            <p class="ls-empty-text">Revenez bientôt, de nouvelles missions apparaîtront prochainement.</p>
        </div>
    @else
        <div class="ls-grid">
            @foreach($taches as $tache)
                <div class="ls-card">
                    <div class="ls-card-top">
                        <div class="ls-card-info">
                            <div class="ls-card-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <div class="ls-card-title">{{ $tache->title }}</div>
                                <div class="ls-card-meta">{{ $tache->association->name }}</div>
                            </div>
                        </div>
                        <span class="ls-badge ls-badge--green">Ouverte</span>
                    </div>

                    <p class="ls-card-desc">
                        {{ Str::limit($tache->description, 120) }}
                    </p>

                    <div class="ls-card-tags">
                        <span class="ls-tag ls-tag--red">
                            <i class="bi bi-bullseye"></i> {{ $tache->competence_requise }}
                        </span>
                        @if($tache->deadline)
                            <span class="ls-tag ls-tag--muted">
                                <i class="bi bi-clock"></i> {{ $tache->deadline->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>

                    <div class="ls-card-actions">
                        @auth
                            @if(auth()->user()->isBenevole())
                                <form method="POST" action="{{ route('taches.postuler', $tache) }}">
                                    @csrf
                                    <button type="submit" class="ls-btn ls-btn--red ls-btn--full">
                                        <i class="bi bi-hand-thumbs-up-fill"></i> Je prends cette tâche
                                    </button>
                                </form>
                            @elseif(auth()->user()->isAssociation() && $tache->association->user_id === auth()->id())
                                <a href="{{ route('taches.edit', $tache) }}" class="ls-btn ls-btn--ghost ls-btn--full">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                            @else
                                <span></span>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="ls-btn ls-btn--outline ls-btn--full">
                                <i class="bi bi-box-arrow-in-right"></i> Connectez-vous pour postuler
                            </a>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="ls-pagination">
            {{ $taches->links('pagination::bootstrap-5') }}
        </div>
    @endif
</x-app-layout>

<style>
    /* ════════════════ FLASH MESSAGES ════════════════ */
    .ls-flash {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1.1rem;
        border-radius: var(--radius-md);
        margin-bottom: 1.25rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.84rem;
        font-weight: 500;
        animation: ls-fade-in 0.35s ease;
    }
    .ls-flash i { font-size: 1rem; flex-shrink: 0; }
    .ls-flash--success {
        background: var(--cl-green-glow);
        border: 1px solid rgba(45,198,83,0.15);
        color: var(--cl-green);
    }
    .ls-flash--error {
        background: var(--cl-red-glow);
        border: 1px solid rgba(230,57,70,0.15);
        color: var(--cl-red);
    }
    @keyframes ls-fade-in {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ════════════════ HEADER BUTTONS ════════════════ */
    .ls-header-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 0.9rem;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.78rem;
        border-radius: var(--radius-full);
        text-decoration: none;
        transition: all 0.2s ease;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }
    .ls-header-btn:focus {
        outline: none !important;
        box-shadow: none !important;
    }
    .ls-header-btn i { font-size: 0.82rem; }
    .ls-header-btn--red {
        background: var(--cl-red);
        color: #fff;
    }
    .ls-header-btn--red:hover {
        background: var(--cl-red-hover);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(230,57,70,0.22) !important;
        text-decoration: none;
    }
    .ls-header-btn--ghost {
        background: transparent;
        color: var(--cl-red);
        border: 1.5px solid var(--cl-red) !important;
    }
    .ls-header-btn--ghost:hover {
        background: var(--cl-red-glow);
        color: var(--cl-red);
        text-decoration: none;
    }
    .ls-header-btn--full {
        flex: 1;
        justify-content: center;
    }

    /* ════════════════ COUNT ════════════════ */
    .ls-count {
        font-size: 0.85rem;
        color: var(--cl-muted);
        margin-bottom: 1.25rem;
        font-family: 'Inter', sans-serif;
        transition: color 0.35s ease;
    }
    .ls-count strong {
        color: var(--cl-dark);
        font-weight: 700;
        transition: color 0.35s ease;
    }

    /* ════════════════ EMPTY STATE ════════════════ */
    .ls-empty-card {
        max-width: 420px;
        margin: 2rem auto 0;
        text-align: center;
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl);
        padding: 3rem 2rem;
        box-shadow: var(--shadow-md);
        transition: all 0.35s ease;
    }
    .ls-empty-icon {
        width: 68px; height: 68px;
        border-radius: var(--radius-lg);
        background: var(--cl-blue-mid);
        display: inline-flex; align-items: center; justify-content: center;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(29,53,87,0.06);
        transition: all 0.35s ease;
    }
    .ls-empty-icon i { font-size: 1.65rem; color: var(--cl-blue); }
    .ls-empty-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700; font-size: 1.2rem;
        color: var(--cl-dark);
        margin-bottom: 0.4rem;
        transition: color 0.35s ease;
    }
    .ls-empty-text {
        font-size: 0.84rem; color: var(--cl-muted);
        line-height: 1.65; margin-bottom: 0;
        transition: color 0.35s ease;
    }

    /* ════════════════ GRID ════════════════ */
    .ls-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    /* ════════════════ CARD ════════════════ */
    .ls-card {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-lg);
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        transition: all 0.25s ease;
        box-shadow: var(--shadow-xs);
    }
    .ls-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    /* Card Top */
    .ls-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 0.85rem;
    }
    .ls-card-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 0;
    }
    .ls-card-icon {
        width: 42px; height: 42px;
        background: var(--cl-red-glow);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: background 0.35s ease;
    }
    .ls-card-icon i { font-size: 1.05rem; color: var(--cl-red); }
    .ls-card-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--cl-dark);
        line-height: 1.3;
        transition: color 0.35s ease;
    }
    .ls-card-meta {
        font-size: 0.78rem;
        color: var(--cl-muted);
        margin-top: 0.15rem;
        transition: color 0.35s ease;
    }

    /* Card Description */
    .ls-card-desc {
        font-size: 0.82rem;
        color: var(--cl-muted);
        line-height: 1.6;
        margin-bottom: 0.85rem;
        flex-grow: 0;
        transition: color 0.35s ease;
    }

    /* Card Tags */
    .ls-card-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .ls-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.28rem 0.6rem;
        border-radius: var(--radius-full);
        font-size: 0.72rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        transition: all 0.35s ease;
    }
    .ls-tag i { font-size: 0.74rem; }
    .ls-tag--red {
        background: var(--cl-red-glow);
        color: var(--cl-red);
    }
    .ls-tag--muted {
        background: var(--cl-light);
        border: 1px solid var(--cl-border);
        color: var(--cl-muted);
    }

    /* Card Actions */
    .ls-card-actions {
        margin-top: auto;
        padding-top: 0.85rem;
        border-top: 1px solid var(--cl-border);
        transition: border-color 0.35s ease;
    }

    /* ════════════════ BADGES ════════════════ */
    .ls-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.22rem 0.6rem;
        border-radius: var(--radius-full);
        font-size: 0.68rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        flex-shrink: 0;
        transition: all 0.35s ease;
    }
    .ls-badge--green { background: var(--cl-green-glow); color: var(--cl-green); }
    .ls-badge--orange { background: rgba(245,166,35,0.1); color: #D4940A; }
    .ls-badge--red { background: var(--cl-red-glow); color: var(--cl-red); }
    .ls-badge--muted { background: var(--cl-light); border: 1px solid var(--cl-border); color: var(--cl-muted); }

    /* ════════════════ BUTTONS ════════════════ */
    .ls-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.8rem;
        border-radius: var(--radius-md);
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }
    .ls-btn:focus {
        outline: none !important;
        box-shadow: none !important;
    }
    .ls-btn i { font-size: 0.85rem; }
    .ls-btn--full { width: 100%; }
    .ls-btn--red {
        background: var(--cl-red); color: #fff;
        box-shadow: 0 2px 8px rgba(230,57,70,0.15);
    }
    .ls-btn--red:hover {
        background: var(--cl-red-hover); color: #fff;
        box-shadow: 0 4px 12px rgba(230,57,70,0.25) !important;
        text-decoration: none;
    }
    .ls-btn--ghost {
        background: var(--cl-light); color: var(--cl-muted);
        border: 1px solid var(--cl-border) !important;
    }
    .ls-btn--ghost:hover {
        color: var(--cl-dark); border-color: var(--cl-muted) !important;
        text-decoration: none;
    }
    .ls-btn--outline {
        background: transparent; color: var(--cl-red);
        border: 1.5px solid var(--cl-red) !important;
    }
    .ls-btn--outline:hover {
        background: var(--cl-red-glow); color: var(--cl-red);
        text-decoration: none;
    }

    /* ════════════════ PAGINATION ════════════════ */
    .ls-pagination {
        margin-top: 1.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: center;
    }
    .ls-pagination .page-link {
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        font-weight: 500;
        color: var(--cl-body);
        border: 1px solid var(--cl-border);
        border-radius: var(--radius-sm) !important;
        padding: 0.4rem 0.75rem;
        margin: 0 0.15rem;
        transition: all 0.2s ease;
        background: var(--cl-card-bg);
    }
    .ls-pagination .page-link:hover {
        background: var(--cl-red-glow);
        color: var(--cl-red);
        border-color: rgba(230,57,70,0.2);
        z-index: 0;
    }
    .ls-pagination .page-item.active .page-link {
        background: var(--cl-red);
        color: #fff;
        border-color: var(--cl-red);
        box-shadow: 0 2px 6px rgba(230,57,70,0.2);
    }
    .ls-pagination .page-item.disabled .page-link {
        background: var(--cl-light);
        color: var(--cl-muted-light);
        border-color: var(--cl-border);
    }

    /* ════════════════ RESPONSIVE ════════════════ */
    @media (max-width: 991.98px) {
        .ls-grid { gap: 0.85rem; }
    }
    @media (max-width: 767.98px) {
        .ls-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        .ls-card {
            border-radius: var(--radius-md);
            border: none;
            box-shadow: var(--shadow-xs);
        }
        .ls-card:hover {
            transform: none;
            box-shadow: var(--shadow-sm);
        }
        .ls-empty-card {
            margin: 1rem 0 0;
            padding: 2.5rem 1.5rem;
            border-radius: var(--radius-lg);
            box-shadow: none;
            border: none;
        }
    }
    @media (max-width: 575.98px) {
        .ls-card { padding: 1rem; }
        .ls-card-icon { width: 38px; height: 38px; }
        .ls-card-icon i { font-size: 0.95rem; }
        .ls-card-title { font-size: 0.88rem; }
    }
</style>
