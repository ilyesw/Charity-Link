<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label"><i class="bi bi-megaphone-fill"></i> Détail de la campagne</div>
            <h2 class="mb-0" style="font-size:1.5rem;">{{ Str::limit($campaign->title, 45) }}</h2>
            <p class="header-sub mb-0">Suivez l'avancement et contribuez à cette cause.</p>
        </div>
    </x-slot>

    <!-- Back Link -->
    <a href="{{ route('campaigns.index') }}" class="show-back">
        <i class="bi bi-arrow-left"></i>
        Retour aux campagnes
    </a>

    <div class="row g-4">

        <!-- ═══ LEFT COLUMN ═══ -->
        <div class="col-lg-7">
            <div class="show-main-card">

                <!-- Category & Status -->
                <div class="show-top-row">
                    <span class="show-badge-cat">
                        <i class="bi bi-tag-fill"></i>
                        {{ ucfirst($campaign->association->category ?? 'Humanitaire') }}
                    </span>
                    <span class="show-badge-status">
                        <span class="show-status-dot"></span>
                        Active
                    </span>
                </div>

                <!-- Title -->
                <h1 class="show-title">{{ $campaign->title }}</h1>

                <!-- Association Card -->
                <a href="{{ route('associations.show', $campaign->association) }}" class="show-assoc-card">
                    <div class="show-assoc-avatar">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="show-assoc-info">
                        <span class="show-assoc-label">Publiée par</span>
                        <span class="show-assoc-name">{{ $campaign->association->name }}</span>
                        <span class="show-assoc-region">
                            <i class="bi bi-geo-alt-fill"></i>
                            {{ $campaign->association->region }}
                        </span>
                    </div>
                    <i class="bi bi-chevron-right show-assoc-arrow"></i>
                </a>

                <!-- Description -->
                <div class="show-section">
                    <h6 class="show-section-title">
                        <i class="bi bi-file-text"></i>
                        À propos de cette campagne
                    </h6>
                    <div class="show-description">{{ $campaign->description }}</div>
                </div>

                <!-- Deadline -->
                @if($campaign->deadline)
                    <div class="show-deadline-card">
                        <div class="show-deadline-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div>
                            <span class="show-deadline-label">Date limite</span>
                            <span class="show-deadline-date">{{ $campaign->deadline->format('d/m/Y') }}</span>
                        </div>
                        @php
                            $daysLeft = now()->startOfDay()->diffInDays($campaign->deadline->startOfDay(), false);
                            $isUrgent = $daysLeft <= 7 && $daysLeft > 0;
                            $isExpired = $daysLeft < 0;
                        @endphp
                        @if($isExpired)
                            <span class="show-deadline-badge show-badge-expired">Expirée</span>
                        @elseif($isUrgent)
                            <span class="show-deadline-badge show-badge-urgent">
                                <span class="show-urgent-dot"></span>
                                {{ $daysLeft }}j restants
                            </span>
                        @else
                            <span class="show-deadline-badge show-badge-ok">{{ $daysLeft }}j restants</span>
                        @endif
                    </div>
                @endif

                <!-- Association Actions -->
                @auth
                    @if(auth()->user()->id === $campaign->association->user_id)
                        <div class="show-owner-actions">
                            <a href="{{ route('campaigns.edit', $campaign) }}" class="show-btn-edit">
                                <i class="bi bi-pencil"></i> Modifier la campagne
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <!-- ═══ RIGHT COLUMN ═══ -->
        <div class="col-lg-5">
            <div class="show-sidebar" style="position: sticky; top: 90px;">

                <!-- Progress Card -->
                <div class="show-progress-card">
                    <div class="show-progress-header">
                        <span class="show-progress-label">
                            <i class="bi bi-graph-up-arrow"></i>
                            Progression de la collecte
                        </span>
                    </div>

                    <div class="show-progress-amount-wrap">
                        <span class="show-progress-amount">{{ number_format($campaign->current_amount, 0) }}</span>
                        <span class="show-progress-currency">DT</span>
                    </div>
                    <div class="show-progress-sub">collectés sur {{ number_format($campaign->goal_amount, 0) }} DT</div>

                    <div class="show-progress-track">
                        <div class="show-progress-fill" style="width: {{ $campaign->progressPercentage() }}%;"></div>
                    </div>

                    <div class="show-progress-meta">
                        <div class="show-progress-pct">{{ $campaign->progressPercentage() }}%</div>
                        <div class="show-progress-remaining">
                            @php $remaining = $campaign->goal_amount - $campaign->current_amount; @endphp
                            @if($remaining > 0)
                                Il reste {{ number_format($remaining, 0) }} DT
                            @else
                                Objectif atteint ! 🎉
                            @endif
                        </div>
                    </div>

                    <!-- Donate Button -->
                    @auth
                        @if(auth()->user()->isDonateur())
                            <a href="{{ route('donations.create', $campaign) }}" class="show-btn-donate">
                                <i class="bi bi-heart-fill"></i>
                                Faire un don
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="show-btn-donate show-btn-donate-outline">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Connectez-vous pour donner
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="show-btn-donate show-btn-donate-outline">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Connectez-vous pour donner
                        </a>
                    @endauth

                    <!-- Chatbot Link -->
                    <a href="{{ route('chatbot.index') }}" class="show-chatbot-link">
                        <div class="show-chatbot-icon">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div>
                            <span class="show-chatbot-title">Besoin d'aide ?</span>
                            <span class="show-chatbot-sub">Parler à l'assistant IA</span>
                        </div>
                        <i class="bi bi-chevron-right show-chatbot-arrow"></i>
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="show-trust-row">
                    <div class="show-trust-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Association vérifiée</span>
                    </div>
                    <div class="show-trust-item">
                        <i class="bi bi-lock-fill"></i>
                        <span>Don sécurisé</span>
                    </div>
                    <div class="show-trust-item">
                        <i class="bi bi-eye-fill"></i>
                        <span>Transparent</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* ══════════════ BACK LINK ══════════════ */
        .show-back {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--cl-muted);
            text-decoration: none;
            padding: 0.5rem 0;
            margin-bottom: 1.5rem;
            transition: color 0.2s ease;
        }
        .show-back:hover { color: var(--cl-red); }

        /* ══════════════ MAIN CARD ══════════════ */
        .show-main-card {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-xl);
            padding: 2rem;
            transition: all 0.35s ease;
        }

        /* Top Row */
        .show-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }
        .show-badge-cat {
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
        html.dark .show-badge-cat { color: #93bbfd; }
        .show-badge-status {
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
        .show-status-dot {
            width: 6px; height: 6px;
            background: var(--cl-green);
            border-radius: 50%;
            position: relative;
        }
        .show-status-dot::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 50%;
            border: 1.5px solid var(--cl-green);
            animation: pulse-ring 2s ease-out infinite;
        }

        /* Title */
        .show-title {
            font-size: clamp(1.4rem, 3vw, 1.85rem);
            font-weight: 700;
            line-height: 1.25;
            margin-bottom: 1.5rem;
            color: var(--cl-dark);
            transition: color 0.35s ease;
        }

        /* Association Card */
        .show-assoc-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--cl-light);
            border: 1px solid var(--cl-border);
            border-radius: var(--radius-lg);
            text-decoration: none;
            margin-bottom: 1.75rem;
            transition: all 0.25s ease;
        }
        .show-assoc-card:hover {
            border-color: var(--cl-red);
            background: var(--cl-red-glow);
        }
        .show-assoc-avatar {
            width: 48px; height: 48px;
            background: var(--cl-card-bg);
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: var(--shadow-sm);
            transition: all 0.35s ease;
        }
        .show-assoc-avatar i { font-size: 1.15rem; color: var(--cl-red); }
        .show-assoc-info {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
            flex: 1;
        }
        .show-assoc-label {
            font-size: 0.72rem;
            color: var(--cl-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 500;
            transition: color 0.35s ease;
        }
        .show-assoc-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--cl-dark);
            transition: color 0.35s ease;
        }
        .show-assoc-region {
            font-size: 0.78rem;
            color: var(--cl-muted);
            display: flex;
            align-items: center;
            gap: 0.25rem;
            transition: color 0.35s ease;
        }
        .show-assoc-region i { color: var(--cl-green); font-size: 0.7rem; }
        .show-assoc-arrow {
            font-size: 0.9rem;
            color: var(--cl-muted);
            transition: all 0.2s ease;
        }
        .show-assoc-card:hover .show-assoc-arrow {
            color: var(--cl-red);
            transform: translateX(3px);
        }

        /* Section */
        .show-section {
            margin-bottom: 1.75rem;
        }
        .show-section-title {
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--cl-dark);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.35s ease;
        }
        .show-section-title i { color: var(--cl-red); font-size: 0.85rem; }
        .show-description {
            font-size: 0.92rem;
            color: var(--cl-body);
            line-height: 1.8;
            transition: color 0.35s ease;
        }

        /* Deadline Card */
        .show-deadline-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.25rem;
            background: var(--cl-light);
            border: 1px solid var(--cl-border);
            border-radius: var(--radius-lg);
            transition: all 0.35s ease;
        }
        .show-deadline-icon {
            width: 44px; height: 44px;
            background: var(--cl-red-glow);
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .show-deadline-icon i { font-size: 1.1rem; color: var(--cl-red); }
        .show-deadline-label {
            display: block;
            font-size: 0.72rem;
            color: var(--cl-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 500;
            transition: color 0.35s ease;
        }
        .show-deadline-date {
            display: block;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--cl-dark);
            transition: color 0.35s ease;
        }
        .show-deadline-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.3rem 0.7rem;
            border-radius: var(--radius-full);
            margin-left: auto;
            flex-shrink: 0;
        }
        .show-badge-ok { background: var(--cl-green-soft); color: var(--cl-green); }
        .show-badge-urgent { background: rgba(245,166,35,0.12); color: #B8860B; }
        .show-badge-expired { background: var(--cl-red-soft); color: var(--cl-red); }
        .show-urgent-dot {
            width: 6px; height: 6px;
            background: #F5A623;
            border-radius: 50%;
            animation: pulse-ring 1.5s ease-out infinite;
        }

        /* Owner Actions */
        .show-owner-actions {
            padding-top: 1.25rem;
            border-top: 1px solid var(--cl-border);
            margin-top: 1.75rem;
            transition: border-color 0.35s ease;
        }
        .show-btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--cl-muted);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
        }
        .show-btn-edit:hover { color: var(--cl-dark); background: var(--cl-light); }

        /* ══════════════ SIDEBAR ══════════════ */
        .show-sidebar { display: flex; flex-direction: column; gap: 1rem; }

        .show-progress-card {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-xl);
            padding: 1.75rem;
            transition: all 0.35s ease;
        }
        .show-progress-header {
            margin-bottom: 1.5rem;
        }
        .show-progress-label {
            font-family: 'Inter', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--cl-muted);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: color 0.35s ease;
        }
        .show-progress-label i { color: var(--cl-red); }

        .show-progress-amount-wrap {
            text-align: center;
            margin-bottom: 0.35rem;
        }
        .show-progress-amount {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--cl-red);
            line-height: 1;
            transition: color 0.35s ease;
        }
        .show-progress-currency {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--cl-red);
            opacity: 0.6;
            transition: color 0.35s ease;
        }
        .show-progress-sub {
            text-align: center;
            font-size: 0.82rem;
            color: var(--cl-muted);
            margin-bottom: 1.25rem;
            transition: color 0.35s ease;
        }
        .show-progress-track {
            height: 8px;
            background: var(--cl-light);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: 0.75rem;
            transition: background 0.35s ease;
        }
        .show-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--cl-red), #f87171);
            border-radius: var(--radius-full);
            position: relative;
            transition: width 1.2s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .show-progress-fill::after {
            content: '';
            position: absolute;
            right: 0; top: 0; bottom: 0;
            width: 20px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.45));
            border-radius: 0 var(--radius-full) var(--radius-full) 0;
        }
        .show-progress-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .show-progress-pct {
            font-weight: 800;
            font-size: 1rem;
            color: var(--cl-red);
            background: var(--cl-red-glow);
            padding: 0.25rem 0.65rem;
            border-radius: var(--radius-full);
            transition: all 0.35s ease;
        }
        .show-progress-remaining {
            font-size: 0.8rem;
            color: var(--cl-muted);
            font-weight: 500;
            transition: color 0.35s ease;
        }

        /* Donate Button */
        .show-btn-donate {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            background: var(--cl-red);
            color: #fff;
            border: none;
            border-radius: var(--radius-full);
            padding: 0.9rem;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            position: relative;
            overflow: hidden;
        }
        .show-btn-donate::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .show-btn-donate:hover {
            background: var(--cl-red-hover);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(230,57,70,0.35);
        }
        .show-btn-donate:hover::before { opacity: 1; }
        .show-btn-donate-outline {
            background: transparent;
            border: 2px solid var(--cl-red);
            color: var(--cl-red);
        }
        .show-btn-donate-outline:hover {
            background: var(--cl-red);
            color: #fff;
        }

        /* Chatbot Link */
        .show-chatbot-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.85rem 1rem;
            background: var(--cl-light);
            border: 1px solid var(--cl-border);
            border-radius: var(--radius-lg);
            text-decoration: none;
            margin-top: 1rem;
            transition: all 0.25s ease;
        }
        .show-chatbot-link:hover {
            border-color: var(--cl-blue);
            background: var(--cl-blue-soft);
        }
        .show-chatbot-icon {
            width: 38px; height: 38px;
            background: var(--cl-blue-soft);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: all 0.35s ease;
        }
        .show-chatbot-icon i { font-size: 1rem; color: var(--cl-blue); }
        html.dark .show-chatbot-icon i { color: #93bbfd; }
        html.dark .show-chatbot-icon { background: rgba(29,53,87,0.3); }
        .show-chatbot-title {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--cl-dark);
            transition: color 0.35s ease;
        }
        .show-chatbot-sub {
            display: block;
            font-size: 0.75rem;
            color: var(--cl-muted);
            transition: color 0.35s ease;
        }
        .show-chatbot-arrow {
            font-size: 0.85rem;
            color: var(--cl-muted);
            margin-left: auto;
            transition: all 0.2s ease;
        }
        .show-chatbot-link:hover .show-chatbot-arrow {
            color: var(--cl-blue);
            transform: translateX(3px);
        }

        /* Trust Row */
        .show-trust-row {
            display: flex;
            justify-content: center;
            gap: 1.25rem;
            padding: 1rem;
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-lg);
            transition: all 0.35s ease;
        }
        .show-trust-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--cl-muted);
            transition: color 0.35s ease;
        }
        .show-trust-item i {
            font-size: 0.85rem;
            color: var(--cl-green);
        }

        /* ══════════════ RESPONSIVE ══════════════ */
        @media (max-width: 991.98px) {
            .show-sidebar { position: static !important; }
        }
        @media (max-width: 767.98px) {
            .show-main-card { padding: 1.5rem; }
            .show-progress-card { padding: 1.5rem; }
            .show-progress-amount { font-size: 2rem; }
            .show-trust-row { flex-direction: column; align-items: center; gap: 0.6rem; }
            .show-deadline-card { flex-wrap: wrap; }
            .show-deadline-badge { margin-left: 0; margin-top: 0.25rem; }
        }
    </style>
</x-app-layout>
