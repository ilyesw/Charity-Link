<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Mes tâches
            </div>
            <h2 class="mb-0" style="font-size:1.5rem;">Mes missions</h2>
            <p class="header-sub mb-0">Suivez et gérez vos missions de bénévolat.</p>
        </div>
        <a href="{{ route('taches.index') }}" class="ls-header-btn ls-header-btn--ghost d-none d-md-inline-flex">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            Toutes les tâches
        </a>
    </x-slot>

    @if(session('success'))
        <div class="ls-flash ls-flash--success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="ls-count">
        <strong>{{ $taches->count() }}</strong> mission(s) assignée(s)
    </div>

    @if($taches->isEmpty())
        <div class="ls-empty-card">
            <div class="ls-empty-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <h5 class="ls-empty-title">Vous n'avez pas encore de missions</h5>
            <p class="ls-empty-desc">Parcourez les missions disponibles et postulez pour commencer.</p>
            <a href="{{ route('taches.index') }}" class="ls-empty-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Voir les missions disponibles
            </a>
        </div>
    @else
        <div class="ls-list">
            @foreach($taches as $tache)
                <div class="ls-card ls-card--vertical">
                    <div class="ls-card-body">

                        {{-- Header --}}
                        <div class="ls-card-top">
                            <div class="ls-card-avatar">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E63946" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <div class="ls-card-info">
                                <h6 class="ls-card-title">{{ $tache->title }}</h6>
                                <small class="ls-card-sub">{{ $tache->association->name }}</small>
                            </div>
                            @if($tache->status === 'en_cours')
                                <span class="ls-badge ls-badge--orange">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    En cours
                                </span>
                            @elseif($tache->status === 'validee')
                                <span class="ls-badge ls-badge--green">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    Validée
                                </span>
                            @endif
                        </div>

                        {{-- Description --}}
                        <p class="ls-card-desc">{{ $tache->description }}</p>

                        {{-- Tags --}}
                        <div class="ls-card-tags">
                            @if($tache->competence_requise)
                                <span class="ls-tag">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--cl-red)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    {{ $tache->competence_requise }}
                                </span>
                            @endif
                            @if($tache->deadline)
                                <span class="ls-tag">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    {{ $tache->deadline->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>

                        {{-- Compte rendu déja soumis --}}
                        @if($tache->compte_rendu)
                            <div class="ls-report-block">
                                <div class="ls-report-head">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--cl-green)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    Compte rendu soumis
                                </div>
                                <p class="ls-report-text">{{ $tache->compte_rendu }}</p>
                            </div>
                        @endif

                        {{-- Formulaire compte rendu --}}
                        @if($tache->status === 'en_cours' && !$tache->compte_rendu)
                            <div class="ls-report-form">
                                <div class="ls-report-form-head">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#E63946" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                    Soumettre un compte rendu
                                </div>
                                <form method="POST" action="{{ route('taches.compte_rendu', $tache) }}">
                                    @csrf
                                    <div class="fm-group">
                                        <label class="fm-label">Compte rendu</label>
                                        <textarea name="compte_rendu" class="fm-input fm-textarea" rows="3"
                                            placeholder="Décrivez ce que vous avez accompli..." required></textarea>
                                    </div>
                                    <div class="fm-group">
                                        <label class="fm-label">Feedback <span class="fm-section-optional">optionnel</span></label>
                                        <textarea name="feedback" class="fm-input fm-textarea" rows="2"
                                            placeholder="Vos remarques ou suggestions..."></textarea>
                                    </div>
                                    <button type="submit" class="fm-btn fm-btn--red fm-btn--sm">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                        Soumettre
                                    </button>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    @endif

</x-app-layout>

<style>
    .ls-flash {
        display: flex; align-items: center; gap: 0.6rem;
        padding: 0.75rem 1rem;
        border-radius: var(--radius-md);
        font-size: 0.84rem; font-weight: 500;
        margin-bottom: 1.25rem;
        animation: ls-slideDown 0.3s ease;
    }
    .ls-flash svg { flex-shrink: 0; }
    .ls-flash--success { background: var(--cl-green-soft); color: #1A8C38; border: 1px solid rgba(45,198,83,0.15); }
    .ls-flash--error { background: var(--cl-red-soft); color: var(--cl-red); border: 1px solid rgba(230,57,70,0.15); }
    @keyframes ls-slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

    .ls-header-btn {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.5rem 1rem;
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.82rem;
        border-radius: var(--radius-md);
        text-decoration: none; cursor: pointer;
        transition: all 0.25s ease;
        border: 1.5px solid var(--cl-border);
        color: var(--cl-muted);
        background: var(--cl-card-bg);
    }
    .ls-header-btn:hover { color: var(--cl-dark); border-color: var(--cl-muted); background: var(--cl-light); }
    .ls-header-btn--red { background: var(--cl-red); color: #fff; border-color: var(--cl-red); }
    .ls-header-btn--red:hover { background: var(--cl-red-hover); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(230,57,70,0.3); }

    .ls-count {
        font-size: 0.85rem; color: var(--cl-muted);
        margin-bottom: 1.25rem;
    }
    .ls-count strong { color: var(--cl-dark); font-weight: 700; }

    .ls-empty-card {
        text-align: center; padding: 3rem 2rem;
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
    }
    .ls-empty-icon {
        width: 72px; height: 72px;
        background: var(--cl-light);
        border-radius: var(--radius-lg);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.25rem;
    }
    .ls-empty-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1rem; color: var(--cl-dark); margin-bottom: 0.4rem; }
    .ls-empty-desc { font-size: 0.85rem; color: var(--cl-muted); margin-bottom: 1.25rem; }
    .ls-empty-btn {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.6rem 1.4rem;
        background: var(--cl-red); color: #fff;
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.84rem;
        border-radius: var(--radius-md);
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(230,57,70,0.2);
        transition: all 0.25s ease;
    }
    .ls-empty-btn:hover { background: var(--cl-red-hover); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(230,57,70,0.3); }

    .ls-list { display: flex; flex-direction: column; gap: 0.85rem; }

    .ls-card {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xs);
        transition: all 0.25s ease;
    }
    .ls-card:hover { box-shadow: var(--shadow-md); border-color: transparent; }
    .ls-card-body { padding: 1.25rem 1.35rem; }

    .ls-card-top { display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 0.85rem; }
    .ls-card-avatar {
        width: 42px; height: 42px;
        background: var(--cl-red-glow);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .ls-card-info { flex: 1; min-width: 0; }
    .ls-card-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.92rem; color: var(--cl-dark); margin-bottom: 0.1rem; }
    .ls-card-sub { font-size: 0.8rem; color: var(--cl-muted); }

    .ls-badge {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.3rem 0.7rem;
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.72rem;
        border-radius: var(--radius-full);
        flex-shrink: 0;
    }
    .ls-badge--green { background: var(--cl-green-soft); color: #1A8C38; }
    .ls-badge--orange { background: rgba(245,166,35,0.1); color: #B8860B; }

    .ls-card-desc { font-size: 0.85rem; color: var(--cl-muted); line-height: 1.65; margin-bottom: 0.85rem; }

    .ls-card-tags { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.5rem; }
    .ls-tag {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.3rem 0.65rem;
        background: var(--cl-light);
        border: 1px solid var(--cl-border);
        border-radius: var(--radius-full);
        font-size: 0.78rem; font-weight: 500;
        color: var(--cl-body);
    }
    .ls-tag svg { flex-shrink: 0; }

    .ls-report-block {
        margin-top: 1rem;
        padding: 0.85rem 1rem;
        background: var(--cl-green-soft);
        border: 1px solid rgba(45,198,83,0.15);
        border-radius: var(--radius-md);
    }
    .ls-report-head {
        display: flex; align-items: center; gap: 0.4rem;
        font-size: 0.8rem; font-weight: 700; color: #1A8C38;
        margin-bottom: 0.4rem;
    }
    .ls-report-text { font-size: 0.82rem; color: var(--cl-body); line-height: 1.6; margin: 0; }

    .ls-report-form {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--cl-border);
    }
    .ls-report-form-head {
        display: flex; align-items: center; gap: 0.5rem;
        font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.85rem;
        color: var(--cl-dark);
        margin-bottom: 0.85rem;
    }

    .fm-group { margin-bottom: 0.85rem; }
    .fm-group:last-child { margin-bottom: 0; }
    .fm-label { display: block; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.8rem; color: var(--cl-body); margin-bottom: 0.35rem; }
    .fm-section-optional { font-weight: 400; font-size: 0.78rem; color: var(--cl-muted-light); margin-left: 0.3rem; }

    .fm-input {
        width: 100%; padding: 0.55rem 0.8rem;
        font-family: 'Inter', sans-serif; font-size: 0.84rem;
        color: var(--cl-dark); background: var(--cl-light);
        border: 1.5px solid var(--cl-border);
        border-radius: var(--radius-md);
        outline: none !important; box-shadow: none !important;
        transition: all 0.25s ease;
    }
    .fm-input:focus { border-color: var(--cl-red) !important; box-shadow: 0 0 0 3px rgba(230,57,70,0.08) !important; background: var(--cl-card-bg); }
    .fm-input::placeholder { color: var(--cl-muted-light); }
    .fm-textarea { resize: vertical; min-height: 70px; }

    .fm-btn {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.6rem 1.4rem;
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.84rem;
        border-radius: var(--radius-md);
        text-decoration: none; cursor: pointer;
        transition: all 0.25s ease;
        border: none !important; outline: none !important; box-shadow: none !important;
    }
    .fm-btn--red { background: var(--cl-red); color: #fff; box-shadow: 0 2px 8px rgba(230,57,70,0.2); }
    .fm-btn--red:hover { background: var(--cl-red-hover); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(230,57,70,0.28) !important; }
    .fm-btn--sm { padding: 0.45rem 1rem; font-size: 0.8rem; }

    @media (max-width: 767.98px) {
        .ls-card-body { padding: 1rem; }
        .ls-empty-card { padding: 2rem 1.25rem; border-radius: var(--radius-lg); box-shadow: none; border: none; }
        .ls-card-top { flex-wrap: wrap; }
        .ls-badge { margin-left: auto; }
    }
</style>
