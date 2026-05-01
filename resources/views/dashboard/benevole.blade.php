{{-- Dashboard Bénévole --}}
@php
    use App\Models\Tache;
    $taches = Tache::where('benevole_id', auth()->id())
        ->with('association')->latest()->get();
    $tachesOuvertes = Tache::ouverte()
        ->with('association')->latest()->take(3)->get();
@endphp

{{-- Banner --}}
<div class="dben-banner">
    <div class="dben-banner-icon">
        <i class="bi bi-hand-thumbs-up-fill"></i>
    </div>
    <div>
        <div class="dben-banner-title">Bonjour, {{ auth()->user()->name }} !</div>
        <div class="dben-banner-sub">Espace Bénévole — CharityLink</div>
    </div>
</div>

{{-- Stats --}}
<div class="dben-stats">
    <div class="dben-stat">
        <div class="dben-stat-icon dben-stat-icon--blue">
            <i class="bi bi-clipboard2-check"></i>
        </div>
        <div class="dben-stat-value">{{ $taches->count() }}</div>
        <div class="dben-stat-label">Mes tâches</div>
    </div>
    <div class="dben-stat">
        <div class="dben-stat-icon dben-stat-icon--orange">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div class="dben-stat-value">{{ $taches->where('status','en_cours')->count() }}</div>
        <div class="dben-stat-label">En cours</div>
    </div>
    <div class="dben-stat">
        <div class="dben-stat-icon dben-stat-icon--green">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="dben-stat-value">{{ $taches->where('status','validee')->count() }}</div>
        <div class="dben-stat-label">Validées</div>
    </div>
</div>

{{-- Mes tâches en cours --}}
<div class="dben-card">
    <div class="dben-card-head">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-hourglass-split dben-card-icon dben-card-icon--orange"></i>
            <span class="dben-card-title">Mes tâches en cours</span>
        </div>
        <a href="{{ route('taches.mes_taches') }}" class="dben-see-all">
            Voir tout <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="dben-card-body">
        @if($taches->isEmpty())
            <div class="dben-empty">
                <i class="bi bi-inbox"></i>
                <span>Aucune tâche assignée pour le moment.</span>
            </div>
        @else
            <div class="dben-list">
                @foreach($taches->take(3) as $tache)
                    <div class="dben-task-item">
                        <div class="dben-task-left">
                            <div class="dben-task-icon dben-task-icon--muted">
                                <i class="bi bi-clipboard2"></i>
                            </div>
                            <div>
                                <div class="dben-task-name">{{ $tache->title }}</div>
                                <div class="dben-task-meta">{{ $tache->association->name }}</div>
                            </div>
                        </div>
                        @if($tache->status === 'en_cours')
                            <span class="dben-badge dben-badge--orange">
                                <i class="bi bi-hourglass-split"></i> En cours
                            </span>
                        @else
                            <span class="dben-badge dben-badge--green">
                                <i class="bi bi-check-circle"></i> Validée
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Tâches disponibles --}}
<div class="dben-card">
    <div class="dben-card-head">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-bullseye dben-card-icon dben-card-icon--red"></i>
            <span class="dben-card-title">Tâches disponibles</span>
        </div>
        <a href="{{ route('taches.index') }}" class="dben-see-all">
            Voir tout <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="dben-card-body">
        @if($tachesOuvertes->isEmpty())
            <div class="dben-empty">
                <i class="bi bi-search"></i>
                <span>Aucune tâche disponible pour le moment.</span>
            </div>
        @else
            <div class="dben-list">
                @foreach($tachesOuvertes as $tache)
                    <div class="dben-task-item">
                        <div class="dben-task-left">
                            <div class="dben-task-icon dben-task-icon--red">
                                <i class="bi bi-bullseye"></i>
                            </div>
                            <div>
                                <div class="dben-task-name">{{ $tache->title }}</div>
                                <div class="dben-task-meta"><i class="bi bi-star"></i> {{ $tache->competence_requise }}</div>
                            </div>
                        </div>
                        <a href="{{ route('taches.index') }}" class="dben-btn dben-btn--red">Postuler</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Actions rapides --}}
<div class="dben-actions">
    <a href="{{ route('taches.index') }}" class="dben-action dben-action--red">
        <i class="bi bi-hand-thumbs-up-fill"></i>
        <span>Voir les tâches</span>
    </a>
    <a href="{{ route('taches.mes_taches') }}" class="dben-action dben-action--outline">
        <i class="bi bi-clipboard2-check-fill"></i>
        <span>Mes tâches</span>
    </a>
</div>

<style>
    .dben-banner {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--cl-blue), #2A4A73);
        border-radius: var(--radius-xl);
        margin-bottom: 1.5rem;
        transition: all 0.35s ease;
    }
    .dben-banner-icon {
        width: 52px; height: 52px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .dben-banner-icon i { font-size: 1.4rem; color: #fff; }
    .dben-banner-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 1.2rem;
        color: #fff; letter-spacing: -0.02em;
    }
    .dben-banner-sub {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.5);
        margin-top: 2px;
    }

    .dben-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.85rem;
        margin-bottom: 1.5rem;
    }
    .dben-stat {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-lg);
        padding: 1.25rem 1rem;
        text-align: center;
        transition: all 0.25s ease;
        box-shadow: var(--shadow-xs);
    }
    .dben-stat:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .dben-stat-icon {
        width: 42px; height: 42px;
        border-radius: var(--radius-sm);
        display: inline-flex; align-items: center; justify-content: center;
        margin-bottom: 0.65rem;
    }
    .dben-stat-icon i { font-size: 1.1rem; }
    .dben-stat-icon--red { background: var(--cl-red-glow); }
    .dben-stat-icon--red i { color: var(--cl-red); }
    .dben-stat-icon--blue { background: var(--cl-blue-mid); }
    .dben-stat-icon--blue i { color: var(--cl-blue); }
    .dben-stat-icon--green { background: var(--cl-green-glow); }
    .dben-stat-icon--green i { color: var(--cl-green); }
    .dben-stat-icon--orange { background: rgba(245,166,35,0.1); }
    .dben-stat-icon--orange i { color: #D4940A; }
    .dben-stat-value {
        font-family: 'Inter', sans-serif;
        font-weight: 800; font-size: 1.5rem;
        color: var(--cl-dark);
        letter-spacing: -0.03em; line-height: 1.2;
        transition: color 0.35s ease;
    }
    .dben-stat-label {
        font-size: 0.75rem; color: var(--cl-muted);
        margin-top: 0.2rem; font-weight: 500;
        transition: color 0.35s ease;
    }

    .dben-card {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl);
        margin-bottom: 1.25rem;
        box-shadow: var(--shadow-xs);
        overflow: hidden;
        transition: all 0.35s ease;
    }
    .dben-card-head {
        display: flex; align-items: center;
        justify-content: space-between;
        padding: 1.1rem 1.35rem;
        border-bottom: 1px solid var(--cl-border);
        transition: border-color 0.35s ease;
    }
    .dben-card-icon { font-size: 1rem; }
    .dben-card-icon--red { color: var(--cl-red); }
    .dben-card-icon--orange { color: #D4940A; }
    .dben-card-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.92rem;
        color: var(--cl-dark);
        transition: color 0.35s ease;
    }
    .dben-card-body { padding: 0.5rem 1.35rem 1.1rem; }

    .dben-see-all {
        display: inline-flex; align-items: center; gap: 0.3rem;
        font-size: 0.78rem; font-weight: 600;
        color: var(--cl-red); text-decoration: none;
        transition: all 0.2s ease;
    }
    .dben-see-all:hover {
        color: var(--cl-red-hover);
        gap: 0.45rem; text-decoration: none;
    }
    .dben-see-all i { font-size: 0.8rem; }

    .dben-empty {
        display: flex; flex-direction: column; align-items: center;
        gap: 0.6rem; padding: 2.5rem 1rem;
        color: var(--cl-muted-light); font-size: 0.85rem;
    }
    .dben-empty i { font-size: 2.5rem; opacity: 0.5; }

    .dben-list { display: flex; flex-direction: column; }

    .dben-task-item {
        display: flex; justify-content: space-between;
        align-items: center; gap: 1rem;
        padding: 0.85rem 0;
        border-bottom: 1px solid var(--cl-border);
        transition: border-color 0.35s ease;
    }
    .dben-task-item:last-child { border-bottom: none; }
    .dben-task-left {
        display: flex; align-items: center; gap: 0.85rem;
        flex: 1; min-width: 0;
    }
    .dben-task-icon {
        width: 38px; height: 38px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: background 0.35s ease;
    }
    .dben-task-icon i { font-size: 1rem; }
    .dben-task-icon--red { background: var(--cl-red-glow); }
    .dben-task-icon--red i { color: var(--cl-red); }
    .dben-task-icon--muted { background: var(--cl-light); border: 1px solid var(--cl-border); }
    .dben-task-icon--muted i { color: var(--cl-muted); }
    .dben-task-name {
        font-weight: 600; font-size: 0.88rem;
        color: var(--cl-dark);
        transition: color 0.35s ease;
    }
    .dben-task-meta {
        font-size: 0.75rem; color: var(--cl-muted);
        margin-top: 0.1rem;
        transition: color 0.35s ease;
    }
    .dben-task-meta i { margin-right: 0.2rem; font-size: 0.72rem; }

    .dben-badge {
        display: inline-flex; align-items: center; gap: 0.3rem;
        padding: 0.25rem 0.65rem;
        border-radius: var(--radius-full);
        font-size: 0.7rem; font-weight: 600;
        font-family: 'Inter', sans-serif;
        flex-shrink: 0;
    }
    .dben-badge i { font-size: 0.72rem; }
    .dben-badge--red { background: var(--cl-red-glow); color: var(--cl-red); }
    .dben-badge--green { background: var(--cl-green-glow); color: var(--cl-green); }
    .dben-badge--orange { background: rgba(245,166,35,0.1); color: #D4940A; }

    .dben-btn {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.35rem 0.85rem;
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.78rem;
        border-radius: var(--radius-full);
        border: none !important;
        cursor: pointer; text-decoration: none;
        transition: all 0.2s ease;
        outline: none !important;
        box-shadow: none !important;
    }
    .dben-btn:focus { outline: none !important; box-shadow: none !important; }
    .dben-btn--red { background: var(--cl-red); color: #fff; }
    .dben-btn--red:hover {
        background: var(--cl-red-hover); color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(230,57,70,0.25) !important;
        text-decoration: none;
    }

    .dben-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
        margin-bottom: 1.5rem;
    }
    .dben-action {
        display: flex; align-items: center; justify-content: center;
        gap: 0.6rem; padding: 1rem;
        border-radius: var(--radius-lg);
        font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .dben-action i { font-size: 1.1rem; }
    .dben-action--red {
        background: var(--cl-red); color: #fff;
        box-shadow: 0 3px 12px rgba(230,57,70,0.2);
    }
    .dben-action--red:hover {
        background: var(--cl-red-hover); color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(230,57,70,0.28);
        text-decoration: none;
    }
    .dben-action--outline {
        background: transparent; color: var(--cl-red);
        border: 1.5px solid var(--cl-red);
    }
    .dben-action--outline:hover {
        background: var(--cl-red-glow); color: var(--cl-red);
        transform: translateY(-2px);
        text-decoration: none;
    }

    @media (max-width: 767.98px) {
        .dben-banner { padding: 1.15rem; }
        .dben-banner-icon { width: 44px; height: 44px; }
        .dben-banner-icon i { font-size: 1.15rem; }
        .dben-banner-title { font-size: 1.05rem; }
        .dben-stats { grid-template-columns: repeat(3, 1fr); gap: 0.6rem; }
        .dben-stat { padding: 1rem 0.75rem; }
        .dben-stat-value { font-size: 1.3rem; }
        .dben-task-item { flex-direction: column; align-items: flex-start; gap: 0.6rem; }
        .dben-task-item .dben-badge { align-self: flex-start; }
        .dben-task-item .dben-btn { align-self: flex-start; }
        .dben-card-head { padding: 0.95rem 1.1rem; }
        .dben-card-body { padding: 0.35rem 1.1rem 1rem; }
    }
    @media (max-width: 575.98px) {
        .dben-stats { grid-template-columns: 1fr; }
        .dben-stat {
            display: flex; align-items: center;
            text-align: left; gap: 0.85rem; padding: 1rem;
        }
        .dben-stat-icon { margin-bottom: 0; }
        .dben-stat-value { font-size: 1.2rem; }
        .dben-actions { grid-template-columns: 1fr; }
        .dben-action { padding: 0.85rem; font-size: 0.84rem; }
    }
</style>
