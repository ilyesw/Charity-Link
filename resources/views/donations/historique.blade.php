<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                Historique
            </div>
            <h2 class="mb-0" style="font-size:1.5rem;">Mes dons</h2>
            <p class="header-sub mb-0">Retrouvez toutes vos contributions passées.</p>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="ls-flash ls-flash--success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($donations->isEmpty())
        <div class="ls-empty-card">
            <div class="ls-empty-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <h5 class="ls-empty-title">Vous n'avez pas encore effectué de don</h5>
            <p class="ls-empty-desc">Explorez les campagnes actives et faites votre premier geste solidaire.</p>
            <a href="{{ route('campaigns.index') }}" class="ls-empty-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Voir les campagnes
            </a>
        </div>
    @else
        <div class="ls-count">
            <strong>{{ $donations->total() }}</strong> don(s) effectué(s)
        </div>

        <div class="ls-list">
            @foreach($donations as $donation)
                <div class="ls-card ls-card--vertical">
                    <div class="ls-card-body">
                        <div class="ls-card-top">

                            {{-- Icône type --}}
                            <div class="ls-card-avatar @if($donation->type === 'financier') ls-card-avatar--finance @elseif($donation->type === 'nature') ls-card-avatar--nature @else ls-card-avatar--skill @endif">
                                @if($donation->type === 'financier')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                @elseif($donation->type === 'nature')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                                @else
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                @endif
                            </div>

                            <div class="ls-card-info">
                                <div class="ls-card-badges">
                                    @if($donation->type === 'financier')
                                        <span class="ls-tag ls-tag--red">Financier</span>
                                    @elseif($donation->type === 'nature')
                                        <span class="ls-tag ls-tag--red">En nature</span>
                                    @else
                                        <span class="ls-tag ls-tag--red">Compétences</span>
                                    @endif
                                </div>
                                <h6 class="ls-card-title">{{ $donation->campaign->title }}</h6>
                                <small class="ls-card-sub">{{ $donation->campaign->association->name }}</small>
                            </div>

                            {{-- ✅ Statut + Date --}}
                            <div class="ls-card-meta">
                                @if($donation->status === 'confirme')
                                    <span class="ls-badge ls-badge--green">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        Confirmé
                                    </span>
                                @elseif($donation->status === 'annule')
                                    <span class="ls-badge ls-badge--red">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                        Refusé
                                    </span>
                                @else
                                    <span class="ls-badge ls-badge--orange">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        En attente
                                    </span>
                                @endif
                                <div class="ls-card-date">{{ $donation->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>

                        {{-- Détails --}}
                        <div class="ls-card-details">
                            @if($donation->type === 'financier')
                                <span class="ls-amount">{{ number_format($donation->amount, 0) }} DT</span>
                            @elseif($donation->type === 'nature')
                                <div class="ls-detail-row">
                                    <span class="ls-detail-item">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                                        {{ ucfirst($donation->category) }} — {{ $donation->quantity }} unité(s)
                                    </span>
                                    <span class="ls-detail-item">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                        {{ $donation->pickup_address }}
                                    </span>
                                </div>
                            @else
                                <div class="ls-detail-row">
                                    <span class="ls-detail-item">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                        {{ $donation->competence }}
                                    </span>
                                    <span class="ls-detail-item">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        {{ $donation->availability }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Message --}}
                        @if($donation->message)
                            <div class="ls-card-quote">
                                "{{ $donation->message }}"
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>

        <div class="ls-pagination">
            {{ $donations->links('pagination::bootstrap-5') }}
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

    .ls-count { font-size: 0.85rem; color: var(--cl-muted); margin-bottom: 1.25rem; }
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

    .ls-card-top { display: flex; align-items: flex-start; gap: 0.85rem; }

    .ls-card-avatar {
        width: 48px; height: 48px;
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .ls-card-avatar--finance { background: rgba(230,57,70,0.08); color: var(--cl-red); }
    .ls-card-avatar--nature  { background: rgba(45,198,83,0.08);  color: var(--cl-green); }
    .ls-card-avatar--skill   { background: rgba(29,53,87,0.08);   color: var(--cl-blue); }
    html.dark .ls-card-avatar--skill { color: #93bbfd; }

    .ls-card-info { flex: 1; min-width: 0; }
    .ls-card-badges { margin-bottom: 0.3rem; }
    .ls-card-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.92rem; color: var(--cl-dark); margin-bottom: 0.1rem; }
    .ls-card-sub { font-size: 0.8rem; color: var(--cl-muted); }

    .ls-card-meta { text-align: right; flex-shrink: 0; }
    .ls-card-date { font-size: 0.78rem; color: var(--cl-muted); margin-top: 0.4rem; }

    .ls-badge {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.3rem 0.7rem;
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.72rem;
        border-radius: var(--radius-full);
    }
    .ls-badge--green  { background: var(--cl-green-soft);          color: #1A8C38; }
    .ls-badge--orange { background: rgba(245,166,35,0.1);           color: #B8860B; }
    .ls-badge--red    { background: var(--cl-red-soft);             color: var(--cl-red); }

    .ls-tag {
        display: inline-flex; align-items: center; gap: 0.3rem;
        padding: 0.2rem 0.6rem;
        border-radius: var(--radius-full);
        font-size: 0.72rem; font-weight: 600;
    }
    .ls-tag--red { background: var(--cl-red-glow); color: var(--cl-red); }

    .ls-card-details { margin-top: 0.75rem; }

    .ls-amount {
        font-family: 'Inter', sans-serif;
        font-weight: 800; font-size: 1.15rem;
        color: var(--cl-red);
    }

    .ls-detail-row { display: flex; flex-wrap: wrap; gap: 0.85rem; }
    .ls-detail-item {
        display: inline-flex; align-items: center; gap: 0.35rem;
        font-size: 0.82rem; color: var(--cl-muted);
    }
    .ls-detail-item svg { flex-shrink: 0; }

    .ls-card-quote {
        margin-top: 0.75rem;
        padding: 0.6rem 0.85rem;
        background: var(--cl-light);
        border-left: 3px solid var(--cl-border);
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        font-size: 0.82rem; font-style: italic;
        color: var(--cl-muted); line-height: 1.6;
    }

    .ls-pagination { margin-top: 1.5rem; }
    .ls-pagination .pagination .page-link {
        border-radius: var(--radius-sm) !important;
        margin: 0 2px;
        border: 1px solid var(--cl-border) !important;
        color: var(--cl-body) !important;
        font-weight: 500; font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        background: var(--cl-card-bg) !important;
        transition: all 0.2s ease;
    }
    .ls-pagination .pagination .page-link:hover {
        background: var(--cl-light) !important;
        border-color: var(--cl-muted) !important;
        color: var(--cl-dark) !important;
    }
    .ls-pagination .pagination .page-item.active .page-link {
        background: var(--cl-red) !important;
        border-color: var(--cl-red) !important;
        color: #fff !important;
    }

    @media (max-width: 767.98px) {
        .ls-card-body { padding: 1rem; }
        .ls-empty-card { padding: 2rem 1.25rem; border-radius: var(--radius-lg); box-shadow: none; border: none; }
        .ls-card-top { flex-wrap: wrap; }
        .ls-card-meta { width: 100%; display: flex; align-items: center; justify-content: space-between; margin-top: 0.5rem; padding-top: 0.75rem; border-top: 1px solid var(--cl-border); }
        .ls-card-date { margin-top: 0; }
        .ls-detail-row { flex-direction: column; gap: 0.5rem; }
    }
</style>
