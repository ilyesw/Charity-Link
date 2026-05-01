<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-2">
            <div>
                <div class="section-label"><i class="bi bi-megaphone-fill"></i> Campagnes actives</div>
                <h2 class="mb-0" style="font-size:1.5rem;">Soutenez les causes urgentes</h2>
                <p class="header-sub mb-0">Lancées par les associations tunisiennes vérifiées.</p>
            </div>
            @auth
                @if(auth()->user()->isAssociation())
                    <a href="{{ route('campaigns.create') }}" class="btn btn-primary flex-shrink-0">
                        <i class="bi bi-plus-lg me-1"></i> Publier une campagne
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center" style="border-radius:var(--radius-md);">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Filters Bar -->
    <div class="camp-filters mb-4">
        <div class="camp-count">
            <span class="camp-count-num">{{ $campaigns->total() }}</span>
            <span class="camp-count-label">campagne(s) active(s)</span>
        </div>
    </div>

    @if($campaigns->isEmpty())
        <div class="camp-empty">
            <div class="camp-empty-icon"><i class="bi bi-megaphone"></i></div>
            <h5>Aucune campagne active</h5>
            <p>Revenez bientôt, de nouvelles campagnes sont en préparation.</p>
            <a href="/" class="btn btn-outline-primary btn-sm mt-3">
                <i class="bi bi-house me-1"></i> Retour à l'accueil
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach($campaigns as $campaign)
                <div class="col-md-6 col-lg-4">
                    <div class="camp-card h-100">
                        <div class="camp-card-inner d-flex flex-column h-100">

                            <!-- Top Row: Category + Status -->
                            <div class="camp-top-row">
                                <span class="camp-badge-cat">
                                    <i class="bi bi-tag-fill"></i>
                                    {{ ucfirst($campaign->association->category ?? 'Humanitaire') }}
                                </span>
                                <span class="camp-badge-status">
                                    <span class="camp-status-dot"></span>
                                    Active
                                </span>
                            </div>

                            <!-- Association -->
                            <div class="camp-assoc">
                                <div class="camp-assoc-avatar">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div>
                                    <div class="camp-assoc-name">{{ $campaign->association->name }}</div>
                                    <div class="camp-assoc-region">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        {{ $campaign->association->region }}
                                    </div>
                                </div>
                            </div>

                            <!-- Title -->
                            <h5 class="camp-title">{{ $campaign->title }}</h5>

                            <!-- Description -->
                            <p class="camp-desc">{{ Str::limit($campaign->description, 100) }}</p>

                            <!-- Spacer -->
                            <div class="flex-grow-1"></div>

                            <!-- Progress -->
                            <div class="camp-progress-section">
                                <div class="camp-progress-track">
                                    <div class="camp-progress-fill" style="width: {{ $campaign->progressPercentage() }}%;"></div>
                                </div>
                                <div class="camp-progress-info">
                                    <div>
                                        <span class="camp-raised">{{ number_format($campaign->current_amount, 0) }} DT</span>
                                        <span class="camp-raised-label">collectés</span>
                                    </div>
                                    <div class="camp-progress-pct">{{ $campaign->progressPercentage() }}%</div>
                                    <div class="camp-goal">
                                        Objectif : {{ number_format($campaign->goal_amount, 0) }} DT
                                    </div>
                                </div>
                            </div>

                            <!-- Deadline -->
                            @if($campaign->deadline)
                                <div class="camp-deadline">
                                    <i class="bi bi-clock"></i>
                                    <span>Expire le {{ $campaign->deadline->format('d/m/Y') }}</span>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="camp-actions">
                                @auth
                                    @if(auth()->user()->id === $campaign->association->user_id)
                                        <a href="{{ route('campaigns.edit', $campaign) }}" class="camp-btn-edit">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </a>
                                    @else
                                        <span></span>
                                    @endif
                                @else
                                    <span></span>
                                @endauth
                                <a href="{{ route('campaigns.show', $campaign) }}" class="camp-btn-donate">
                                    <i class="bi bi-heart-fill"></i> Contribuer
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $campaigns->links('pagination::bootstrap-5') }}
        </div>
    @endif

    <style>
        /* ══════════════ FILTERS BAR ══════════════ */
        .camp-filters {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .camp-count {
            display: flex;
            align-items: baseline;
            gap: 0.5rem;
        }
        .camp-count-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--cl-dark);
        }
        .camp-count-label {
            font-size: 0.88rem;
            color: var(--cl-muted);
        }

        /* ══════════════ EMPTY STATE ══════════════ */
        .camp-empty {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--cl-card-bg);
            border: 2px dashed var(--cl-border);
            border-radius: var(--radius-xl);
            transition: all 0.35s ease;
        }
        .camp-empty-icon {
            width: 72px; height: 72px;
            background: var(--cl-red-glow);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
        }
        .camp-empty-icon i { font-size: 1.75rem; color: var(--cl-red); }
        .camp-empty h5 {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--cl-dark);
            margin-bottom: 0.5rem;
        }
        .camp-empty p {
            font-size: 0.9rem;
            color: var(--cl-muted);
            margin: 0;
        }

        /* ══════════════ CAMPAIGN CARD ══════════════ */
        .camp-card {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-xl);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1), background-color 0.35s ease, border-color 0.35s ease;
            display: flex;
            flex-direction: column;
        }
        .camp-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-xl);
            border-color: transparent;
        }
        .camp-card-inner {
            padding: 1.5rem;
        }

        /* Top Row */
        .camp-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .camp-badge-cat {
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
        html.dark .camp-badge-cat { color: #93bbfd; }
        .camp-badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--cl-green);
            background: var(--cl-green-soft);
            padding: 0.25rem 0.6rem;
            border-radius: var(--radius-full);
            transition: all 0.35s ease;
        }
        .camp-status-dot {
            width: 6px; height: 6px;
            background: var(--cl-green);
            border-radius: 50%;
            position: relative;
        }
        .camp-status-dot::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 50%;
            border: 1.5px solid var(--cl-green);
            animation: pulse-ring 2s ease-out infinite;
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.9); opacity: 1; }
            100% { transform: scale(1.8); opacity: 0; }
        }

        /* Association */
        .camp-assoc {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 0.85rem;
        }
        .camp-assoc-avatar {
            width: 34px; height: 34px;
            background: var(--cl-light);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: background 0.35s ease;
        }
        .camp-assoc-avatar i { font-size: 0.85rem; color: var(--cl-muted); }
        .camp-assoc-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--cl-dark);
            transition: color 0.35s ease;
        }
        .camp-assoc-region {
            font-size: 0.72rem;
            color: var(--cl-muted);
            display: flex;
            align-items: center;
            gap: 0.2rem;
            transition: color 0.35s ease;
        }
        .camp-assoc-region i { color: var(--cl-green); font-size: 0.65rem; }

        /* Title */
        .camp-title {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1.02rem;
            line-height: 1.4;
            color: var(--cl-dark);
            margin-bottom: 0.5rem;
            transition: color 0.35s ease;
        }

        /* Description */
        .camp-desc {
            font-size: 0.85rem;
            color: var(--cl-muted);
            line-height: 1.65;
            margin-bottom: 1.25rem;
            transition: color 0.35s ease;
        }

        /* Progress */
        .camp-progress-section {
            margin-bottom: 1rem;
        }
        .camp-progress-track {
            height: 6px;
            background: var(--cl-light);
            border-radius: var(--radius-full);
            overflow: hidden;
            transition: background 0.35s ease;
        }
        .camp-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--cl-red), #f87171);
            border-radius: var(--radius-full);
            position: relative;
            transition: width 1.2s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .camp-progress-fill::after {
            content: '';
            position: absolute;
            right: 0; top: 0; bottom: 0;
            width: 18px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.45));
            border-radius: 0 var(--radius-full) var(--radius-full) 0;
        }
        .camp-progress-info {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-top: 0.6rem;
            gap: 0.5rem;
        }
        .camp-raised {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--cl-dark);
            display: block;
            transition: color 0.35s ease;
        }
        .camp-raised-label {
            font-size: 0.7rem;
            color: var(--cl-muted);
            display: block;
            transition: color 0.35s ease;
        }
        .camp-progress-pct {
            font-weight: 800;
            font-size: 0.85rem;
            color: var(--cl-red);
            background: var(--cl-red-glow);
            padding: 0.15rem 0.5rem;
            border-radius: var(--radius-full);
            transition: all 0.35s ease;
        }
        .camp-goal {
            font-size: 0.75rem;
            color: var(--cl-muted);
            text-align: right;
            transition: color 0.35s ease;
        }

        /* Deadline */
        .camp-deadline {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.78rem;
            color: var(--cl-muted);
            margin-bottom: 1rem;
            padding: 0.4rem 0.7rem;
            background: var(--cl-light);
            border-radius: var(--radius-sm);
            width: fit-content;
            transition: all 0.35s ease;
        }
        .camp-deadline i { font-size: 0.8rem; }

        /* Actions */
        .camp-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid var(--cl-border);
            transition: border-color 0.35s ease;
        }
        .camp-btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--cl-muted);
            text-decoration: none;
            padding: 0.4rem 0.75rem;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
        }
        .camp-btn-edit:hover {
            color: var(--cl-dark);
            background: var(--cl-light);
        }
        .camp-btn-donate {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: var(--cl-red);
            color: #fff;
            border: none;
            border-radius: var(--radius-full);
            padding: 0.55rem 1.15rem;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .camp-btn-donate:hover {
            background: var(--cl-red-hover);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(230,57,70,0.3);
        }
    </style>
</x-app-layout>
