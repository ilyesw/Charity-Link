<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-2">
            <div>
                <div class="section-label"><i class="bi bi-building"></i> Détail de l'association</div>
                <h2 class="mb-0" style="font-size:1.5rem;">{{ Str::limit($association->name, 40) }}</h2>
                <p class="header-sub mb-0">Informations vérifiées et campagnes actives.</p>
            </div>
            <div class="d-flex gap-2 flex-shrink-0">
                <a href="{{ route('associations.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
                @auth
                    @if(auth()->user()->id === $association->user_id)
                        <a href="{{ route('associations.edit', $association) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil me-1"></i> Modifier
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="row g-4">

        <!-- ═══ LEFT: Association Info ═══ -->
        <div class="col-lg-5">
            <div class="assoc-show-card">

                <!-- Category + Verified -->
                <div class="as-top-row">
                    @if($association->category)
                        <span class="as-badge-cat">
                            <i class="bi bi-tag-fill"></i>
                            {{ ucfirst($association->category) }}
                        </span>
                    @else
                        <span class="as-badge-cat">
                            <i class="bi bi-tag-fill"></i>
                            Humanitaire
                        </span>
                    @endif
                    <span class="as-badge-verified">
                        <i class="bi bi-patch-check-fill"></i>
                        Vérifiée
                    </span>
                </div>

                <!-- Avatar + Name -->
                <div class="as-avatar-section">
                    <div class="as-avatar">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <h1 class="as-name">{{ $association->name }}</h1>
                        <div class="as-region">
                            <i class="bi bi-geo-alt-fill"></i>
                            {{ $association->region }}
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="as-section">
                    <h6 class="as-section-title">
                        <i class="bi bi-file-text"></i>
                        À propos
                    </h6>
                    <div class="as-description">{{ $association->description }}</div>
                </div>

                <!-- Contact Links -->
                @if($association->website || $association->facebook)
                    <div class="as-section">
                        <h6 class="as-section-title">
                            <i class="bi bi-link-45deg"></i>
                            Contacts & Réseaux
                        </h6>
                        <div class="as-links">
                            @if($association->website)
                                <a href="{{ $association->website }}" target="_blank" class="as-link">
                                    <div class="as-link-icon as-link-web">
                                        <i class="bi bi-globe"></i>
                                    </div>
                                    <span class="as-link-label">Site web</span>
                                    <i class="bi bi-box-arrow-up-right as-link-arrow"></i>
                                </a>
                            @endif
                            @if($association->facebook)
                                <a href="{{ $association->facebook }}" target="_blank" class="as-link">
                                    <div class="as-link-icon as-link-fb">
                                        <i class="bi bi-facebook"></i>
                                    </div>
                                    <span class="as-link-label">Facebook</span>
                                    <i class="bi bi-box-arrow-up-right as-link-arrow"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Stats Summary -->
                @php
                    $assocCampaigns = $association->campaigns ? $association->campaigns->count() : 0;
                    $assocTotal = $association->campaigns ? $association->campaigns->sum('current_amount') : 0;
                @endphp
                <div class="as-stats-card">
                    <div class="as-stat-item">
                        <div class="as-stat-icon as-stat-camp">
                            <i class="bi bi-megaphone-fill"></i>
                        </div>
                        <div class="as-stat-info">
                            <span class="as-stat-num">{{ $assocCampaigns }}</span>
                            <span class="as-stat-label">Campagnes</span>
                        </div>
                    </div>
                    <div class="as-stat-divider"></div>
                    <div class="as-stat-item">
                        <div class="as-stat-icon as-stat-amt">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="as-stat-info">
                            <span class="as-stat-num">{{ number_format($assocTotal, 0) }}</span>
                            <span class="as-stat-label">DT collectés</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- ═══ RIGHT: Campaigns ═══ -->
        <div class="col-lg-7">
            <div class="as-campaigns-header">
                <h5 class="as-campaigns-title">
                    <i class="bi bi-megaphone-fill"></i>
                    Campagnes de cette association
                </h5>
                <span class="as-campaigns-count">{{ $assocCampaigns }} active{{ $assocCampaigns != 1 ? 's' : '' }}</span>
            </div>

            @if($association->campaigns->isEmpty())
                <div class="as-campaigns-empty">
                    <div class="as-campaigns-empty-icon"><i class="bi bi-inbox"></i></div>
                    <h6>Aucune campagne active</h6>
                    <p>Cette association n'a pas encore publié de campagne.</p>
                </div>
            @else
                <div class="row g-3">
                    @foreach($association->campaigns as $campaign)
                        <div class="col-md-6">
                            <div class="as-camp-card h-100">
                                <div class="as-camp-inner d-flex flex-column h-100">

                                    <!-- Status -->
                                    <div class="as-camp-top">
                                        <span class="as-camp-status">
                                            <span class="as-camp-dot"></span>
                                            Active
                                        </span>
                                        @if($campaign->deadline)
                                            <span class="as-camp-deadline">
                                                <i class="bi bi-clock"></i>
                                                {{ $campaign->deadline->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Title -->
                                    <h6 class="as-camp-title">{{ $campaign->title }}</h6>

                                    <div class="flex-grow-1"></div>

                                    <!-- Progress -->
                                    <div class="as-camp-progress">
                                        <div class="as-camp-track">
                                            <div class="as-camp-fill" style="width: {{ $campaign->progressPercentage() }}%;"></div>
                                        </div>
                                        <div class="as-camp-meta">
                                            <span class="as-camp-raised">{{ number_format($campaign->current_amount, 0) }} DT</span>
                                            <span class="as-camp-pct">{{ $campaign->progressPercentage() }}%</span>
                                            <span class="as-camp-goal">{{ number_format($campaign->goal_amount, 0) }} DT</span>
                                        </div>
                                    </div>

                                    <!-- Button -->
                                    <a href="{{ route('campaigns.show', $campaign) }}" class="as-camp-btn">
                                        <i class="bi bi-arrow-right"></i>
                                        Voir la campagne
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <style>
        /* ══════════════ ASSOCIATION SHOW CARD ══════════════ */
        .assoc-show-card {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-xl);
            padding: 2rem;
            transition: all 0.35s ease;
        }

        /* Top Row */
        .as-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .as-badge-cat {
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
        html.dark .as-badge-cat { color: #93bbfd; }
        .as-badge-verified {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--cl-green);
            background: var(--cl-green-soft);
            padding: 0.3rem 0.7rem;
            border-radius: var(--radius-full);
            transition: all 0.35s ease;
        }
        .as-badge-verified i { font-size: 0.7rem; }

        /* Avatar Section */
        .as-avatar-section {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.75rem;
        }
        .as-avatar {
            width: 64px; height: 64px;
            background: var(--cl-blue-soft);
            border-radius: var(--radius-lg);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: all 0.35s ease;
        }
        .as-avatar i { font-size: 1.6rem; color: var(--cl-blue); }
        html.dark .as-avatar i { color: #93bbfd; }
        .as-name {
            font-size: clamp(1.3rem, 3vw, 1.65rem);
            font-weight: 700;
            line-height: 1.25;
            color: var(--cl-dark);
            margin-bottom: 0.25rem;
            transition: color 0.35s ease;
        }
        .as-region {
            font-size: 0.85rem;
            color: var(--cl-muted);
            display: flex;
            align-items: center;
            gap: 0.3rem;
            transition: color 0.35s ease;
        }
        .as-region i { color: var(--cl-green); font-size: 0.8rem; }

        /* Sections */
        .as-section {
            margin-bottom: 1.75rem;
        }
        .as-section-title {
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--cl-dark);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.35s ease;
        }
        .as-section-title i { color: var(--cl-red); font-size: 0.8rem; }
        .as-description {
            font-size: 0.92rem;
            color: var(--cl-body);
            line-height: 1.8;
            transition: color 0.35s ease;
        }

        /* Contact Links */
        .as-links {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }
        .as-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: var(--cl-light);
            border: 1px solid var(--cl-border);
            border-radius: var(--radius-md);
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .as-link:hover {
            border-color: var(--cl-blue);
            background: var(--cl-blue-soft);
        }
        .as-link-icon {
            width: 36px; height: 36px;
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: all 0.35s ease;
        }
        .as-link-icon i { font-size: 0.95rem; }
        .as-link-web { background: var(--cl-blue-soft); }
        .as-link-web i { color: var(--cl-blue); }
        html.dark .as-link-web i { color: #93bbfd; }
        html.dark .as-link-web { background: rgba(29,53,87,0.25); }
        .as-link-fb { background: #1877F2; }
        .as-link-fb i { color: #fff; }
        .as-link-label {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--cl-dark);
            flex: 1;
            transition: color 0.35s ease;
        }
        .as-link-arrow {
            font-size: 0.8rem;
            color: var(--cl-muted);
            transition: all 0.2s ease;
        }
        .as-link:hover .as-link-arrow {
            color: var(--cl-blue);
            transform: translate(2px, -2px);
        }

        /* Stats Card */
        .as-stats-card {
            display: flex;
            align-items: center;
            background: var(--cl-light);
            border: 1px solid var(--cl-border);
            border-radius: var(--radius-lg);
            padding: 1.25rem;
            transition: all 0.35s ease;
        }
        .as-stat-item {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            flex: 1;
        }
        .as-stat-icon {
            width: 42px; height: 42px;
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .as-stat-icon i { font-size: 1rem; }
        .as-stat-camp { background: var(--cl-red-glow); }
        .as-stat-camp i { color: var(--cl-red); }
        .as-stat-amt { background: var(--cl-green-soft); }
        .as-stat-amt i { color: var(--cl-green); }
        .as-stat-info {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
        }
        .as-stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--cl-dark);
            line-height: 1.2;
            transition: color 0.35s ease;
        }
        .as-stat-label {
            font-size: 0.72rem;
            color: var(--cl-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            transition: color 0.35s ease;
        }
        .as-stat-divider {
            width: 1px;
            height: 36px;
            background: var(--cl-border);
            margin: 0 1rem;
            transition: background 0.35s ease;
        }

        /* ══════════════ CAMPAIGNS SECTION ══════════════ */
        .as-campaigns-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        .as-campaigns-title {
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--cl-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
            transition: color 0.35s ease;
        }
        .as-campaigns-title i { color: var(--cl-red); }
        .as-campaigns-count {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--cl-muted);
            background: var(--cl-light);
            padding: 0.3rem 0.7rem;
            border-radius: var(--radius-full);
            transition: all 0.35s ease;
        }

        /* Empty State */
        .as-campaigns-empty {
            text-align: center;
            padding: 3rem 2rem;
            background: var(--cl-card-bg);
            border: 2px dashed var(--cl-border);
            border-radius: var(--radius-xl);
            transition: all 0.35s ease;
        }
        .as-campaigns-empty-icon {
            width: 64px; height: 64px;
            background: var(--cl-light);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
        }
        .as-campaigns-empty-icon i { font-size: 1.5rem; color: var(--cl-muted); }
        .as-campaigns-empty h6 {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--cl-dark);
            margin-bottom: 0.4rem;
            transition: color 0.35s ease;
        }
        .as-campaigns-empty p {
            font-size: 0.88rem;
            color: var(--cl-muted);
            margin: 0;
        }

        /* Campaign Card */
        .as-camp-card {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.22, 1, 0.36, 1), background-color 0.35s ease, border-color 0.35s ease;
            display: flex;
            flex-direction: column;
        }
        .as-camp-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: transparent;
        }
        .as-camp-inner {
            padding: 1.25rem;
        }

        /* Campaign Top */
        .as-camp-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.85rem;
        }
        .as-camp-status {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--cl-green);
            background: var(--cl-green-soft);
            padding: 0.2rem 0.55rem;
            border-radius: var(--radius-full);
            transition: all 0.35s ease;
        }
        .as-camp-dot {
            width: 5px; height: 5px;
            background: var(--cl-green);
            border-radius: 50%;
        }
        .as-camp-deadline {
            font-size: 0.72rem;
            color: var(--cl-muted);
            display: flex;
            align-items: center;
            gap: 0.25rem;
            transition: color 0.35s ease;
        }
        .as-camp-deadline i { font-size: 0.7rem; }

        /* Campaign Title */
        .as-camp-title {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 0.92rem;
            line-height: 1.35;
            color: var(--cl-dark);
            margin-bottom: 0;
            transition: color 0.35s ease;
        }

        /* Campaign Progress */
        .as-camp-progress {
            margin-top: auto;
        }
        .as-camp-track {
            height: 5px;
            background: var(--cl-light);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: 0.5rem;
            transition: background 0.35s ease;
        }
        .as-camp-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--cl-red), #f87171);
            border-radius: var(--radius-full);
            position: relative;
        }
        .as-camp-fill::after {
            content: '';
            position: absolute;
            right: 0; top: 0; bottom: 0;
            width: 14px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4));
            border-radius: 0 var(--radius-full) var(--radius-full) 0;
        }
        .as-camp-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
        }
        .as-camp-raised {
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--cl-dark);
            transition: color 0.35s ease;
        }
        .as-camp-pct {
            font-weight: 700;
            font-size: 0.78rem;
            color: var(--cl-red);
            background: var(--cl-red-glow);
            padding: 0.12rem 0.45rem;
            border-radius: var(--radius-full);
            transition: all 0.35s ease;
        }
        .as-camp-goal {
            font-size: 0.75rem;
            color: var(--cl-muted);
            transition: color 0.35s ease;
        }

        /* Campaign Button */
        .as-camp-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            width: 100%;
            margin-top: 0.85rem;
            background: transparent;
            color: var(--cl-body);
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-full);
            padding: 0.5rem;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .as-camp-btn:hover {
            border-color: var(--cl-red);
            color: var(--cl-red);
            background: var(--cl-red-glow);
        }
        .as-camp-btn i {
            font-size: 0.8rem;
            transition: transform 0.2s ease;
        }
        .as-camp-btn:hover i { transform: translateX(3px); }

        /* ══════════════ RESPONSIVE ══════════════ */
        @media (max-width: 991.98px) {
            .as-stats-card { flex-direction: column; gap: 1rem; }
            .as-stat-divider { width: 100%; height: 1px; margin: 0; }
        }
        @media (max-width: 767.98px) {
            .assoc-show-card { padding: 1.5rem; }
            .as-avatar { width: 52px; height: 52px; }
            .as-avatar i { font-size: 1.3rem; }
            .as-name { font-size: 1.3rem; }
        }
    </style>
</x-app-layout>
