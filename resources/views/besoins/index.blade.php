<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                {{ __('Solidarité') }}
            </div>
            <h2 class="mb-0" style="font-size:1.5rem;">{{ __('Besoins d\'aide') }}</h2>
            <p class="header-sub mb-0">{{ __('Aidez ceux qui en ont besoin près de chez vous.') }}</p>
        </div>
        <div class="d-none d-md-flex gap-2">
            <a href="{{ route('besoins.create') }}" class="ls-header-btn ls-header-btn--red">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                {{ __('Déclarer un besoin') }}
            </a>
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

    {{-- Bouton mobile --}}
    <div class="d-md-none mb-3">
        <a href="{{ route('besoins.create') }}" class="ls-header-btn ls-header-btn--red ls-header-btn--full">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            {{ __('Déclarer un besoin') }}
        </a>
    </div>

    <div class="ls-count">
        <strong>{{ $besoins->total() }}</strong> {{ __('besoin(s) déclaré(s)') }}
    </div>

    @if($besoins->isEmpty())
        <div class="ls-empty-card">
            <div class="ls-empty-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--cl-green)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h5 class="ls-empty-title">{{ __('Aucun besoin déclaré') }}</h5>
            <p class="ls-empty-desc">{{ __('Revenez bientôt, de nouvelles demandes apparaîtront prochainement.') }}</p>
        </div>
    @else
        <div class="ls-grid">
            @foreach($besoins as $besoin)
                <div class="ls-card">
                    <div class="ls-card-body d-flex flex-column">

                        {{-- Header --}}
                        <div class="ls-card-top">
                            <div class="ls-card-avatar" style="background: var(--cl-red-glow); color: var(--cl-red);">
                                @if(in_array($besoin->categorie, ['alimentaire','alimentation']))
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                                @elseif(in_array($besoin->categorie, ['medical','sante']))
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                                @elseif($besoin->categorie === 'education')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                @elseif($besoin->categorie === 'logement')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                @else
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                                @endif
                            </div>
                            <div class="ls-card-info">
                                {{-- ✅ Feature 2 : Nom public (Anonyme ou réel) --}}
                                <h6 class="ls-card-title d-flex align-items-center gap-1">
                                    {{ $besoin->nom_public }}
                                    @if($besoin->is_anonymous)
                                        <span class="ls-anon-badge">
                                            <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><line x1="23" y1="1" x2="1" y2="23"/></svg>
                                            Anonyme
                                        </span>
                                    @endif
                                </h6>
                                <small class="ls-card-sub">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $besoin->region }}
                                </small>
                            </div>
                            @if($besoin->urgence === 'critique')
                                <span class="ls-badge ls-badge--red">{{ __('Critique') }}</span>
                            @elseif($besoin->urgence === 'urgente')
                                <span class="ls-badge ls-badge--orange">{{ __('Urgente') }}</span>
                            @else
                                <span class="ls-badge ls-badge--muted">{{ __('Normale') }}</span>
                            @endif
                        </div>

                        {{-- Catégorie + pièce jointe --}}
                        <div class="ls-card-tags">
                            <span class="ls-tag ls-tag--red">{{ ucfirst($besoin->categorie) }}</span>
                            {{-- ✅ Feature 3 : Indicateur pièce jointe --}}
                            @if($besoin->attachment)
                                <span class="ls-tag ls-tag--blue">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                    {{ __('Pièce jointe') }}
                                </span>
                            @endif
                        </div>

                        {{-- Description --}}
                        <p class="ls-card-desc">{{ $besoin->description }}</p>
                        @if(!$besoin->is_anonymous)
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @if($besoin->phone)
                                    <span style="font-size:0.78rem; color:var(--cl-muted);">📱 {{ $besoin->phone }}</span>
                                @endif
                                @if($besoin->email)
                                    <span style="font-size:0.78rem; color:var(--cl-muted);">✉️ {{ $besoin->email }}</span>
                                @endif
                            </div>
                        @endif


                        {{-- Association assignée --}}
                        @if($besoin->association)
                            <div class="ls-assigned-block">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#1A8C38" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/></svg>
                                <span><strong>{{ $besoin->association->name }}</strong></span>
                            </div>
                        @endif

                        {{-- Footer --}}
                        <div class="ls-card-actions mt-auto">
                            <div>
                                @if($besoin->status === 'pris_en_charge')
                                    <span class="ls-badge ls-badge--green">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        {{ __('Pris en charge') }}
                                    </span>
                                @elseif($besoin->status === 'resolu')
                                    <span class="ls-badge ls-badge--blue">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        {{ __('Résolu') }}
                                    </span>
                                @else
                                    <span class="ls-badge ls-badge--muted">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        {{ __('Validé') }}
                                    </span>
                                @endif
                                <small class="ls-card-date">{{ $besoin->created_at->format('d/m/Y') }}</small>
                            </div>

                            @auth
                                @if(auth()->user()->isAssociation() && in_array($besoin->status, ['en_attente','validee']))
                                    <form method="POST" action="{{ route('besoins.prendre_en_charge', $besoin) }}">
                                        @csrf
                                        <button type="submit" class="ls-btn ls-btn--red" onclick="return confirm('{{ __('Prendre en charge ce besoin ?') }}')">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                            {{ __('Prendre en charge') }}
                                        </button>
                                    </form>
                                @endif
                            @else
                                @if($besoin->status === 'validee')
                                    <a href="{{ route('login') }}" class="ls-btn ls-btn--ghost">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                        {{ __('Se connecter') }}
                                    </a>
                                @endif
                            @endauth
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <div class="ls-pagination">
            {{ $besoins->links('pagination::bootstrap-5') }}
        </div>
    @endif

    {{-- CTA --}}
    <div class="ls-cta-card mt-4">
        <div class="ls-cta-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--cl-red)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </div>
        <h5 class="ls-cta-title">{{ __('Vous avez besoin d\'aide ?') }}</h5>
        <p class="ls-cta-desc">{{ __('Déclarez votre besoin — sans inscription') }}</p>
        <a href="{{ route('besoins.create') }}" class="ls-cta-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            {{ __('Déclarer un besoin') }}
        </a>
    </div>

</x-app-layout>

<style>
    .ls-flash { display: flex; align-items: center; gap: 0.6rem; padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.84rem; font-weight: 500; margin-bottom: 1.25rem; animation: ls-slideDown 0.3s ease; }
    .ls-flash svg { flex-shrink: 0; }
    .ls-flash--success { background: var(--cl-green-soft); color: #1A8C38; border: 1px solid rgba(45,198,83,0.15); }
    .ls-flash--error { background: var(--cl-red-soft); color: var(--cl-red); border: 1px solid rgba(230,57,70,0.15); }
    @keyframes ls-slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
    .ls-header-btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.82rem; border-radius: var(--radius-md); text-decoration: none; cursor: pointer; transition: all 0.25s ease; border: 1.5px solid var(--cl-border); color: var(--cl-muted); background: var(--cl-card-bg); }
    .ls-header-btn:hover { color: var(--cl-dark); border-color: var(--cl-muted); background: var(--cl-light); }
    .ls-header-btn--red { background: var(--cl-red); color: #fff; border-color: var(--cl-red); }
    .ls-header-btn--red:hover { background: var(--cl-red-hover); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(230,57,70,0.3); }
    .ls-header-btn--full { width: 100%; justify-content: center; }
    .ls-count { font-size: 0.85rem; color: var(--cl-muted); margin-bottom: 1.25rem; }
    .ls-count strong { color: var(--cl-dark); font-weight: 700; }
    .ls-empty-card { text-align: center; padding: 3rem 2rem; background: var(--cl-card-bg); border: 1px solid var(--cl-card-border); border-radius: var(--radius-xl); box-shadow: var(--shadow-sm); }
    .ls-empty-icon { width: 72px; height: 72px; background: var(--cl-green-soft); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; }
    .ls-empty-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1rem; color: var(--cl-dark); margin-bottom: 0.4rem; }
    .ls-empty-desc { font-size: 0.85rem; color: var(--cl-muted); margin-bottom: 0; }
    .ls-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    .ls-card { background: var(--cl-card-bg); border: 1px solid var(--cl-card-border); border-radius: var(--radius-lg); box-shadow: var(--shadow-xs); transition: all 0.25s ease; }
    .ls-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); border-color: transparent; }
    .ls-card-body { padding: 1.15rem 1.25rem; }
    .ls-card-top { display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 0.75rem; }
    .ls-card-avatar { width: 42px; height: 42px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ls-card-info { flex: 1; min-width: 0; }
    .ls-card-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.9rem; color: var(--cl-dark); margin-bottom: 0.1rem; }
    .ls-card-sub { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.78rem; color: var(--cl-muted); }
    .ls-badge { display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.25rem 0.65rem; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.7rem; border-radius: var(--radius-full); flex-shrink: 0; }
    .ls-badge--red { background: var(--cl-red-soft); color: var(--cl-red); }
    .ls-badge--orange { background: rgba(245,166,35,0.1); color: #B8860B; }
    .ls-badge--green { background: var(--cl-green-soft); color: #1A8C38; }
    .ls-badge--blue { background: var(--cl-blue-soft); color: var(--cl-blue); }
    html.dark .ls-badge--blue { color: #93bbfd; }
    .ls-badge--muted { background: var(--cl-light); color: var(--cl-muted); border: 1px solid var(--cl-border); }

    /* ✅ Badge anonyme */
    .ls-anon-badge { display: inline-flex; align-items: center; gap: 3px; padding: 2px 7px; background: var(--cl-light); border: 1px solid var(--cl-border); border-radius: var(--radius-full); font-size: 0.65rem; font-weight: 600; color: var(--cl-muted); }

    .ls-card-tags { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 0.65rem; }
    .ls-tag { display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.25rem 0.6rem; border-radius: var(--radius-full); font-size: 0.75rem; font-weight: 600; }
    .ls-tag--red { background: var(--cl-red-glow); color: var(--cl-red); }
    .ls-tag--blue { background: var(--cl-blue-soft); color: var(--cl-blue); }
    html.dark .ls-tag--blue { color: #93bbfd; }
    .ls-card-desc { font-size: 0.82rem; color: var(--cl-muted); line-height: 1.6; margin-bottom: 0.65rem; }
    .ls-assigned-block { display: flex; align-items: center; gap: 0.4rem; padding: 0.5rem 0.7rem; background: var(--cl-green-soft); border: 1px solid rgba(45,198,83,0.15); border-radius: var(--radius-sm); margin-bottom: 0.65rem; font-size: 0.78rem; color: #1A8C38; }
    .ls-card-actions { display: flex; justify-content: space-between; align-items: center; padding-top: 0.75rem; border-top: 1px solid var(--cl-border); gap: 0.5rem; }
    .ls-card-actions > div:first-child { display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; }
    .ls-card-date { font-size: 0.75rem; color: var(--cl-muted-light); }
    .ls-btn { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.5rem 0.9rem; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.8rem; border-radius: var(--radius-md); text-decoration: none; cursor: pointer; transition: all 0.25s ease; border: none !important; white-space: nowrap; }
    .ls-btn--red { background: var(--cl-red); color: #fff; }
    .ls-btn--red:hover { background: var(--cl-red-hover); color: #fff; transform: translateY(-1px); }
    .ls-btn--ghost { background: transparent; color: var(--cl-muted); border: 1.5px solid var(--cl-border) !important; }
    .ls-btn--ghost:hover { color: var(--cl-dark); background: var(--cl-light); }
    .ls-cta-card { text-align: center; padding: 2.5rem 2rem; background: var(--cl-card-bg); border: 1px solid var(--cl-card-border); border-radius: var(--radius-xl); box-shadow: var(--shadow-sm); }
    .ls-cta-icon { width: 56px; height: 56px; background: var(--cl-red-glow); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
    .ls-cta-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1rem; color: var(--cl-dark); margin-bottom: 0.3rem; }
    .ls-cta-desc { font-size: 0.85rem; color: var(--cl-muted); margin-bottom: 1.25rem; }
    .ls-cta-btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.65rem 1.5rem; background: var(--cl-red); color: #fff; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.88rem; border-radius: var(--radius-md); text-decoration: none; box-shadow: 0 2px 8px rgba(230,57,70,0.2); transition: all 0.25s ease; }
    .ls-cta-btn:hover { background: var(--cl-red-hover); color: #fff; transform: translateY(-1px); }
    .ls-pagination { margin-top: 1.5rem; }
    .ls-pagination .pagination .page-link { border-radius: var(--radius-sm) !important; margin: 0 2px; border: 1px solid var(--cl-border) !important; color: var(--cl-body) !important; font-weight: 500; font-size: 0.85rem; padding: 0.4rem 0.8rem; background: var(--cl-card-bg) !important; transition: all 0.2s ease; }
    .ls-pagination .pagination .page-item.active .page-link { background: var(--cl-red) !important; border-color: var(--cl-red) !important; color: #fff !important; }
    @media (max-width: 991.98px) { .ls-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 767.98px) { .ls-grid { grid-template-columns: 1fr; } .ls-card-body { padding: 1rem; } .ls-card-actions { flex-direction: column; align-items: stretch; } .ls-btn { justify-content: center; } }
</style>
