{{-- resources/views/campaigns/transparence.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparence — {{ $campaign->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --red: #E63946; --red-soft: rgba(230,57,70,0.08);
            --green: #2DC653; --green-soft: rgba(45,198,83,0.08);
            --blue: #1D3557; --blue-soft: rgba(29,53,87,0.07);
            --gold: #F4A828;
            --dark: #111827; --body: #374151; --muted: #6B7280; --muted-light: #9CA3AF;
            --border: #E5E7EB; --card: #fff; --bg: #F9FAFB;
            --radius-sm: 6px; --radius-md: 10px; --radius-lg: 14px; --radius-xl: 20px; --radius-full: 9999px;
            --shadow-sm: 0 1px 4px rgba(0,0,0,0.06); --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--body); min-height: 100vh; }

        /* ─── Header public ─── */
        .tp-header {
            background: #fff; border-bottom: 1px solid var(--border);
            padding: 1rem 0; position: sticky; top: 0; z-index: 100;
            box-shadow: var(--shadow-sm);
        }
        .tp-header-inner {
            max-width: 900px; margin: 0 auto; padding: 0 1.5rem;
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
        }
        .tp-logo {
            display: flex; align-items: center; gap: 0.6rem;
            font-weight: 800; font-size: 1.05rem; color: var(--red);
            text-decoration: none;
        }
        .tp-logo-dot { width: 8px; height: 8px; background: var(--red); border-radius: 50%; }
        .tp-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.35rem 0.85rem;
            background: var(--green-soft); color: var(--green);
            border: 1px solid rgba(45,198,83,0.2);
            border-radius: var(--radius-full);
            font-size: 0.78rem; font-weight: 700; letter-spacing: 0.02em;
        }

        /* ─── Layout ─── */
        .tp-wrap { max-width: 900px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

        /* ─── Hero campagne ─── */
        .tp-hero {
            background: var(--card); border: 1px solid var(--border);
            border-radius: var(--radius-xl); overflow: hidden;
            box-shadow: var(--shadow-md); margin-bottom: 2rem;
        }
        .tp-hero-cover {
            width: 100%; height: 220px; object-fit: cover;
            display: block;
        }
        .tp-hero-cover-placeholder {
            width: 100%; height: 220px;
            background: linear-gradient(135deg, var(--red-soft), var(--blue-soft));
            display: flex; align-items: center; justify-content: center;
        }
        .tp-hero-body { padding: 1.5rem; }
        .tp-hero-meta { display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.75rem; flex-wrap: wrap; }
        .tp-hero-assoc {
            font-size: 0.8rem; font-weight: 600; color: var(--muted);
            display: flex; align-items: center; gap: 0.3rem;
        }
        .tp-hero-nature {
            padding: 0.25rem 0.7rem; border-radius: var(--radius-full);
            background: var(--red-soft); color: var(--red);
            font-size: 0.75rem; font-weight: 700;
        }
        .tp-hero-title { font-size: 1.45rem; font-weight: 800; color: var(--dark); margin-bottom: 0.6rem; line-height: 1.3; }
        .tp-hero-desc { font-size: 0.88rem; color: var(--muted); line-height: 1.6; margin-bottom: 1.25rem; }

        /* Progress */
        .tp-progress-bar-wrap { height: 8px; background: var(--bg); border-radius: var(--radius-full); overflow: hidden; margin-bottom: 0.6rem; }
        .tp-progress-bar-fill { height: 100%; background: linear-gradient(90deg, var(--red), #FF6B6B); border-radius: var(--radius-full); transition: width 1s ease; }
        .tp-progress-stats { display: flex; justify-content: space-between; font-size: 0.82rem; }
        .tp-stat-val { font-weight: 800; color: var(--dark); }
        .tp-stat-pct { font-weight: 800; color: var(--red); }
        .tp-stat-goal { color: var(--muted); }

        /* Objectif non-financier */
        .tp-objectif-note {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.65rem 0.9rem; background: var(--blue-soft);
            border: 1px solid rgba(29,53,87,0.12); border-radius: var(--radius-md);
            font-size: 0.82rem; color: var(--blue); font-weight: 500;
            margin-bottom: 1rem;
        }

        /* Stats row */
        .tp-stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; margin-bottom: 2rem; }
        .tp-stat-card {
            background: var(--card); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 1.1rem 1rem;
            text-align: center; box-shadow: var(--shadow-sm);
        }
        .tp-stat-card-val { font-size: 1.6rem; font-weight: 800; color: var(--dark); line-height: 1; margin-bottom: 0.3rem; }
        .tp-stat-card-val--red { color: var(--red); }
        .tp-stat-card-val--green { color: var(--green); }
        .tp-stat-card-val--blue { color: var(--blue); }
        .tp-stat-card-label { font-size: 0.75rem; color: var(--muted); font-weight: 600; }

        /* ─── Section ─── */
        .tp-section { margin-bottom: 2rem; }
        .tp-section-head {
            display: flex; align-items: center; gap: 0.75rem;
            margin-bottom: 1.15rem; padding-bottom: 0.85rem;
            border-bottom: 2px solid var(--border);
        }
        .tp-section-icon {
            width: 36px; height: 36px; border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .tp-section-icon--red { background: var(--red-soft); color: var(--red); }
        .tp-section-icon--green { background: var(--green-soft); color: var(--green); }
        .tp-section-icon--blue { background: var(--blue-soft); color: var(--blue); }
        .tp-section-icon--gold { background: rgba(244,168,40,0.1); color: var(--gold); }
        .tp-section-title { font-size: 1rem; font-weight: 700; color: var(--dark); }
        .tp-section-count { font-size: 0.78rem; font-weight: 600; color: var(--muted); margin-left: auto; }

        /* ─── Donation list ─── */
        .tp-don-list { display: flex; flex-direction: column; gap: 0.65rem; }
        .tp-don-item {
            display: flex; align-items: center; gap: 1rem;
            background: var(--card); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 0.9rem 1.1rem;
            transition: box-shadow 0.2s;
        }
        .tp-don-item:hover { box-shadow: var(--shadow-md); }
        .tp-don-avatar {
            width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.9rem; color: #fff;
        }
        .tp-don-avatar--anon { background: var(--muted-light); }
        .tp-don-avatar--fin { background: var(--red); }
        .tp-don-avatar--nat { background: var(--green); }
        .tp-don-avatar--comp { background: var(--blue); }
        .tp-don-info { flex: 1; min-width: 0; }
        .tp-don-name { font-weight: 700; font-size: 0.88rem; color: var(--dark); }
        .tp-don-detail { font-size: 0.78rem; color: var(--muted); margin-top: 0.1rem; }
        .tp-don-right { text-align: right; flex-shrink: 0; }
        .tp-don-amount { font-weight: 800; font-size: 0.95rem; color: var(--red); }
        .tp-don-amount--green { color: var(--green); }
        .tp-don-amount--blue { color: var(--blue); }
        .tp-don-date { font-size: 0.72rem; color: var(--muted-light); margin-top: 0.15rem; }
        .tp-don-msg {
            margin-top: 0.5rem; padding: 0.5rem 0.75rem;
            background: var(--bg); border-radius: var(--radius-sm);
            font-size: 0.78rem; color: var(--muted); font-style: italic;
            border-left: 2px solid var(--border);
        }

        /* ─── Tâches ─── */
        .tp-tache-list { display: flex; flex-direction: column; gap: 0.65rem; }
        .tp-tache-item {
            display: flex; align-items: flex-start; gap: 0.85rem;
            background: var(--card); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 0.9rem 1.1rem;
        }
        .tp-tache-dot {
            width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
            margin-top: 0.4rem;
        }
        .tp-tache-dot--ouverte { background: var(--muted-light); }
        .tp-tache-dot--en_cours { background: #F59E0B; }
        .tp-tache-dot--validee { background: var(--green); }
        .tp-tache-info { flex: 1; }
        .tp-tache-titre { font-weight: 700; font-size: 0.88rem; color: var(--dark); }
        .tp-tache-meta { font-size: 0.76rem; color: var(--muted); margin-top: 0.15rem; }
        .tp-tache-badge {
            padding: 0.2rem 0.65rem; border-radius: var(--radius-full);
            font-size: 0.72rem; font-weight: 700; flex-shrink: 0;
        }
        .tp-tache-badge--ouverte { background: var(--bg); color: var(--muted); border: 1px solid var(--border); }
        .tp-tache-badge--en_cours { background: rgba(245,158,11,0.1); color: #D97706; border: 1px solid rgba(245,158,11,0.2); }
        .tp-tache-badge--validee { background: var(--green-soft); color: #1A8C38; border: 1px solid rgba(45,198,83,0.2); }

        /* ─── Compte rendu ─── */
        .tp-cr-box {
            background: var(--card); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 1.25rem;
        }
        .tp-cr-text { font-size: 0.88rem; color: var(--body); line-height: 1.7; white-space: pre-wrap; }

        /* ─── Galerie ─── */
        .tp-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 0.75rem; }
        .tp-gallery-img {
            width: 100%; aspect-ratio: 1/1; object-fit: cover;
            border-radius: var(--radius-md); border: 1px solid var(--border);
            cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;
        }
        .tp-gallery-img:hover { transform: scale(1.03); box-shadow: var(--shadow-md); }

        /* ─── Empty ─── */
        .tp-empty {
            text-align: center; padding: 2rem 1rem;
            color: var(--muted-light); font-size: 0.85rem;
        }
        .tp-empty i { font-size: 2rem; display: block; margin-bottom: 0.5rem; opacity: 0.4; }

        /* ─── Footer ─── */
        .tp-footer {
            text-align: center; padding: 1.5rem;
            font-size: 0.78rem; color: var(--muted-light);
            border-top: 1px solid var(--border);
        }
        .tp-footer a { color: var(--red); text-decoration: none; font-weight: 600; }

        /* ─── Lightbox ─── */
        .tp-lightbox {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.88); z-index: 9999;
            align-items: center; justify-content: center;
        }
        .tp-lightbox.open { display: flex; }
        .tp-lightbox img { max-width: 90vw; max-height: 85vh; border-radius: var(--radius-lg); object-fit: contain; }
        .tp-lightbox-close {
            position: absolute; top: 1.5rem; right: 1.5rem;
            width: 40px; height: 40px; border-radius: 50%;
            background: rgba(255,255,255,0.15); border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center; color: #fff;
        }

        @media (max-width: 640px) {
            .tp-stats-row { grid-template-columns: repeat(3,1fr); gap: 0.5rem; }
            .tp-stat-card-val { font-size: 1.2rem; }
            .tp-gallery { grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); }
            .tp-hero-cover, .tp-hero-cover-placeholder { height: 160px; }
        }
    </style>
</head>
<body>

{{-- Header public --}}
<header class="tp-header">
    <div class="tp-header-inner">
        <a href="{{ route('campaigns.index') }}" class="tp-logo">
            <span class="tp-logo-dot"></span>
            Charity-Link
        </a>
        <span class="tp-badge">
            <i class="bi bi-shield-check-fill"></i>
            Page de transparence
        </span>
    </div>
</header>

<div class="tp-wrap">

    {{-- ═══ HERO CAMPAGNE ═══ --}}
    <div class="tp-hero">
        @if($campaign->affiche)
            <img src="{{ Storage::url($campaign->affiche) }}" alt="{{ $campaign->title }}" class="tp-hero-cover">
        @else
            <div class="tp-hero-cover-placeholder">
                <i class="bi bi-megaphone-fill" style="font-size:3rem; color:var(--red); opacity:0.3;"></i>
            </div>
        @endif
        <div class="tp-hero-body">
            <div class="tp-hero-meta">
                <span class="tp-hero-assoc">
                    <i class="bi bi-building"></i>
                    {{ $campaign->association->name }}
                </span>
                @if($campaign->nature)
                    <span class="tp-hero-nature">{{ $campaign->nature }}</span>
                @endif
                @if($campaign->status === 'active')
                    <span style="padding:0.2rem 0.6rem; background:var(--green-soft); color:#1A8C38; border-radius:var(--radius-full); font-size:0.72rem; font-weight:700; border:1px solid rgba(45,198,83,0.2);">
                        <i class="bi bi-circle-fill" style="font-size:0.5rem;"></i> Active
                    </span>
                @endif
            </div>
            <h1 class="tp-hero-title">{{ $campaign->title }}</h1>
            @if($campaign->description)
                <p class="tp-hero-desc">{{ $campaign->description }}</p>
            @endif

            @if($campaign->goal_amount)
                <div class="tp-progress-bar-wrap">
                    <div class="tp-progress-bar-fill" style="width: {{ min($campaign->progressPercentage(), 100) }}%"></div>
                </div>
                <div class="tp-progress-stats">
                    <span class="tp-stat-val">{{ number_format($campaign->current_amount, 0, ',', ' ') }} DT</span>
                    <span class="tp-stat-pct">{{ $campaign->progressPercentage() }}%</span>
                    <span class="tp-stat-goal">sur {{ number_format($campaign->goal_amount, 0, ',', ' ') }} DT</span>
                </div>
            @elseif($campaign->objectif_description)
                <div class="tp-objectif-note">
                    <i class="bi bi-bullseye"></i>
                    {{ $campaign->objectif_description }}
                </div>
            @endif
        </div>
    </div>

    {{-- ═══ STATS ═══ --}}
    <div class="tp-stats-row">
        <div class="tp-stat-card">
            <div class="tp-stat-card-val tp-stat-card-val--red">{{ $dons->count() }}</div>
            <div class="tp-stat-card-label">Contributions</div>
        </div>
        <div class="tp-stat-card">
            <div class="tp-stat-card-val tp-stat-card-val--green">{{ $taches->where('status','validee')->count() }}</div>
            <div class="tp-stat-card-label">Missions réalisées</div>
        </div>
        <div class="tp-stat-card">
            @if($campaign->goal_amount)
                <div class="tp-stat-card-val tp-stat-card-val--blue">{{ $campaign->progressPercentage() }}%</div>
                <div class="tp-stat-card-label">Objectif atteint</div>
            @else
                <div class="tp-stat-card-val tp-stat-card-val--blue">{{ $dons->where('type','nature')->count() }}</div>
                <div class="tp-stat-card-label">Dons en nature</div>
            @endif
        </div>
    </div>

    {{-- ═══ DONS ═══ --}}
    <div class="tp-section">
        <div class="tp-section-head">
            <div class="tp-section-icon tp-section-icon--red">
                <i class="bi bi-heart-fill"></i>
            </div>
            <span class="tp-section-title">Contributions reçues</span>
            <span class="tp-section-count">{{ $dons->count() }} au total</span>
        </div>

        @if($dons->count() > 0)
            <div class="tp-don-list">
                @foreach($dons as $don)
                    @php
                        $nomPublic = $don->is_anonymous ? 'Anonyme' : ($don->user->name ?? 'Utilisateur supprimé');
                        $initiale  = $don->is_anonymous ? '?' : strtoupper(substr($nomPublic, 0, 1));
                        $avatarClass = $don->is_anonymous ? 'tp-don-avatar--anon'
                            : ($don->type === 'financier' ? 'tp-don-avatar--fin'
                            : ($don->type === 'nature' ? 'tp-don-avatar--nat' : 'tp-don-avatar--comp'));
                        $amountClass = $don->type === 'financier' ? '' : ($don->type === 'nature' ? 'tp-don-amount--green' : 'tp-don-amount--blue');
                    @endphp
                    <div class="tp-don-item">
                        <div class="tp-don-avatar {{ $avatarClass }}">{{ $initiale }}</div>
                        <div class="tp-don-info">
                            <div class="tp-don-name">{{ $nomPublic }}</div>
                            <div class="tp-don-detail">
                                @if($don->type === 'financier') Don financier
                                @elseif($don->type === 'nature') Don en nature — {{ $don->quantity ?? '' }} {{ $don->category ?? '' }}
                                @else Compétence : {{ $don->competence ?? '' }}
                                @endif
                            </div>
                            @if($don->message)
                                <div class="tp-don-msg">"{{ $don->message }}"</div>
                            @endif
                        </div>
                        <div class="tp-don-right">
                            @if($don->type === 'financier' && $don->amount)
                                <div class="tp-don-amount {{ $amountClass }}">{{ number_format($don->amount, 0, ',', ' ') }} DT</div>
                            @elseif($don->type === 'nature')
                                <div class="tp-don-amount tp-don-amount--green">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                            @else
                                <div class="tp-don-amount tp-don-amount--blue">
                                    <i class="bi bi-tools"></i>
                                </div>
                            @endif
                            <div class="tp-don-date">{{ $don->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="tp-empty">
                <i class="bi bi-heart"></i>
                Aucune contribution pour l'instant.
            </div>
        @endif
    </div>

    {{-- ═══ TÂCHES / MISSIONS ═══ --}}
    @if($taches->count() > 0)
    <div class="tp-section">
        <div class="tp-section-head">
            <div class="tp-section-icon tp-section-icon--blue">
                <i class="bi bi-people-fill"></i>
            </div>
            <span class="tp-section-title">Missions bénévoles</span>
            <span class="tp-section-count">{{ $taches->count() }} mission(s)</span>
        </div>
        <div class="tp-tache-list">
            @foreach($taches as $tache)
                <div class="tp-tache-item">
                    <div class="tp-tache-dot tp-tache-dot--{{ $tache->status }}"></div>
                    <div class="tp-tache-info">
                        <div class="tp-tache-titre">{{ $tache->titre }}</div>
                        <div class="tp-tache-meta">
                            @if($tache->competence_requise) <i class="bi bi-star"></i> {{ $tache->competence_requise }} &nbsp;@endif
                            @if($tache->status === 'validee' && $tache->benevole) <i class="bi bi-person-check-fill"></i> {{ $tache->benevole->name }}@endif
                            @if($tache->deadline) &nbsp;<i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($tache->deadline)->format('d/m/Y') }}@endif
                        </div>
                    </div>
                    <span class="tp-tache-badge tp-tache-badge--{{ $tache->status }}">
                        @if($tache->status === 'ouverte') Ouverte
                        @elseif($tache->status === 'en_cours') En cours
                        @else Réalisée ✓
                        @endif
                    </span>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ═══ COMPTE RENDU ═══ --}}
    @if($campaign->compte_rendu)
    <div class="tp-section">
        <div class="tp-section-head">
            <div class="tp-section-icon tp-section-icon--gold">
                <i class="bi bi-file-text-fill"></i>
            </div>
            <span class="tp-section-title">Compte rendu de l'association</span>
        </div>
        <div class="tp-cr-box">
            <p class="tp-cr-text">{{ $campaign->compte_rendu }}</p>
        </div>
    </div>
    @endif

    {{-- ═══ GALERIE ═══ --}}
    @if($photos->count() > 0)
    <div class="tp-section">
        <div class="tp-section-head">
            <div class="tp-section-icon tp-section-icon--green">
                <i class="bi bi-images"></i>
            </div>
            <span class="tp-section-title">Galerie photos</span>
            <span class="tp-section-count">{{ $photos->count() }} photo(s)</span>
        </div>
        <div class="tp-gallery">
            @foreach($photos as $photo)
                <img src="{{ Storage::url($photo->path) }}"
                     alt="Photo campagne"
                     class="tp-gallery-img"
                     onclick="openLightbox('{{ Storage::url($photo->path) }}')">
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- Footer --}}
<footer class="tp-footer">
    Page de transparence publique &mdash; <a href="{{ route('campaigns.show', $campaign) }}">Voir la campagne complète</a>
    &nbsp;·&nbsp; <a href="{{ route('campaigns.index') }}">Charity-Link</a>
</footer>

{{-- Lightbox --}}
<div class="tp-lightbox" id="lightbox" onclick="closeLightbox()">
    <button class="tp-lightbox-close" onclick="closeLightbox()">
        <i class="bi bi-x-lg"></i>
    </button>
    <img src="" id="lightbox-img" alt="Photo">
</div>

<script>
    function openLightbox(src) {
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox').classList.add('open');
    }
    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('open');
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
</script>

</body>
</html>
