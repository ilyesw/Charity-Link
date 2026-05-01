<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Administration
            </div>
            <h2 class="mb-0" style="font-size:1.5rem;">Panel Administrateur</h2>
            <p class="header-sub mb-0">Gestion des associations et validation des profils.</p>
        </div>
        <div class="ad-admin-badge">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            ADMIN
        </div>
    </x-slot>

    @if(session('success'))
        <div class="ls-flash ls-flash--success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="ad-stats-grid">
        <div class="ad-stat-card">
            <div class="ad-stat-icon ad-stat-icon--blue">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="ad-stat-num">{{ $stats['total_users'] }}</div>
            <div class="ad-stat-label">Utilisateurs</div>
        </div>

        <div class="ad-stat-card">
            <div class="ad-stat-icon ad-stat-icon--blue">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
            </div>
            <div class="ad-stat-num">{{ $stats['total_associations'] }}</div>
            <div class="ad-stat-label">Associations</div>
        </div>

        <div class="ad-stat-card">
            <div class="ad-stat-icon ad-stat-icon--orange">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="ad-stat-num ad-stat-num--orange">{{ $stats['en_attente'] }}</div>
            <div class="ad-stat-label">En attente</div>
        </div>

        <div class="ad-stat-card">
            <div class="ad-stat-icon ad-stat-icon--green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="ad-stat-num ad-stat-num--green">{{ $stats['validees'] }}</div>
            <div class="ad-stat-label">Validées</div>
        </div>
    </div>

    {{-- Associations en attente --}}
    <div class="ad-pending-card">
        <div class="ad-pending-head">
            <div class="ad-pending-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#B8860B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Associations en attente de validation
            </div>
            @if($associations_en_attente->count() > 0)
                <span class="ad-pending-count">{{ $associations_en_attente->count() }}</span>
            @endif
        </div>

        @if($associations_en_attente->isEmpty())
            <div class="ad-pending-empty">
                <div class="ad-pending-empty-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--cl-green)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <p class="ad-pending-empty-text">Aucune association en attente !</p>
            </div>
        @else
            <div class="ad-pending-list">
                @foreach($associations_en_attente as $association)
                    <div class="ad-pending-item">
                        <div class="ad-pending-info">
                            <h6 class="ad-pending-name">{{ $association->name }}</h6>
                            <div class="ad-pending-meta">
                                <span class="ad-pending-tag">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $association->region }} — {{ ucfirst($association->category) }}
                                </span>
                            </div>
                            <p class="ad-pending-desc">{{ Str::limit($association->description, 120) }}</p>
                            <div class="ad-pending-user">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                {{ $association->user->name }} ({{ $association->user->email }})
                            </div>
                        </div>

                        <div class="ad-pending-actions">
                            <form method="POST" action="{{ route('admin.associations.valider', $association) }}">
                                @csrf
                                <button type="submit" class="ad-btn ad-btn--green">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    Valider
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.associations.rejeter', $association) }}" class="ad-reject-form">
                                @csrf
                                <div class="ad-reject-row">
                                    <input type="text" name="rejection_reason"
                                        placeholder="Motif du rejet..."
                                        class="ad-reject-input" required />
                                    <button type="submit" class="ad-btn ad-btn--red-icon" title="Rejeter">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

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
    @keyframes ls-slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

    /* ─── Admin badge ─── */
    .ad-admin-badge {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.4rem 0.9rem;
        background: var(--cl-dark);
        color: #FBBF24;
        border-radius: var(--radius-full);
        font-family: 'Inter', sans-serif;
        font-size: 0.72rem; font-weight: 700;
        letter-spacing: 0.05em;
    }
    html.dark .ad-admin-badge { background: rgba(251,191,36,0.12); color: #FBBF24; border: 1px solid rgba(251,191,36,0.2); }

    /* ─── Stats grid ─── */
    .ad-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.85rem;
        margin-bottom: 1.5rem;
    }
    .ad-stat-card {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-lg);
        padding: 1.35rem 1rem;
        text-align: center;
        box-shadow: var(--shadow-xs);
        transition: all 0.25s ease;
    }
    .ad-stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .ad-stat-icon {
        width: 44px; height: 44px;
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 0.75rem;
    }
    .ad-stat-icon--blue { background: rgba(29,53,87,0.08); color: var(--cl-blue); }
    html.dark .ad-stat-icon--blue { background: rgba(29,53,87,0.2); color: #93bbfd; }
    .ad-stat-icon--orange { background: rgba(245,166,35,0.08); color: #B8860B; }
    .ad-stat-icon--green { background: var(--cl-green-soft); color: #1A8C38; }
    .ad-stat-num {
        font-family: 'Inter', sans-serif;
        font-weight: 800; font-size: 1.5rem;
        color: var(--cl-dark);
        line-height: 1.2;
    }
    .ad-stat-num--orange { color: #B8860B; }
    .ad-stat-num--green { color: #1A8C38; }
    .ad-stat-label {
        font-size: 0.8rem; color: var(--cl-muted);
        font-weight: 500; margin-top: 0.2rem;
    }

    /* ─── Pending card ─── */
    .ad-pending-card {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
    }
    .ad-pending-head {
        display: flex; align-items: center; gap: 0.75rem;
        margin-bottom: 1.25rem;
    }
    .ad-pending-title {
        display: flex; align-items: center; gap: 0.5rem;
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.95rem;
        color: var(--cl-dark);
    }
    .ad-pending-count {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 24px; height: 24px;
        padding: 0 6px;
        background: var(--cl-red);
        color: #fff;
        border-radius: var(--radius-full);
        font-size: 0.72rem; font-weight: 700;
    }

    /* Empty state */
    .ad-pending-empty {
        text-align: center; padding: 2.5rem 1rem;
    }
    .ad-pending-empty-icon {
        width: 56px; height: 56px;
        background: var(--cl-green-soft);
        border-radius: var(--radius-lg);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 0.85rem;
    }
    .ad-pending-empty-text { font-size: 0.88rem; color: var(--cl-muted); margin: 0; }

    /* List */
    .ad-pending-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .ad-pending-item {
        display: flex; justify-content: space-between; align-items: flex-start; gap: 1.25rem;
        padding: 1.15rem 1.25rem;
        background: var(--cl-light);
        border: 1px solid var(--cl-border);
        border-radius: var(--radius-lg);
        transition: all 0.25s ease;
    }
    .ad-pending-item:hover { border-color: var(--cl-muted); box-shadow: var(--shadow-xs); }
    .ad-pending-info { flex: 1; min-width: 0; }
    .ad-pending-name {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.92rem;
        color: var(--cl-dark);
        margin-bottom: 0.4rem;
    }
    .ad-pending-meta { margin-bottom: 0.4rem; }
    .ad-pending-tag {
        display: inline-flex; align-items: center; gap: 0.3rem;
        font-size: 0.8rem; color: var(--cl-muted);
    }
    .ad-pending-tag svg { flex-shrink: 0; }
    .ad-pending-desc {
        font-size: 0.82rem; color: var(--cl-muted);
        line-height: 1.6; margin-bottom: 0.5rem;
    }
    .ad-pending-user {
        display: flex; align-items: center; gap: 0.35rem;
        font-size: 0.78rem; color: var(--cl-muted);
    }
    .ad-pending-user svg { flex-shrink: 0; }

    /* Actions */
    .ad-pending-actions {
        display: flex; flex-direction: column; gap: 0.5rem;
        align-items: flex-end; flex-shrink: 0;
    }
    .ad-btn {
        display: inline-flex; align-items: center; gap: 0.35rem;
        font-family: 'Inter', sans-serif;
        font-weight: 600; font-size: 0.8rem;
        border-radius: var(--radius-full);
        cursor: pointer;
        transition: all 0.2s ease;
        border: none !important; outline: none !important; box-shadow: none !important;
    }
    .ad-btn--green {
        padding: 0.45rem 1rem;
        background: var(--cl-green-soft);
        color: #1A8C38;
        border: 1px solid rgba(45,198,83,0.25) !important;
        min-width: 120px; justify-content: center;
    }
    .ad-btn--green:hover { background: rgba(45,198,83,0.2); transform: translateY(-1px); }
    .ad-btn--red-icon {
        width: 34px; height: 34px;
        padding: 0; justify-content: center;
        background: var(--cl-red-glow);
        color: var(--cl-red);
        border: 1px solid rgba(230,57,70,0.25) !important;
        flex-shrink: 0;
    }
    .ad-btn--red-icon:hover { background: rgba(230,57,70,0.15); }

    .ad-reject-form { width: 100%; }
    .ad-reject-row { display: flex; gap: 0.4rem; align-items: center; }
    .ad-reject-input {
        width: 140px;
        padding: 0.35rem 0.7rem;
        font-family: 'Inter', sans-serif; font-size: 0.8rem;
        color: var(--cl-dark);
        background: var(--cl-card-bg);
        border: 1.5px solid var(--cl-border);
        border-radius: var(--radius-md);
        outline: none !important; box-shadow: none !important;
        transition: all 0.2s ease;
    }
    .ad-reject-input:focus { border-color: var(--cl-red) !important; box-shadow: 0 0 0 3px rgba(230,57,70,0.08) !important; }
    .ad-reject-input::placeholder { color: var(--cl-muted-light); }

    /* ─── Responsive ─── */
    @media (max-width: 991.98px) {
        .ad-stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 767.98px) {
        .ad-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 0.65rem; }
        .ad-stat-card { padding: 1rem 0.75rem; }
        .ad-stat-num { font-size: 1.25rem; }
        .ad-pending-card { padding: 1.15rem; border-radius: var(--radius-lg); box-shadow: none; border: none; }
        .ad-pending-item {
            flex-direction: column;
            padding: 1rem;
        }
        .ad-pending-actions {
            flex-direction: row;
            align-items: stretch;
            width: 100%;
        }
        .ad-reject-form { flex: 1; }
        .ad-reject-row { flex: 1; }
        .ad-reject-input { flex: 1; width: auto; }
    }
    @media (max-width: 575.98px) {
        .ad-stats-grid { grid-template-columns: 1fr 1fr; gap: 0.5rem; }
        .ad-stat-icon { width: 38px; height: 38px; }
        .ad-stat-icon svg { width: 16px; height: 16px; }
        .ad-stat-num { font-size: 1.1rem; }
    }
</style>
