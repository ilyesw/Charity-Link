{{-- Dashboard Donateur --}}
@php
    $userId = auth()->id();
    $donations = App\Models\Donation::where('user_id', $userId)
        ->with('campaign')->latest()->take(5)->get();
    $totalFinancier = App\Models\Donation::where('user_id', $userId)
        ->where('type', 'financier')->sum('amount');
    $totalDons = App\Models\Donation::where('user_id', $userId)->count();
    $totalCompetences = App\Models\Donation::where('user_id', $userId)
        ->where('type', 'competences')->count();
@endphp

{{-- Banner --}}
<div class="ddon-banner">
    <div class="ddon-banner-icon">
        <i class="bi bi-person-check-fill"></i>
    </div>
    <div>
        <div class="ddon-banner-title">Bonjour, {{ auth()->user()->name }} !</div>
        <div class="ddon-banner-sub">Résumé de vos contributions solidaires</div>
    </div>
</div>

{{-- Stats --}}
<div class="ddon-stats">
    <div class="ddon-stat">
        <div class="ddon-stat-icon ddon-stat-icon--red">
            <i class="bi bi-cash-stack"></i>
        </div>
        <div class="ddon-stat-value">{{ number_format($totalFinancier, 0) }} DT</div>
        <div class="ddon-stat-label">Total dons financiers</div>
    </div>
    <div class="ddon-stat">
        <div class="ddon-stat-icon ddon-stat-icon--blue">
            <i class="bi bi-heart-fill"></i>
        </div>
        <div class="ddon-stat-value">{{ $totalDons }}</div>
        <div class="ddon-stat-label">Total contributions</div>
    </div>
    <div class="ddon-stat">
        <div class="ddon-stat-icon ddon-stat-icon--green">
            <i class="bi bi-mortarboard"></i>
        </div>
        <div class="ddon-stat-value">{{ $totalCompetences }}</div>
        <div class="ddon-stat-label">Dons de compétences</div>
    </div>
</div>

{{-- Derniers dons --}}
<div class="ddon-card">
    <div class="ddon-card-head">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-clock-history ddon-card-icon"></i>
            <span class="ddon-card-title">Mes derniers dons</span>
        </div>
        <a href="{{ route('donations.historique') }}" class="ddon-see-all">
            Voir tout <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="ddon-card-body">
        @if($donations->isEmpty())
            <div class="ddon-empty">
                <i class="bi bi-inbox"></i>
                <span>Aucun don effectué pour le moment.</span>
            </div>
        @else
            <div class="ddon-list">
                @foreach($donations as $donation)
                    <div class="ddon-donation">
                        <div class="ddon-donation-left">
                            <div class="ddon-donation-icon">
                                @if($donation->type === 'financier')
                                    <i class="bi bi-cash-stack"></i>
                                @elseif($donation->type === 'nature')
                                    <i class="bi bi-box-seam"></i>
                                @else
                                    <i class="bi bi-mortarboard"></i>
                                @endif
                            </div>
                            <div>
                                <div class="ddon-donation-name">{{ $donation->campaign->title }}</div>
                                <span class="ddon-badge ddon-badge--{{ $donation->type === 'financier' ? 'red' : ($donation->type === 'nature' ? 'orange' : 'blue') }}">
                                    {{ ucfirst($donation->type) }}
                                </span>
                            </div>
                        </div>
                        <div class="ddon-donation-right">
                            @if($donation->type === 'financier')
                                <div class="ddon-donation-amount">{{ number_format($donation->amount, 0) }} DT</div>
                            @else
                                <div class="ddon-donation-type">{{ ucfirst($donation->type) }}</div>
                            @endif
                            <div class="ddon-donation-date">{{ $donation->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Actions rapides --}}
<div class="ddon-actions">
    <a href="{{ route('campaigns.index') }}" class="ddon-action ddon-action--red">
        <i class="bi bi-heart-fill"></i>
        <span>Faire un don</span>
    </a>
    <a href="{{ route('associations.index') }}" class="ddon-action ddon-action--outline">
        <i class="bi bi-building"></i>
        <span>Associations</span>
    </a>
</div>

<style>
    .ddon-banner {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--cl-blue), #2A4A73);
        border-radius: var(--radius-xl);
        margin-bottom: 1.5rem;
        transition: all 0.35s ease;
    }
    .ddon-banner-icon {
        width: 52px; height: 52px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .ddon-banner-icon i { font-size: 1.4rem; color: #fff; }
    .ddon-banner-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 1.2rem;
        color: #fff; letter-spacing: -0.02em;
    }
    .ddon-banner-sub {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.5);
        margin-top: 2px;
    }

    .ddon-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.85rem;
        margin-bottom: 1.5rem;
    }
    .ddon-stat {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-lg);
        padding: 1.25rem 1rem;
        text-align: center;
        transition: all 0.25s ease;
        box-shadow: var(--shadow-xs);
    }
    .ddon-stat:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .ddon-stat-icon {
        width: 42px; height: 42px;
        border-radius: var(--radius-sm);
        display: inline-flex; align-items: center; justify-content: center;
        margin-bottom: 0.65rem;
    }
    .ddon-stat-icon i { font-size: 1.1rem; }
    .ddon-stat-icon--red { background: var(--cl-red-glow); }
    .ddon-stat-icon--red i { color: var(--cl-red); }
    .ddon-stat-icon--blue { background: var(--cl-blue-mid); }
    .ddon-stat-icon--blue i { color: var(--cl-blue); }
    .ddon-stat-icon--green { background: var(--cl-green-glow); }
    .ddon-stat-icon--green i { color: var(--cl-green); }
    .ddon-stat-value {
        font-family: 'Inter', sans-serif;
        font-weight: 800; font-size: 1.5rem;
        color: var(--cl-dark);
        letter-spacing: -0.03em; line-height: 1.2;
        transition: color 0.35s ease;
    }
    .ddon-stat-label {
        font-size: 0.75rem; color: var(--cl-muted);
        margin-top: 0.2rem; font-weight: 500;
        transition: color 0.35s ease;
    }

    .ddon-card {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl);
        margin-bottom: 1.25rem;
        box-shadow: var(--shadow-xs);
        overflow: hidden;
        transition: all 0.35s ease;
    }
    .ddon-card-head {
        display: flex; align-items: center;
        justify-content: space-between;
        padding: 1.1rem 1.35rem;
        border-bottom: 1px solid var(--cl-border);
        transition: border-color 0.35s ease;
    }
    .ddon-card-icon { font-size: 1rem; color: var(--cl-red); }
    .ddon-card-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.92rem;
        color: var(--cl-dark);
        transition: color 0.35s ease;
    }
    .ddon-card-body { padding: 0.5rem 1.35rem 1.1rem; }

    .ddon-see-all {
        display: inline-flex; align-items: center; gap: 0.3rem;
        font-size: 0.78rem; font-weight: 600;
        color: var(--cl-red); text-decoration: none;
        transition: all 0.2s ease;
    }
    .ddon-see-all:hover {
        color: var(--cl-red-hover);
        gap: 0.45rem; text-decoration: none;
    }
    .ddon-see-all i { font-size: 0.8rem; }

    .ddon-empty {
        display: flex; flex-direction: column; align-items: center;
        gap: 0.6rem; padding: 2.5rem 1rem;
        color: var(--cl-muted-light); font-size: 0.85rem;
    }
    .ddon-empty i { font-size: 2.5rem; opacity: 0.5; }

    .ddon-list { display: flex; flex-direction: column; }

    .ddon-donation {
        display: flex; justify-content: space-between;
        align-items: center; gap: 1rem;
        padding: 0.85rem 0;
        border-bottom: 1px solid var(--cl-border);
        transition: border-color 0.35s ease;
    }
    .ddon-donation:last-child { border-bottom: none; }
    .ddon-donation-left {
        display: flex; align-items: center; gap: 0.85rem;
        flex: 1; min-width: 0;
    }
    .ddon-donation-icon {
        width: 38px; height: 38px;
        background: var(--cl-red-glow);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: background 0.35s ease;
    }
    .ddon-donation-icon i { font-size: 1rem; color: var(--cl-red); }
    .ddon-donation-name {
        font-weight: 600; font-size: 0.88rem;
        color: var(--cl-dark);
        transition: color 0.35s ease;
    }

    .ddon-badge {
        display: inline-flex; align-items: center;
        padding: 0.18rem 0.55rem;
        border-radius: var(--radius-full);
        font-size: 0.65rem; font-weight: 600;
        font-family: 'Inter', sans-serif;
        margin-top: 0.25rem;
    }
    .ddon-badge--red { background: var(--cl-red-glow); color: var(--cl-red); }
    .ddon-badge--blue { background: var(--cl-blue-mid); color: var(--cl-blue); }
    .ddon-badge--orange { background: rgba(245,166,35,0.1); color: #D4940A; }

    .ddon-donation-right {
        text-align: right; flex-shrink: 0;
    }
    .ddon-donation-amount {
        font-weight: 800; font-size: 0.95rem;
        color: var(--cl-red);
        transition: color 0.35s ease;
    }
    .ddon-donation-type {
        font-size: 0.82rem; color: var(--cl-muted);
        font-weight: 500;
        transition: color 0.35s ease;
    }
    .ddon-donation-date {
        font-size: 0.73rem; color: var(--cl-muted-light);
        margin-top: 0.15rem;
        transition: color 0.35s ease;
    }

    .ddon-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
        margin-bottom: 1.5rem;
    }
    .ddon-action {
        display: flex; align-items: center; justify-content: center;
        gap: 0.6rem; padding: 1rem;
        border-radius: var(--radius-lg);
        font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .ddon-action i { font-size: 1.1rem; }
    .ddon-action--red {
        background: var(--cl-red); color: #fff;
        box-shadow: 0 3px 12px rgba(230,57,70,0.2);
    }
    .ddon-action--red:hover {
        background: var(--cl-red-hover); color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(230,57,70,0.28);
        text-decoration: none;
    }
    .ddon-action--outline {
        background: transparent; color: var(--cl-red);
        border: 1.5px solid var(--cl-red);
    }
    .ddon-action--outline:hover {
        background: var(--cl-red-glow); color: var(--cl-red);
        transform: translateY(-2px);
        text-decoration: none;
    }

    @media (max-width: 767.98px) {
        .ddon-banner { padding: 1.15rem; }
        .ddon-banner-icon { width: 44px; height: 44px; }
        .ddon-banner-icon i { font-size: 1.15rem; }
        .ddon-banner-title { font-size: 1.05rem; }
        .ddon-stats { grid-template-columns: repeat(3, 1fr); gap: 0.6rem; }
        .ddon-stat { padding: 1rem 0.75rem; }
        .ddon-stat-value { font-size: 1.3rem; }
        .ddon-donation { flex-direction: column; align-items: flex-start; gap: 0.6rem; }
        .ddon-donation-right { text-align: left; }
        .ddon-card-head { padding: 0.95rem 1.1rem; }
        .ddon-card-body { padding: 0.35rem 1.1rem 1rem; }
    }
    @media (max-width: 575.98px) {
        .ddon-stats { grid-template-columns: 1fr; }
        .ddon-stat {
            display: flex; align-items: center;
            text-align: left; gap: 0.85rem; padding: 1rem;
        }
        .ddon-stat-icon { margin-bottom: 0; }
        .ddon-stat-value { font-size: 1.2rem; }
        .ddon-actions { grid-template-columns: 1fr; }
        .ddon-action { padding: 0.85rem; font-size: 0.84rem; }
    }
</style>
