{{-- Dashboard Association  resources\views\dashboard\association.blade.php--}}
@php
    use App\Models\Association;
    $association = Association::where('user_id', auth()->id())->first();
@endphp

@if(!$association)
    <div class="dassoc-empty-card">
        <div class="dassoc-empty-icon">
            <i class="bi bi-building-add"></i>
        </div>
        <h3 class="dassoc-empty-title">Créez votre profil association</h3>
        <p class="dassoc-empty-text">
            Complétez votre profil pour publier des campagnes et recevoir des dons.
        </p>
        <a href="{{ route('associations.create') }}" class="dassoc-empty-btn">
            <i class="bi bi-plus-lg"></i>
            Créer mon profil
        </a>
    </div>
@else
    @php
        $campaigns = $association->campaigns()->latest()->get();
        $totalDons = 0;
        $totalDonateurs = 0;
        foreach($campaigns as $campaign) {
            $totalDons += $campaign->current_amount;
            $totalDonateurs += $campaign->donations()->count();
        }
        $donsEnAttente = \App\Models\Donation::whereIn('campaign_id', $campaigns->pluck('id'))
            ->where('status', 'en_attente')
            ->with(['user', 'campaign'])
            ->latest()
            ->get();
    @endphp

    {{-- Banner --}}
    <div class="dassoc-banner">
        <div class="dassoc-banner-left">
            <div class="dassoc-banner-icon">
                <i class="bi bi-building"></i>
            </div>
            <div>
                <div class="dassoc-banner-name">{{ $association->name }}</div>
                <div class="dassoc-banner-meta">
                    @if($association->status === 'validee')
                        <span class="dassoc-badge dassoc-badge--green">
                            <i class="bi bi-check-circle-fill"></i> Validée
                        </span>
                    @elseif($association->status === 'en_attente')
                        <span class="dassoc-badge dassoc-badge--orange">
                            <i class="bi bi-hourglass-split"></i> En attente
                        </span>
                    @else
                        <span class="dassoc-badge dassoc-badge--red">
                            <i class="bi bi-x-circle-fill"></i> Rejetée
                        </span>
                    @endif
                    @if($association->region)
                        <span class="dassoc-banner-region">
                            <i class="bi bi-geo-alt"></i> {{ $association->region }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <a href="{{ route('associations.edit', $association) }}" class="dassoc-banner-edit">
            <i class="bi bi-pencil"></i> Modifier
        </a>
    </div>

    {{-- Stats --}}
    <div class="dassoc-stats">
        <div class="dassoc-stat">
            <div class="dassoc-stat-icon dassoc-stat-icon--red">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="dassoc-stat-value">{{ number_format($totalDons, 0) }} DT</div>
            <div class="dassoc-stat-label">Total collecté</div>
        </div>
        <div class="dassoc-stat">
            <div class="dassoc-stat-icon dassoc-stat-icon--blue">
                <i class="bi bi-megaphone"></i>
            </div>
            <div class="dassoc-stat-value">{{ $campaigns->count() }}</div>
            <div class="dassoc-stat-label">Campagnes</div>
        </div>
        <div class="dassoc-stat">
            <div class="dassoc-stat-icon dassoc-stat-icon--green">
                <i class="bi bi-people"></i>
            </div>
            <div class="dassoc-stat-value">{{ $totalDonateurs }}</div>
            <div class="dassoc-stat-label">Contributions reçues</div>
        </div>
    </div>

    {{-- Campagnes --}}
    <div class="dassoc-card">
        <div class="dassoc-card-head">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-megaphone dassoc-card-icon"></i>
                <span class="dassoc-card-title">Mes campagnes</span>
            </div>
            <a href="{{ route('campaigns.create') }}" class="dassoc-add-btn">
                <i class="bi bi-plus-lg"></i> Nouvelle
            </a>
        </div>
        <div class="dassoc-card-body">
            @if($campaigns->isEmpty())
                <div class="dassoc-list-empty">
                    <i class="bi bi-inbox"></i>
                    <span>Aucune campagne créée pour le moment.</span>
                </div>
            @else
                <div class="dassoc-campaigns">
                    @foreach($campaigns as $campaign)
                        <div class="dassoc-campaign">
                            <div class="dassoc-campaign-top">
                                <div class="dassoc-campaign-name">{{ $campaign->title }}</div>
                                <div class="dassoc-campaign-right">
                                    @if($campaign->status === 'active')
                                        <span class="dassoc-badge dassoc-badge--green">Active</span>
                                    @else
                                        <span class="dassoc-badge dassoc-badge--red">{{ ucfirst($campaign->status) }}</span>
                                    @endif
                                    <a href="{{ route('campaigns.edit', $campaign) }}" class="dassoc-campaign-edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="dassoc-progress">
                                <div class="dassoc-progress-bar" style="width: {{ $campaign->progressPercentage() }}%;"></div>
                            </div>
                            <div class="dassoc-progress-info">
                                <span class="dassoc-progress-amount">{{ number_format($campaign->current_amount, 0) }} DT</span>
                                <span class="dassoc-progress-pct">{{ $campaign->progressPercentage() }}%</span>
                                <span class="dassoc-progress-goal">Objectif : {{ number_format($campaign->goal_amount, 0) }} DT</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ═══ DONS EN ATTENTE ═══ --}}
    @if($donsEnAttente->count() > 0)
    <div class="dassoc-card" style="border-color: rgba(245,158,11,0.3);">
        <div class="dassoc-card-head" style="background: rgba(245,158,11,0.04);">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-hourglass-split" style="font-size:1rem; color:#D97706;"></i>
                <span class="dassoc-card-title">Dons en attente de validation</span>
                <span style="background:rgba(245,158,11,0.12); color:#D97706; font-size:0.72rem; font-weight:700; padding:0.15rem 0.55rem; border-radius:999px;">
                    {{ $donsEnAttente->count() }}
                </span>
            </div>
        </div>
        <div class="dassoc-card-body" style="padding-top:0.85rem;">
            @if(session('success'))
                <div style="display:flex; align-items:center; gap:0.5rem; padding:0.65rem 0.9rem; background:var(--cl-green-soft, rgba(45,198,83,0.08)); border:1px solid rgba(45,198,83,0.2); border-radius:var(--radius-md); font-size:0.82rem; color:#1A8C38; margin-bottom:0.85rem;">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif
            <div class="dassoc-don-list">
                @foreach($donsEnAttente as $don)
                    <div class="dassoc-don-item">

                        {{-- Avatar --}}
                        <div class="dassoc-don-avatar dassoc-don-avatar--{{ $don->type }}">
                            @if($don->type === 'financier') <i class="bi bi-cash"></i>
                            @elseif($don->type === 'nature') <i class="bi bi-box-seam"></i>
                            @else <i class="bi bi-tools"></i>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="dassoc-don-info">
                            <div class="dassoc-don-name">
                                {{ $don->is_anonymous ? 'Donateur anonyme' : ($don->user->name ?? 'N/A') }}
                                @if($don->is_anonymous)
                                    <span style="font-size:0.7rem; color:var(--cl-muted); font-weight:400;">(anonyme)</span>
                                @endif
                            </div>
                            <div class="dassoc-don-meta">
                                <span class="dassoc-don-campaign">
                                    <i class="bi bi-megaphone"></i> {{ $don->campaign->title }}
                                </span>
                                &nbsp;·&nbsp;
                                @if($don->type === 'financier')
                                    <strong style="color:var(--cl-red);">{{ number_format($don->amount, 0) }} DT</strong>
                                @elseif($don->type === 'nature')
                                    {{ $don->quantity }} × {{ $don->category }}
                                    @if($don->pickup_address)
                                        — <i class="bi bi-geo-alt"></i> {{ $don->pickup_address }}
                                    @endif
                                @else
                                    {{ $don->competence }}
                                    @if($don->availability)
                                        — {{ $don->availability }}
                                    @endif
                                @endif
                            </div>
                            @if($don->message)
                                <div class="dassoc-don-message">"{{ $don->message }}"</div>
                            @endif
                            <div class="dassoc-don-date">
                                <i class="bi bi-clock"></i> {{ $don->created_at->diffForHumans() }}
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="dassoc-don-actions">
                            <form method="POST" action="{{ route('donations.valider', $don) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="dassoc-don-btn dassoc-don-btn--accept">
                                    <i class="bi bi-check-lg"></i>
                                    <span>Valider</span>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('donations.refuser', $don) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="dassoc-don-btn dassoc-don-btn--refuse"
                                    onclick="return confirm('Refuser ce don ?')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Actions --}}
    <div class="dassoc-actions">
        <a href="{{ route('campaigns.create') }}" class="dassoc-action dassoc-action--red">
            <i class="bi bi-rocket-takeoff-fill"></i>
            <span>Publier campagne</span>
        </a>
        <a href="{{ route('associations.show', $association) }}" class="dassoc-action dassoc-action--outline">
            <i class="bi bi-eye-fill"></i>
            <span>Mon profil</span>
        </a>
    </div>
@endif

<style>
    .dassoc-empty-card {
        max-width: 420px;
        margin: 0 auto;
        text-align: center;
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl);
        padding: 3rem 2rem;
        box-shadow: var(--shadow-md);
        transition: all 0.35s ease;
    }
    .dassoc-empty-icon {
        width: 68px; height: 68px;
        border-radius: var(--radius-lg);
        background: var(--cl-blue-mid);
        display: inline-flex; align-items: center; justify-content: center;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(29,53,87,0.06);
        transition: all 0.35s ease;
    }
    .dassoc-empty-icon i { font-size: 1.65rem; color: var(--cl-blue); }
    .dassoc-empty-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700; font-size: 1.25rem;
        color: var(--cl-dark);
        margin-bottom: 0.5rem;
        transition: color 0.35s ease;
    }
    .dassoc-empty-text {
        font-size: 0.85rem; color: var(--cl-muted);
        line-height: 1.7; margin-bottom: 1.75rem;
        transition: color 0.35s ease;
    }
    .dassoc-empty-btn {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.65rem 1.5rem;
        background: var(--cl-red); color: #fff;
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.82rem;
        border-radius: var(--radius-md); text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(230,57,70,0.2);
    }
    .dassoc-empty-btn:hover {
        background: var(--cl-red-hover); color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(230,57,70,0.28);
        text-decoration: none;
    }
    .dassoc-banner {
        display: flex; align-items: center; justify-content: space-between;
        gap: 1rem; padding: 1.5rem;
        background: linear-gradient(135deg, var(--cl-blue), #2A4A73);
        border-radius: var(--radius-xl); margin-bottom: 1.5rem;
        transition: all 0.35s ease;
    }
    .dassoc-banner-left { display: flex; align-items: center; gap: 1rem; min-width: 0; }
    .dassoc-banner-icon {
        width: 52px; height: 52px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .dassoc-banner-icon i { font-size: 1.4rem; color: #fff; }
    .dassoc-banner-name {
        font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1.2rem;
        color: #fff; letter-spacing: -0.02em;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .dassoc-banner-meta { display: flex; align-items: center; gap: 0.6rem; margin-top: 0.35rem; flex-wrap: wrap; }
    .dassoc-banner-region { font-size: 0.8rem; color: rgba(255,255,255,0.5); }
    .dassoc-banner-region i { margin-right: 0.2rem; }
    .dassoc-banner-edit {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.45rem 1rem;
        background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.18);
        border-radius: var(--radius-full); color: rgba(255,255,255,0.85);
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.78rem;
        text-decoration: none; transition: all 0.2s ease; flex-shrink: 0;
    }
    .dassoc-banner-edit:hover { background: rgba(255,255,255,0.2); color: #fff; text-decoration: none; }
    .dassoc-badge {
        display: inline-flex; align-items: center; gap: 0.3rem;
        padding: 0.22rem 0.6rem; border-radius: var(--radius-full);
        font-size: 0.68rem; font-weight: 600; font-family: 'Inter', sans-serif;
    }
    .dassoc-badge i { font-size: 0.7rem; }
    .dassoc-badge--red { background: var(--cl-red-glow); color: var(--cl-red); }
    .dassoc-badge--green { background: var(--cl-green-glow); color: var(--cl-green); }
    .dassoc-badge--orange { background: rgba(245,166,35,0.1); color: #D4940A; }
    .dassoc-stats {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 0.85rem; margin-bottom: 1.5rem;
    }
    .dassoc-stat {
        background: var(--cl-card-bg); border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-lg); padding: 1.25rem 1rem;
        text-align: center; transition: all 0.25s ease; box-shadow: var(--shadow-xs);
    }
    .dassoc-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
    .dassoc-stat-icon {
        width: 42px; height: 42px; border-radius: var(--radius-sm);
        display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.65rem;
    }
    .dassoc-stat-icon i { font-size: 1.1rem; }
    .dassoc-stat-icon--red { background: var(--cl-red-glow); }
    .dassoc-stat-icon--red i { color: var(--cl-red); }
    .dassoc-stat-icon--blue { background: var(--cl-blue-mid); }
    .dassoc-stat-icon--blue i { color: var(--cl-blue); }
    .dassoc-stat-icon--green { background: var(--cl-green-glow); }
    .dassoc-stat-icon--green i { color: var(--cl-green); }
    .dassoc-stat-value {
        font-family: 'Inter', sans-serif; font-weight: 800; font-size: 1.5rem;
        color: var(--cl-dark); letter-spacing: -0.03em; line-height: 1.2; transition: color 0.35s ease;
    }
    .dassoc-stat-label { font-size: 0.75rem; color: var(--cl-muted); margin-top: 0.2rem; font-weight: 500; transition: color 0.35s ease; }
    .dassoc-card {
        background: var(--cl-card-bg); border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl); margin-bottom: 1.25rem;
        box-shadow: var(--shadow-xs); overflow: hidden; transition: all 0.35s ease;
    }
    .dassoc-card-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.1rem 1.35rem; border-bottom: 1px solid var(--cl-border); transition: border-color 0.35s ease;
    }
    .dassoc-card-icon { font-size: 1rem; color: var(--cl-red); }
    .dassoc-card-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.92rem; color: var(--cl-dark); transition: color 0.35s ease; }
    .dassoc-add-btn {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.35rem 0.85rem; background: var(--cl-red); color: #fff;
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.78rem;
        border-radius: var(--radius-full); text-decoration: none; transition: all 0.2s ease;
        border: none !important; outline: none !important; box-shadow: none !important;
    }
    .dassoc-add-btn:focus { outline: none !important; box-shadow: none !important; }
    .dassoc-add-btn:hover { background: var(--cl-red-hover); color: #fff; transform: translateY(-1px); box-shadow: 0 3px 10px rgba(230,57,70,0.25) !important; text-decoration: none; }
    .dassoc-add-btn i { font-size: 0.8rem; }
    .dassoc-card-body { padding: 0.5rem 1.35rem 1.1rem; }
    .dassoc-list-empty {
        display: flex; flex-direction: column; align-items: center;
        gap: 0.6rem; padding: 2.5rem 1rem; color: var(--cl-muted-light); font-size: 0.85rem;
    }
    .dassoc-list-empty i { font-size: 2.5rem; opacity: 0.5; }
    .dassoc-campaigns { display: flex; flex-direction: column; }
    .dassoc-campaign {
        background: var(--cl-light); border: 1px solid var(--cl-border);
        border-radius: var(--radius-lg); padding: 1rem 1.15rem; margin-bottom: 0.75rem; transition: all 0.25s ease;
    }
    .dassoc-campaign:last-child { margin-bottom: 0; }
    .dassoc-campaign:hover { box-shadow: var(--shadow-sm); }
    .dassoc-campaign-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; }
    .dassoc-campaign-name { font-weight: 700; font-size: 0.9rem; color: var(--cl-dark); transition: color 0.35s ease; }
    .dassoc-campaign-right { display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0; }
    .dassoc-campaign-edit {
        width: 30px; height: 30px; background: var(--cl-card-bg); border: 1px solid var(--cl-border);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        color: var(--cl-muted); text-decoration: none; transition: all 0.2s ease;
    }
    .dassoc-campaign-edit:hover { color: var(--cl-red); border-color: rgba(230,57,70,0.2); text-decoration: none; }
    .dassoc-campaign-edit i { font-size: 0.78rem; }
    .dassoc-progress {
        width: 100%; height: 7px; background: var(--cl-border);
        border-radius: 10px; overflow: hidden; margin-bottom: 0.6rem; transition: background 0.35s ease;
    }
    .dassoc-progress-bar {
        height: 100%; background: linear-gradient(90deg, var(--cl-red), #FF6B6B);
        border-radius: 10px; transition: width 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .dassoc-progress-info { display: flex; justify-content: space-between; font-size: 0.76rem; }
    .dassoc-progress-amount { font-weight: 700; color: var(--cl-blue); transition: color 0.35s ease; }
    .dassoc-progress-pct { font-weight: 800; color: var(--cl-red); }
    .dassoc-progress-goal { color: var(--cl-muted); transition: color 0.35s ease; }

    /* ─── Dons en attente ─── */
    .dassoc-don-list { display: flex; flex-direction: column; gap: 0.6rem; }
    .dassoc-don-item {
        display: flex; align-items: flex-start; gap: 0.85rem;
        padding: 0.9rem 1rem; background: var(--cl-light);
        border: 1px solid var(--cl-border); border-radius: var(--radius-lg); transition: all 0.2s ease;
    }
    .dassoc-don-item:hover { box-shadow: var(--shadow-sm); }
    .dassoc-don-avatar {
        width: 40px; height: 40px; flex-shrink: 0;
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center; font-size: 1rem;
    }
    .dassoc-don-avatar--financier { background: var(--cl-red-glow); color: var(--cl-red); }
    .dassoc-don-avatar--nature { background: rgba(45,198,83,0.08); color: var(--cl-green); }
    .dassoc-don-avatar--competences { background: var(--cl-blue-mid); color: var(--cl-blue); }
    .dassoc-don-info { flex: 1; min-width: 0; }
    .dassoc-don-name { font-weight: 700; font-size: 0.88rem; color: var(--cl-dark); }
    .dassoc-don-meta { font-size: 0.78rem; color: var(--cl-muted); margin-top: 0.15rem; }
    .dassoc-don-campaign { font-weight: 600; color: var(--cl-body); }
    .dassoc-don-message {
        font-size: 0.76rem; color: var(--cl-muted); font-style: italic;
        margin-top: 0.3rem; padding: 0.3rem 0.6rem;
        background: var(--cl-card-bg); border-left: 2px solid var(--cl-border);
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
    }
    .dassoc-don-date { font-size: 0.72rem; color: var(--cl-muted-light); margin-top: 0.25rem; }
    .dassoc-don-actions { display: flex; align-items: center; gap: 0.4rem; flex-shrink: 0; }
    .dassoc-don-btn {
        display: inline-flex; align-items: center; gap: 0.3rem;
        padding: 0.4rem 0.75rem;
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.78rem;
        border-radius: var(--radius-md); border: none; cursor: pointer; transition: all 0.2s ease;
    }
    .dassoc-don-btn--accept { background: var(--cl-green); color: #fff; }
    .dassoc-don-btn--accept:hover { background: #24a844; transform: translateY(-1px); }
    .dassoc-don-btn--refuse {
        background: var(--cl-light); color: var(--cl-muted);
        border: 1px solid var(--cl-border) !important; padding: 0.4rem 0.6rem;
    }
    .dassoc-don-btn--refuse:hover { background: var(--cl-red-glow); color: var(--cl-red); border-color: rgba(230,57,70,0.2) !important; }

    .dassoc-actions {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 0.85rem; margin-bottom: 1.5rem;
    }
    .dassoc-action {
        display: flex; align-items: center; justify-content: center;
        gap: 0.6rem; padding: 1rem; border-radius: var(--radius-lg);
        font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.88rem;
        text-decoration: none; transition: all 0.25s ease;
    }
    .dassoc-action i { font-size: 1.1rem; }
    .dassoc-action--red { background: var(--cl-red); color: #fff; box-shadow: 0 3px 12px rgba(230,57,70,0.2); }
    .dassoc-action--red:hover { background: var(--cl-red-hover); color: #fff; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(230,57,70,0.28); text-decoration: none; }
    .dassoc-action--outline { background: transparent; color: var(--cl-red); border: 1.5px solid var(--cl-red); }
    .dassoc-action--outline:hover { background: var(--cl-red-glow); color: var(--cl-red); transform: translateY(-2px); text-decoration: none; }

    @media (max-width: 767.98px) {
        .dassoc-banner { flex-direction: column; align-items: flex-start; padding: 1.15rem; gap: 0.75rem; }
        .dassoc-banner-edit { align-self: flex-start; }
        .dassoc-banner-name { font-size: 1.05rem; }
        .dassoc-stats { grid-template-columns: repeat(3, 1fr); gap: 0.6rem; }
        .dassoc-stat { padding: 1rem 0.75rem; }
        .dassoc-stat-value { font-size: 1.3rem; }
        .dassoc-campaign-top { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
        .dassoc-campaign-right { align-self: flex-end; }
        .dassoc-progress-info { flex-wrap: wrap; gap: 0.3rem; }
        .dassoc-card-head { padding: 0.95rem 1.1rem; }
        .dassoc-card-body { padding: 0.35rem 1.1rem 1rem; }
        .dassoc-don-item { flex-wrap: wrap; }
        .dassoc-don-actions { width: 100%; justify-content: flex-end; }
    }
    @media (max-width: 575.98px) {
        .dassoc-stats { grid-template-columns: 1fr; }
        .dassoc-stat { display: flex; align-items: center; text-align: left; gap: 0.85rem; padding: 1rem; }
        .dassoc-stat-icon { margin-bottom: 0; }
        .dassoc-stat-value { font-size: 1.2rem; }
        .dassoc-actions { grid-template-columns: 1fr; }
        .dassoc-action { padding: 0.85rem; font-size: 0.84rem; }
        .dassoc-progress-info { flex-direction: column; gap: 0.15rem; }
    }
</style>