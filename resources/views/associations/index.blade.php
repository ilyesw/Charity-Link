<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-2">
            <div>
                <div class="section-label"><i class="bi bi-building"></i> Associations validées</div>
                <h2 class="mb-0" style="font-size:1.5rem;">Découvrez les acteurs solidaires</h2>
                <p class="header-sub mb-0">Associations tunisiennes vérifiées par notre équipe.</p>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center" style="border-radius:var(--radius-md);">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Count Bar -->
    <div class="assoc-filters mb-4">
        <div class="assoc-count">
            <span class="assoc-count-num">{{ $associations->total() }}</span>
            <span class="assoc-count-label">association(s) vérifiée(s)</span>
        </div>
        <div class="assoc-verified-badge">
            <i class="bi bi-patch-check-fill"></i>
            Toutes vérifiées
        </div>
    </div>

    @if($associations->isEmpty())
        <div class="assoc-empty">
            <div class="assoc-empty-icon"><i class="bi bi-building"></i></div>
            <h5>Aucune association validée</h5>
            <p>Revenez bientôt, de nouvelles associations sont en cours de vérification.</p>
            <a href="/" class="btn btn-outline-primary btn-sm mt-3">
                <i class="bi bi-house me-1"></i> Retour à l'accueil
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach($associations as $association)
                <div class="col-md-6 col-lg-4">
                    <div class="assoc-card h-100">
                        <div class="assoc-card-inner d-flex flex-column h-100">

                            <!-- Top: Category + Verified -->
                            <div class="assoc-top-row">
                                @if($association->category)
                                    <span class="assoc-badge-cat">
                                        <i class="bi bi-tag-fill"></i>
                                        {{ ucfirst($association->category) }}
                                    </span>
                                @else
                                    <span class="assoc-badge-cat">
                                        <i class="bi bi-tag-fill"></i>
                                        Humanitaire
                                    </span>
                                @endif
                                <span class="assoc-badge-verified">
                                    <i class="bi bi-patch-check-fill"></i>
                                </span>
                            </div>

                            <!-- Avatar + Name -->
                            <div class="assoc-header">
                                <div class="assoc-avatar">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div>
                                    <h5 class="assoc-name">{{ $association->name }}</h5>
                                    <div class="assoc-region">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        {{ $association->region }}
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="assoc-desc">{{ Str::limit($association->description, 110) }}</p>

                            <!-- Spacer -->
                            <div class="flex-grow-1"></div>

                            <!-- Stats Row -->
                            @php
                                $assocCampaigns = $association->campaigns ? $association->campaigns->count() : 0;
                            @endphp
                            @if($assocCampaigns > 0)
                            <div class="assoc-stats">
                                <div class="assoc-stat">
                                    <i class="bi bi-megaphone-fill"></i>
                                    <span>{{ $assocCampaigns }}</span>
                                    <small>Campagne{{ $assocCampaigns > 1 ? 's' : '' }}</small>
                                </div>
                            </div>
                            @endif

                            <!-- Button -->
                            <a href="{{ route('associations.show', $association) }}" class="assoc-btn-view">
                                Voir le profil
                                <i class="bi bi-arrow-right"></i>
                            </a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $associations->links('pagination::bootstrap-5') }}
        </div>
    @endif

    <style>
        /* ══════════════ FILTERS BAR ══════════════ */
        .assoc-filters {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .assoc-count {
            display: flex;
            align-items: baseline;
            gap: 0.5rem;
        }
        .assoc-count-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--cl-dark);
        }
        .assoc-count-label {
            font-size: 0.88rem;
            color: var(--cl-muted);
        }
        .assoc-verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--cl-green);
            background: var(--cl-green-soft);
            padding: 0.4rem 0.85rem;
            border-radius: var(--radius-full);
        }
        .assoc-verified-badge i { font-size: 0.85rem; }

        /* ══════════════ EMPTY STATE ══════════════ */
        .assoc-empty {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--cl-card-bg);
            border: 2px dashed var(--cl-border);
            border-radius: var(--radius-xl);
            transition: all 0.35s ease;
        }
        .assoc-empty-icon {
            width: 72px; height: 72px;
            background: var(--cl-blue-soft);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
        }
        .assoc-empty-icon i { font-size: 1.75rem; color: var(--cl-blue); }
        html.dark .assoc-empty-icon i { color: #93bbfd; }
        .assoc-empty h5 {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--cl-dark);
            margin-bottom: 0.5rem;
        }
        .assoc-empty p {
            font-size: 0.9rem;
            color: var(--cl-muted);
            margin: 0;
        }

        /* ══════════════ ASSOCIATION CARD ══════════════ */
        .assoc-card {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-xl);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1), background-color 0.35s ease, border-color 0.35s ease;
            display: flex;
            flex-direction: column;
        }
        .assoc-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-xl);
            border-color: transparent;
        }
        .assoc-card-inner {
            padding: 1.5rem;
        }

        /* Top Row */
        .assoc-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .assoc-badge-cat {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: var(--cl-blue-soft);
            color: var(--cl-blue);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.3rem 0.65rem;
            border-radius: var(--radius-full);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            transition: all 0.35s ease;
        }
        html.dark .assoc-badge-cat { color: #93bbfd; }
        .assoc-badge-verified {
            width: 28px; height: 28px;
            background: var(--cl-green-soft);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.35s ease;
        }
        .assoc-badge-verified i {
            font-size: 0.75rem;
            color: var(--cl-green);
        }
        .assoc-card:hover .assoc-badge-verified {
            transform: scale(1.15);
        }

        /* Header: Avatar + Name */
        .assoc-header {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            margin-bottom: 1rem;
        }
        .assoc-avatar {
            width: 48px; height: 48px;
            background: var(--cl-light);
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: all 0.35s ease;
        }
        .assoc-avatar i { font-size: 1.2rem; color: var(--cl-blue); }
        html.dark .assoc-avatar i { color: #93bbfd; }
        .assoc-card:hover .assoc-avatar {
            background: var(--cl-blue-soft);
        }
        .assoc-name {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1.02rem;
            line-height: 1.3;
            color: var(--cl-dark);
            margin-bottom: 0.2rem;
            transition: color 0.35s ease;
        }
        .assoc-region {
            font-size: 0.78rem;
            color: var(--cl-muted);
            display: flex;
            align-items: center;
            gap: 0.25rem;
            transition: color 0.35s ease;
        }
        .assoc-region i { color: var(--cl-green); font-size: 0.7rem; }

        /* Description */
        .assoc-desc {
            font-size: 0.85rem;
            color: var(--cl-muted);
            line-height: 1.65;
            margin-bottom: 1.25rem;
            transition: color 0.35s ease;
        }

        /* Stats Row */
        .assoc-stats {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.85rem 1rem;
            background: var(--cl-light);
            border-radius: var(--radius-md);
            margin-bottom: 1rem;
            transition: all 0.35s ease;
        }
        .assoc-stats:has(.assoc-stat:only-child) {
            max-width: 160px;
            margin-left: auto;
            margin-right: auto;
        }
        .assoc-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.15rem;
            flex: 1;
        }
        .assoc-stat i {
            font-size: 0.8rem;
            color: var(--cl-red);
            margin-bottom: 0.1rem;
        }
        .assoc-stat span {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--cl-dark);
            transition: color 0.35s ease;
        }
        .assoc-stat small {
            font-size: 0.68rem;
            color: var(--cl-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            transition: color 0.35s ease;
        }

        /* Button */
        .assoc-btn-view {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            width: 100%;
            background: transparent;
            color: var(--cl-body);
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-full);
            padding: 0.6rem;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .assoc-btn-view:hover {
            border-color: var(--cl-red);
            color: var(--cl-red);
            background: var(--cl-red-glow);
            transform: translateY(-1px);
        }
        .assoc-btn-view i {
            font-size: 0.8rem;
            transition: transform 0.2s ease;
        }
        .assoc-btn-view:hover i {
            transform: translateX(3px);
        }
    </style>
</x-app-layout>
