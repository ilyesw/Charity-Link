<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Administration
            </div>
            <h2 class="mb-0" style="font-size:1.5rem;">Panel Administrateur</h2>
            <p class="header-sub mb-0">Gestion des associations, besoins et validation des profils.</p>
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
    @if(session('error'))
        <div class="ls-flash ls-flash--error">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ session('error') }}
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
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/></svg>
            </div>
            <div class="ad-stat-num">{{ $stats['total_associations'] }}</div>
            <div class="ad-stat-label">Associations</div>
        </div>

        <div class="ad-stat-card">
            <div class="ad-stat-icon ad-stat-icon--orange">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="ad-stat-num ad-stat-num--orange">{{ $stats['en_attente'] }}</div>
            <div class="ad-stat-label">Assoc. en attente</div>
        </div>

        <div class="ad-stat-card">
            <div class="ad-stat-icon ad-stat-icon--green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="ad-stat-num ad-stat-num--green">{{ $stats['validees'] }}</div>
            <div class="ad-stat-label">Assoc. validées</div>
        </div>

        {{-- ✅ Stats besoins --}}
        <div class="ad-stat-card">
            <div class="ad-stat-icon ad-stat-icon--red">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <div class="ad-stat-num ad-stat-num--red">{{ $stats['besoins_en_attente'] }}</div>
            <div class="ad-stat-label">Besoins à valider</div>
        </div>

        <div class="ad-stat-card">
            <div class="ad-stat-icon ad-stat-icon--green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <div class="ad-stat-num ad-stat-num--green">{{ $stats['besoins_valides'] }}</div>
            <div class="ad-stat-label">Besoins validés</div>
        </div>
    </div>

    {{-- ✅ Section Besoins en attente --}}
    <div class="ad-pending-card mb-4">
        <div class="ad-pending-head">
            <div class="ad-pending-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--cl-red)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                Besoins en attente de validation
            </div>
            @if($besoins_en_attente->count() > 0)
                <span class="ad-pending-count">{{ $besoins_en_attente->count() }}</span>
            @endif
        </div>

        @if($besoins_en_attente->isEmpty())
            <div class="ad-pending-empty">
                <div class="ad-pending-empty-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--cl-green)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <p class="ad-pending-empty-text">Aucun besoin en attente !</p>
            </div>
        @else
            <div class="ad-pending-list">
                @foreach($besoins_en_attente as $besoin)
                    <div class="ad-pending-item">
                        <div class="ad-pending-info">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="ad-pending-name mb-0">
                                    {{ $besoin->nom }}
                                    @if($besoin->is_anonymous)
                                        <span class="ad-anon-badge">👤 Anonyme</span>
                                    @endif
                                </h6>
                                {{-- Urgence --}}
                                @if($besoin->urgence === 'critique')
                                    <span class="ad-urgence-badge ad-urgence--red">🔴 Critique</span>
                                @elseif($besoin->urgence === 'urgente')
                                    <span class="ad-urgence-badge ad-urgence--orange">🟠 Urgente</span>
                                @else
                                    <span class="ad-urgence-badge ad-urgence--green">🟢 Normale</span>
                                @endif
                            </div>

                            <div class="ad-pending-meta">
                                <span class="ad-pending-tag">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $besoin->region }}
                                </span>
                                <span class="ad-pending-tag ms-2">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                                    {{ ucfirst($besoin->categorie) }}
                                </span>
                                {{-- APRÈS --}}
                                <span class="ad-pending-tag ms-2">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                    {{ $besoin->email ?? '—' }}
                                </span>
                                @if($besoin->phone)
                                <span class="ad-pending-tag ms-2">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    {{ $besoin->phone }}
                                </span>
                                @endif
                            </div>

                            <p class="ad-pending-desc">{{ Str::limit($besoin->description, 150) }}</p>

                            {{-- Pièce jointe --}}
                            @if($besoin->attachment)
                                <a href="{{ Storage::url($besoin->attachment) }}" target="_blank" class="ad-attachment-link">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                    Voir la pièce jointe
                                </a>
                            @endif

                            <div class="ad-pending-user mt-1">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Soumis le {{ $besoin->created_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>

                        <div class="ad-pending-actions">
                            {{-- Valider --}}
                            <form method="POST" action="{{ route('admin.besoins.valider', $besoin) }}">
                                @csrf
                                <button type="submit" class="ad-btn ad-btn--green">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    Valider
                                </button>
                            </form>
                            {{-- Rejeter --}}
                            <form method="POST" action="{{ route('admin.besoins.rejeter', $besoin) }}"
                                  onsubmit="return confirm('Supprimer définitivement ce besoin ?')">
                                @csrf
                                <button type="submit" class="ad-btn ad-btn--red-full">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    Rejeter
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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

                            <div class="ad-pending-meta mt-1">
                                @if($association->phone_mobile)
                                    <span class="ad-pending-tag">📱 {{ $association->phone_mobile }}</span>
                                @endif
                                @if($association->phone_fix)
                                    <span class="ad-pending-tag ms-2">☎️ {{ $association->phone_fix }}</span>
                                @endif
                                @if($association->email)
                                    <span class="ad-pending-tag ms-2">✉️ {{ $association->email }}</span>
                                @endif
                                @if($association->website)
                                    <span class="ad-pending-tag ms-2">🌐 <a href="{{ $association->website }}" target="_blank">Site web</a></span>
                                @endif
                                @if($association->facebook)
                                    <span class="ad-pending-tag ms-2">📘 <a href="{{ $association->facebook }}" target="_blank">Facebook</a></span>
                                @endif
                            </div>

                            <div class="d-flex gap-2 mt-2 flex-wrap">
                                @if($association->logo)
                                    <a href="{{ asset('storage/' . $association->logo) }}" target="_blank" class="ad-attachment-link">🖼️ Logo</a>
                                @endif
                                @if($association->doc_rne)
                                    <a href="{{ asset('storage/' . $association->doc_rne) }}" target="_blank" class="ad-attachment-link">📄 RNE</a>
                                @endif
                                @if($association->doc_fiscal)
                                    <a href="{{ asset('storage/' . $association->doc_fiscal) }}" target="_blank" class="ad-attachment-link">📄 Fiscal</a>
                                @endif
                            </div>

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
    .ls-flash { display: flex; align-items: center; gap: 0.6rem; padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.84rem; font-weight: 500; margin-bottom: 1.25rem; animation: ls-slideDown 0.3s ease; }
    .ls-flash svg { flex-shrink: 0; }
    .ls-flash--success { background: var(--cl-green-soft); color: #1A8C38; border: 1px solid rgba(45,198,83,0.15); }
    .ls-flash--error { background: var(--cl-red-soft); color: var(--cl-red); border: 1px solid rgba(230,57,70,0.15); }
    @keyframes ls-slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

    .ad-admin-badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.9rem; background: var(--cl-dark); color: #FBBF24; border-radius: var(--radius-full); font-family: 'Inter', sans-serif; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.05em; }
    html.dark .ad-admin-badge { background: rgba(251,191,36,0.12); color: #FBBF24; border: 1px solid rgba(251,191,36,0.2); }

    .ad-stats-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 0.85rem; margin-bottom: 1.5rem; }
    .ad-stat-card { background: var(--cl-card-bg); border: 1px solid var(--cl-card-border); border-radius: var(--radius-lg); padding: 1.35rem 1rem; text-align: center; box-shadow: var(--shadow-xs); transition: all 0.25s ease; }
    .ad-stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .ad-stat-icon { width: 44px; height: 44px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem; }
    .ad-stat-icon--blue { background: rgba(29,53,87,0.08); color: var(--cl-blue); }
    html.dark .ad-stat-icon--blue { background: rgba(29,53,87,0.2); color: #93bbfd; }
    .ad-stat-icon--orange { background: rgba(245,166,35,0.08); color: #B8860B; }
    .ad-stat-icon--green { background: var(--cl-green-soft); color: #1A8C38; }
    .ad-stat-icon--red { background: var(--cl-red-soft); color: var(--cl-red); }
    .ad-stat-num { font-family: 'Inter', sans-serif; font-weight: 800; font-size: 1.5rem; color: var(--cl-dark); line-height: 1.2; }
    .ad-stat-num--orange { color: #B8860B; }
    .ad-stat-num--green { color: #1A8C38; }
    .ad-stat-num--red { color: var(--cl-red); }
    .ad-stat-label { font-size: 0.8rem; color: var(--cl-muted); font-weight: 500; margin-top: 0.2rem; }

    .ad-pending-card { background: var(--cl-card-bg); border: 1px solid var(--cl-card-border); border-radius: var(--radius-xl); padding: 1.5rem; box-shadow: var(--shadow-sm); }
    .ad-pending-head { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem; }
    .ad-pending-title { display: flex; align-items: center; gap: 0.5rem; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.95rem; color: var(--cl-dark); }
    .ad-pending-count { display: inline-flex; align-items: center; justify-content: center; min-width: 24px; height: 24px; padding: 0 6px; background: var(--cl-red); color: #fff; border-radius: var(--radius-full); font-size: 0.72rem; font-weight: 700; }
    .ad-pending-empty { text-align: center; padding: 2.5rem 1rem; }
    .ad-pending-empty-icon { width: 56px; height: 56px; background: var(--cl-green-soft); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.85rem; }
    .ad-pending-empty-text { font-size: 0.88rem; color: var(--cl-muted); margin: 0; }
    .ad-pending-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .ad-pending-item { display: flex; justify-content: space-between; align-items: flex-start; gap: 1.25rem; padding: 1.15rem 1.25rem; background: var(--cl-light); border: 1px solid var(--cl-border); border-radius: var(--radius-lg); transition: all 0.25s ease; }
    .ad-pending-item:hover { border-color: var(--cl-muted); box-shadow: var(--shadow-xs); }
    .ad-pending-info { flex: 1; min-width: 0; }
    .ad-pending-name { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.92rem; color: var(--cl-dark); margin-bottom: 0.4rem; }
    .ad-pending-meta { margin-bottom: 0.4rem; }
    .ad-pending-tag { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.8rem; color: var(--cl-muted); }
    .ad-pending-desc { font-size: 0.82rem; color: var(--cl-muted); line-height: 1.6; margin-bottom: 0.5rem; }
    .ad-pending-user { display: flex; align-items: center; gap: 0.35rem; font-size: 0.78rem; color: var(--cl-muted); }

    /* ✅ Badges besoins */
    .ad-anon-badge { display: inline-flex; align-items: center; gap: 3px; padding: 2px 8px; background: var(--cl-light); border: 1px solid var(--cl-border); border-radius: var(--radius-full); font-size: 0.68rem; font-weight: 600; color: var(--cl-muted); }
    .ad-urgence-badge { display: inline-flex; align-items: center; padding: 2px 8px; border-radius: var(--radius-full); font-size: 0.68rem; font-weight: 600; }
    .ad-urgence--red { background: var(--cl-red-soft); color: var(--cl-red); }
    .ad-urgence--orange { background: rgba(245,166,35,0.1); color: #B8860B; }
    .ad-urgence--green { background: var(--cl-green-soft); color: #1A8C38; }

    /* ✅ Lien pièce jointe */
    .ad-attachment-link { display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.78rem; font-weight: 600; color: var(--cl-blue); text-decoration: none; margin-top: 0.3rem; }
    .ad-attachment-link:hover { text-decoration: underline; }
    html.dark .ad-attachment-link { color: #93bbfd; }

    /* Actions */
    .ad-pending-actions { display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-end; flex-shrink: 0; }
    .ad-btn { display: inline-flex; align-items: center; gap: 0.35rem; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.8rem; border-radius: var(--radius-full); cursor: pointer; transition: all 0.2s ease; border: none !important; outline: none !important; box-shadow: none !important; }
    .ad-btn--green { padding: 0.45rem 1rem; background: var(--cl-green-soft); color: #1A8C38; border: 1px solid rgba(45,198,83,0.25) !important; min-width: 100px; justify-content: center; }
    .ad-btn--green:hover { background: rgba(45,198,83,0.2); transform: translateY(-1px); }
    .ad-btn--red-full { padding: 0.45rem 1rem; background: var(--cl-red-soft); color: var(--cl-red); border: 1px solid rgba(230,57,70,0.25) !important; min-width: 100px; justify-content: center; }
    .ad-btn--red-full:hover { background: rgba(230,57,70,0.15); transform: translateY(-1px); }
    .ad-btn--red-icon { width: 34px; height: 34px; padding: 0; justify-content: center; background: var(--cl-red-glow); color: var(--cl-red); border: 1px solid rgba(230,57,70,0.25) !important; flex-shrink: 0; }
    .ad-btn--red-icon:hover { background: rgba(230,57,70,0.15); }
    .ad-reject-form { width: 100%; }
    .ad-reject-row { display: flex; gap: 0.4rem; align-items: center; }
    .ad-reject-input { width: 140px; padding: 0.35rem 0.7rem; font-family: 'Inter', sans-serif; font-size: 0.8rem; color: var(--cl-dark); background: var(--cl-card-bg); border: 1.5px solid var(--cl-border); border-radius: var(--radius-md); outline: none !important; transition: all 0.2s ease; }
    .ad-reject-input:focus { border-color: var(--cl-red) !important; box-shadow: 0 0 0 3px rgba(230,57,70,0.08) !important; }
    .ad-reject-input::placeholder { color: var(--cl-muted-light); }

    @media (max-width: 1199.98px) { .ad-stats-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 767.98px) {
        .ad-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 0.65rem; }
        .ad-stat-card { padding: 1rem 0.75rem; }
        .ad-stat-num { font-size: 1.25rem; }
        .ad-pending-card { padding: 1.15rem; border-radius: var(--radius-lg); box-shadow: none; border: none; }
        .ad-pending-item { flex-direction: column; padding: 1rem; }
        .ad-pending-actions { flex-direction: row; align-items: stretch; width: 100%; }
        .ad-reject-form { flex: 1; }
        .ad-reject-row { flex: 1; }
        .ad-reject-input { flex: 1; width: auto; }
    }
</style>
