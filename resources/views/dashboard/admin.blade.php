{{-- Dashboard Admin --}}
@php
    $stats = [
        'total_users'        => \App\Models\User::count(),
        'total_associations' => \App\Models\Association::count(),
        'validees'           => \App\Models\Association::where('status','validee')->count(),
        'en_attente'         => \App\Models\Association::where('status','en_attente')->count(),
        'total_campaigns'    => \App\Models\Campaign::count(),
        'total_donations'    => \App\Models\Donation::count(),
        'total_besoins'      => \App\Models\Besoin::count(),
        'total_collected'    => \App\Models\Donation::where('type','financier')->sum('amount'),
    ];
    $associations_en_attente = \App\Models\Association::where('status','en_attente')
        ->with('user')->latest()->get();
    $besoins_en_attente = \App\Models\Besoin::where('status','en_attente')
        ->latest()->take(5)->get();
    $tachesOuvertes = \App\Models\Tache::ouverte()
        ->with('association')->latest()->take(3)->get();
@endphp

{{-- Banner --}}
<div class="da-banner">
    <div class="da-banner-icon">
        <i class="bi bi-shield-lock-fill"></i>
    </div>
    <div>
        <div class="da-banner-title">Panel Administrateur</div>
        <div class="da-banner-sub">Vue globale de la plateforme CharityLink</div>
    </div>
</div>

{{-- Stats --}}
<div class="da-stats">
    @php
        $cards = [
            ['icon'=>'bi-people-fill','value'=>$stats['total_users'],'label'=>'Utilisateurs','color'=>'blue'],
            ['icon'=>'bi-building-check','value'=>$stats['validees'],'label'=>'Assoc. validées','color'=>'green'],
            ['icon'=>'bi-hourglass-split','value'=>$stats['en_attente'],'label'=>'En attente','color'=>'orange'],
            ['icon'=>'bi-megaphone-fill','value'=>$stats['total_campaigns'],'label'=>'Campagnes','color'=>'blue'],
            ['icon'=>'bi-heart-fill','value'=>$stats['total_donations'],'label'=>'Dons effectués','color'=>'red'],
            ['icon'=>'bi-cash-stack','value'=>number_format($stats['total_collected'],0).' DT','label'=>'Total collecté','color'=>'green'],
            ['icon'=>'bi-exclamation-triangle-fill','value'=>$stats['total_besoins'],'label'=>'Besoins déclarés','color'=>'orange'],
            ['icon'=>'bi-diagram-3-fill','value'=>$stats['total_associations'],'label'=>'Total assoc.','color'=>'blue'],
        ];
    @endphp
    @foreach($cards as $c)
        <div class="da-stat">
            <div class="da-stat-icon da-stat-icon--{{ $c['color'] }}">
                <i class="{{ $c['icon'] }}"></i>
            </div>
            <div class="da-stat-value">{{ $c['value'] }}</div>
            <div class="da-stat-label">{{ $c['label'] }}</div>
        </div>
    @endforeach
</div>

{{-- Associations en attente --}}
<div class="da-card">
    <div class="da-card-head">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-hourglass-split da-card-head-icon da-card-head-icon--orange"></i>
            <span class="da-card-head-title">Associations en attente</span>
        </div>
        @if($associations_en_attente->count() > 0)
            <span class="da-badge da-badge--red">{{ $associations_en_attente->count() }}</span>
        @endif
    </div>
    <div class="da-card-body">
        @if($associations_en_attente->isEmpty())
            <div class="da-empty">
                <i class="bi bi-check-circle"></i>
                <span>Aucune association en attente</span>
            </div>
        @else
            <div class="da-list">
                @foreach($associations_en_attente as $association)
                    <div class="da-assoc-item">
                        <div class="da-assoc-info">
                            <div class="da-assoc-name">{{ $association->name }}</div>
                            <div class="da-assoc-meta">
                                <span><i class="bi bi-geo-alt"></i> {{ $association->region }} — {{ ucfirst($association->category) }}</span>
                                <span><i class="bi bi-person"></i> {{ $association->user->name }}</span>
                            </div>
                        </div>
                        <div class="da-assoc-actions">
                            <form method="POST" action="{{ route('admin.associations.valider', $association) }}">
                                @csrf
                                <button type="submit" class="da-btn da-btn--green">
                                    <i class="bi bi-check-lg"></i> Valider
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.associations.rejeter', $association) }}">
                                @csrf
                                <div class="da-reject-group">
                                    <input type="text" name="rejection_reason" placeholder="Motif..." class="da-reject-input" required />
                                    <button type="submit" class="da-btn da-btn--red-sm">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Besoins en attente --}}
<div class="da-card">
    <div class="da-card-head">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill da-card-head-icon da-card-head-icon--red"></i>
            <span class="da-card-head-title">Derniers besoins déclarés</span>
        </div>
    </div>
    <div class="da-card-body">
        @if($besoins_en_attente->isEmpty())
            <div class="da-empty">
                <i class="bi bi-check-circle"></i>
                <span>Aucun besoin déclaré</span>
            </div>
        @else
            <div class="da-list">
                @foreach($besoins_en_attente as $besoin)
                    <div class="da-besoin-item">
                        <div class="da-besoin-left">
                            @if($besoin->urgence === 'critique')
                                <span class="da-badge da-badge--red"><i class="bi bi-exclamation-octagon-fill"></i> Critique</span>
                            @elseif($besoin->urgence === 'urgente')
                                <span class="da-badge da-badge--orange"><i class="bi bi-exclamation-triangle-fill"></i> Urgente</span>
                            @else
                                <span class="da-badge da-badge--muted">Normale</span>
                            @endif
                            <div>
                                <div class="da-besoin-name">{{ $besoin->nom }}</div>
                                <div class="da-besoin-meta">
                                    <i class="bi bi-tag"></i> {{ ucfirst($besoin->categorie) }} — <i class="bi bi-geo-alt"></i> {{ $besoin->region }}
                                </div>
                            </div>
                        </div>
                        <div class="da-besoin-date">{{ $besoin->created_at->format('d/m/Y') }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Tâches disponibles --}}
<div class="da-card">
    <div class="da-card-head">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-bullseye da-card-head-icon da-card-head-icon--red"></i>
            <span class="da-card-head-title">Tâches disponibles</span>
        </div>
        <a href="{{ route('taches.index') }}" class="da-see-all">
            Voir tout <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="da-card-body">
        @if($tachesOuvertes->isEmpty())
            <div class="da-empty">
                <i class="bi bi-search"></i>
                <span>Aucune tâche disponible pour le moment.</span>
            </div>
        @else
            <div class="da-list">
                @foreach($tachesOuvertes as $tache)
                    <div class="da-task-item">
                        <div class="da-task-left">
                            <div class="da-task-icon">
                                <i class="bi bi-bullseye"></i>
                            </div>
                            <div>
                                <div class="da-task-name">{{ $tache->title }}</div>
                                <div class="da-task-meta"><i class="bi bi-star"></i> {{ $tache->competence_requise }}</div>
                            </div>
                        </div>
                        <a href="{{ route('taches.index') }}" class="da-btn da-btn--red">Postuler</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Actions rapides --}}
<div class="da-actions">
    <a href="{{ route('taches.index') }}" class="da-action da-action--red">
        <i class="bi bi-hand-thumbs-up-fill"></i>
        <span>Voir les tâches</span>
    </a>
    <a href="{{ route('taches.mes_taches') }}" class="da-action da-action--outline">
        <i class="bi bi-clipboard2-check-fill"></i>
        <span>Mes tâches</span>
    </a>
</div>

<style>
    .da-banner {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--cl-blue), #2A4A73);
        border-radius: var(--radius-xl);
        margin-bottom: 1.5rem;
        transition: all 0.35s ease;
    }
    .da-banner-icon {
        width: 52px; height: 52px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .da-banner-icon i { font-size: 1.4rem; color: #fff; }
    .da-banner-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.2rem;
        color: #fff;
        letter-spacing: -0.02em;
    }
    .da-banner-sub {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.5);
        margin-top: 2px;
    }

    .da-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.85rem;
        margin-bottom: 1.5rem;
    }
    .da-stat {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-lg);
        padding: 1.1rem 1rem;
        text-align: center;
        transition: all 0.25s ease;
        box-shadow: var(--shadow-xs);
    }
    .da-stat:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .da-stat-icon {
        width: 40px; height: 40px;
        border-radius: var(--radius-sm);
        display: inline-flex; align-items: center; justify-content: center;
        margin-bottom: 0.6rem;
    }
    .da-stat-icon i { font-size: 1.1rem; }
    .da-stat-icon--red { background: var(--cl-red-glow); }
    .da-stat-icon--red i { color: var(--cl-red); }
    .da-stat-icon--blue { background: var(--cl-blue-mid); }
    .da-stat-icon--blue i { color: var(--cl-blue); }
    .da-stat-icon--green { background: var(--cl-green-glow); }
    .da-stat-icon--green i { color: var(--cl-green); }
    .da-stat-icon--orange { background: rgba(245,166,35,0.1); }
    .da-stat-icon--orange i { color: #D4940A; }
    .da-stat-value {
        font-family: 'Inter', sans-serif;
        font-weight: 800;
        font-size: 1.45rem;
        color: var(--cl-dark);
        letter-spacing: -0.03em;
        line-height: 1.2;
        transition: color 0.35s ease;
    }
    .da-stat-label {
        font-size: 0.73rem;
        color: var(--cl-muted);
        margin-top: 0.2rem;
        font-weight: 500;
        transition: color 0.35s ease;
    }

    .da-card {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl);
        margin-bottom: 1.25rem;
        box-shadow: var(--shadow-xs);
        overflow: hidden;
        transition: all 0.35s ease;
    }
    .da-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.1rem 1.35rem;
        border-bottom: 1px solid var(--cl-border);
        transition: border-color 0.35s ease;
    }
    .da-card-head-icon { font-size: 1rem; }
    .da-card-head-icon--red { color: var(--cl-red); }
    .da-card-head-icon--orange { color: #D4940A; }
    .da-card-head-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--cl-dark);
        transition: color 0.35s ease;
    }
    .da-card-body { padding: 0.5rem 1.35rem 1.1rem; }

    .da-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.65rem;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
    }
    .da-badge i { font-size: 0.72rem; }
    .da-badge--red { background: var(--cl-red-glow); color: var(--cl-red); }
    .da-badge--green { background: var(--cl-green-glow); color: var(--cl-green); }
    .da-badge--orange { background: rgba(245,166,35,0.1); color: #D4940A; }
    .da-badge--muted { background: var(--cl-light); color: var(--cl-muted); border: 1px solid var(--cl-border); }

    .da-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.6rem;
        padding: 2.5rem 1rem;
        color: var(--cl-muted-light);
        font-size: 0.85rem;
    }
    .da-empty i { font-size: 2.5rem; opacity: 0.5; }

    .da-list { display: flex; flex-direction: column; }

    .da-assoc-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid var(--cl-border);
        transition: border-color 0.35s ease;
    }
    .da-assoc-item:last-child { border-bottom: none; }
    .da-assoc-info { flex: 1; min-width: 0; }
    .da-assoc-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--cl-dark);
        margin-bottom: 0.3rem;
        transition: color 0.35s ease;
    }
    .da-assoc-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        font-size: 0.78rem;
        color: var(--cl-muted);
        transition: color 0.35s ease;
    }
    .da-assoc-meta i { margin-right: 0.2rem; font-size: 0.75rem; }
    .da-assoc-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        flex-shrink: 0;
        align-items: flex-end;
    }
    .da-reject-group {
        display: flex;
        align-items: center;
    }
    .da-reject-input {
        width: 120px;
        padding: 0.3rem 0.6rem;
        font-size: 0.78rem;
        font-family: 'Inter', sans-serif;
        background: var(--cl-light);
        border: 1px solid var(--cl-border);
        border-right: none;
        border-radius: var(--radius-full) 0 0 var(--radius-full);
        color: var(--cl-dark);
        outline: none !important;
        box-shadow: none !important;
        transition: all 0.25s ease;
    }
    .da-reject-input:focus {
        border-color: var(--cl-red) !important;
        box-shadow: none !important;
        outline: none !important;
    }
    .da-reject-input::placeholder { color: var(--cl-muted-light); }

    .da-besoin-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 0.85rem 0;
        border-bottom: 1px solid var(--cl-border);
        transition: border-color 0.35s ease;
    }
    .da-besoin-item:last-child { border-bottom: none; }
    .da-besoin-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex: 1;
        min-width: 0;
    }
    .da-besoin-name {
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--cl-dark);
        transition: color 0.35s ease;
    }
    .da-besoin-meta {
        font-size: 0.75rem;
        color: var(--cl-muted);
        margin-top: 0.15rem;
        transition: color 0.35s ease;
    }
    .da-besoin-meta i { margin-right: 0.15rem; font-size: 0.7rem; }
    .da-besoin-date {
        font-size: 0.78rem;
        color: var(--cl-muted);
        flex-shrink: 0;
        font-weight: 500;
        transition: color 0.35s ease;
    }

    .da-task-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 0.85rem 0;
        border-bottom: 1px solid var(--cl-border);
        transition: border-color 0.35s ease;
    }
    .da-task-item:last-child { border-bottom: none; }
    .da-task-left {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        flex: 1;
        min-width: 0;
    }
    .da-task-icon {
        width: 38px; height: 38px;
        background: var(--cl-red-glow);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: background 0.35s ease;
    }
    .da-task-icon i { font-size: 1rem; color: var(--cl-red); }
    .da-task-name {
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--cl-dark);
        transition: color 0.35s ease;
    }
    .da-task-meta {
        font-size: 0.75rem;
        color: var(--cl-muted);
        margin-top: 0.1rem;
        transition: color 0.35s ease;
    }
    .da-task-meta i { margin-right: 0.2rem; font-size: 0.72rem; }

    .da-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.85rem;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.78rem;
        border-radius: var(--radius-full);
        border: none !important;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        outline: none !important;
        box-shadow: none !important;
    }
    .da-btn:focus {
        outline: none !important;
        box-shadow: none !important;
    }
    .da-btn--red {
        background: var(--cl-red);
        color: #fff;
    }
    .da-btn--red:hover {
        background: var(--cl-red-hover);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(230,57,70,0.25) !important;
        text-decoration: none;
    }
    .da-btn--green {
        background: var(--cl-green);
        color: #fff;
    }
    .da-btn--green:hover {
        background: #25a846;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(45,198,83,0.25) !important;
    }
    .da-btn--red-sm {
        background: var(--cl-red);
        color: #fff;
        padding: 0.3rem 0.55rem;
        border-radius: 0 var(--radius-full) var(--radius-full) 0 !important;
        font-size: 0.75rem;
    }
    .da-btn--red-sm:hover {
        background: var(--cl-red-hover);
        color: #fff;
    }
    .da-btn i { font-size: 0.82rem; }

    .da-see-all {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--cl-red);
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .da-see-all:hover {
        color: var(--cl-red-hover);
        gap: 0.45rem;
        text-decoration: none;
    }
    .da-see-all i { font-size: 0.8rem; }

    .da-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
        margin-bottom: 1.5rem;
    }
    .da-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        padding: 1rem;
        border-radius: var(--radius-lg);
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .da-action i { font-size: 1.1rem; }
    .da-action--red {
        background: var(--cl-red);
        color: #fff;
        box-shadow: 0 3px 12px rgba(230,57,70,0.2);
    }
    .da-action--red:hover {
        background: var(--cl-red-hover);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(230,57,70,0.28);
        text-decoration: none;
    }
    .da-action--outline {
        background: transparent;
        color: var(--cl-red);
        border: 1.5px solid var(--cl-red);
    }
    .da-action--outline:hover {
        background: var(--cl-red-glow);
        color: var(--cl-red);
        transform: translateY(-2px);
        text-decoration: none;
    }

    @media (max-width: 991.98px) {
        .da-stats { grid-template-columns: repeat(4, 1fr); }
    }
    @media (max-width: 767.98px) {
        .da-stats { grid-template-columns: repeat(2, 1fr); }
        .da-banner { padding: 1.15rem; }
        .da-banner-icon { width: 44px; height: 44px; }
        .da-banner-icon i { font-size: 1.15rem; }
        .da-banner-title { font-size: 1.05rem; }
        .da-assoc-item { flex-direction: column; gap: 0.75rem; }
        .da-assoc-actions { flex-direction: row; align-items: center; width: 100%; }
        .da-assoc-actions form { flex: 1; }
        .da-reject-input { width: 100%; }
        .da-besoin-item { flex-direction: column; align-items: flex-start; gap: 0.4rem; }
        .da-task-item { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
        .da-task-item .da-btn { align-self: flex-start; }
        .da-card-head { padding: 0.95rem 1.1rem; }
        .da-card-body { padding: 0.35rem 1.1rem 1rem; }
    }
    @media (max-width: 575.98px) {
        .da-stats { gap: 0.6rem; }
        .da-stat { padding: 0.9rem 0.75rem; }
        .da-stat-value { font-size: 1.25rem; }
        .da-stat-icon { width: 36px; height: 36px; }
        .da-stat-icon i { font-size: 0.95rem; }
        .da-actions { grid-template-columns: 1fr; }
        .da-action { padding: 0.85rem; font-size: 0.84rem; }
    }
</style>
