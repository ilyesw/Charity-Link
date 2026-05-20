<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label"><i class="bi bi-megaphone-fill"></i> Détail de la campagne</div>
            <h2 class="mb-0" style="font-size:1.5rem;">{{ Str::limit($campaign->title, 45) }}</h2>
            <p class="header-sub mb-0">Suivez l'avancement et contribuez à cette cause.</p>
        </div>
    </x-slot>

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
        <a href="{{ route('campaigns.index') }}" class="show-back" style="margin-bottom:0;">
            <i class="bi bi-arrow-left"></i> Retour aux campagnes
        </a>
        <a href="{{ route('campaigns.transparence', $campaign) }}"
        target="_blank"
        style="display:inline-flex; align-items:center; gap:0.4rem; font-size:0.82rem; font-weight:600; color:var(--cl-muted); text-decoration:none; padding:0.45rem 0.9rem; border:1.5px solid var(--cl-border); border-radius:var(--radius-md); transition:all 0.2s ease; background:var(--cl-card-bg);"
        onmouseover="this.style.color='#1A8C38'; this.style.borderColor='#2DC653';"
        onmouseout="this.style.color=''; this.style.borderColor='';">
            <i class="bi bi-shield-check"></i> Transparence publique
        </a>
    </div>

    @if(session('success'))
        <div class="show-flash show-flash--success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">

        {{-- ═══ LEFT COLUMN ═══ --}}
        <div class="col-lg-7">

            {{-- Affiche --}}
            @if($campaign->affiche)
                <img src="{{ asset('storage/' . $campaign->affiche) }}"
                    alt="Affiche" class="show-affiche">
            @endif

            <div class="show-main-card">

                {{-- Badges --}}
                <div class="show-top-row">
                    <span class="show-badge-cat">
                        <i class="bi bi-tag-fill"></i>
                        {{ $campaign->nature ?? ucfirst($campaign->association->category ?? 'Humanitaire') }}
                    </span>
                    <span class="show-badge-status">
                        <span class="show-status-dot"></span>
                        {{ ucfirst($campaign->status) }}
                    </span>
                </div>

                <h1 class="show-title">{{ $campaign->title }}</h1>

                {{-- Association --}}
                <a href="{{ route('associations.show', $campaign->association) }}" class="show-assoc-card">
                    <div class="show-assoc-avatar"><i class="bi bi-building"></i></div>
                    <div class="show-assoc-info">
                        <span class="show-assoc-label">Publiée par</span>
                        <span class="show-assoc-name">{{ $campaign->association->name }}</span>
                        <span class="show-assoc-region">
                            <i class="bi bi-geo-alt-fill"></i> {{ $campaign->association->region }}
                        </span>
                    </div>
                    <i class="bi bi-chevron-right show-assoc-arrow"></i>
                </a>

                {{-- Description --}}
                <div class="show-section">
                    <h6 class="show-section-title"><i class="bi bi-file-text"></i> À propos</h6>
                    <div class="show-description">{{ $campaign->description }}</div>
                </div>

                {{-- Objectif nature --}}
                @if($campaign->objectif_description)
                    <div class="show-objectif-card">
                        <i class="bi bi-bullseye"></i>
                        <div>
                            <span class="show-objectif-label">Objectif</span>
                            <span class="show-objectif-val">{{ $campaign->objectif_description }}</span>
                        </div>
                    </div>
                @endif

                {{-- Dates --}}
                @if($campaign->date_debut || $campaign->deadline)
                    <div class="show-dates-row">
                        @if($campaign->date_debut)
                            <div class="show-date-item">
                                <i class="bi bi-calendar-check"></i>
                                <div>
                                    <span class="show-date-label">Début</span>
                                    <span class="show-date-val">{{ $campaign->date_debut->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        @endif
                        @if($campaign->deadline)
                            <div class="show-date-item">
                                <i class="bi bi-calendar-event"></i>
                                <div>
                                    <span class="show-date-label">Fin</span>
                                    <span class="show-date-val">{{ $campaign->deadline->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Compte rendu --}}
                @if($campaign->compte_rendu)
                    <div class="show-section">
                        <h6 class="show-section-title"><i class="bi bi-clipboard-check"></i> Compte rendu final</h6>
                        <div class="show-report-block">{{ $campaign->compte_rendu }}</div>
                    </div>
                @endif

                {{-- Actions propriétaire --}}
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

            {{-- ═══ GALERIE PHOTOS ═══ --}}
            @if($campaign->photos->count() > 0)
                <div class="show-main-card mt-3">
                    <h6 class="show-section-title"><i class="bi bi-images"></i> Galerie photos</h6>
                    <div class="show-gallery">
                        @foreach($campaign->photos as $photo)
                            <div class="show-gallery-item">
                                <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->caption }}">
                                @auth
                                    @if(auth()->user()->id === $campaign->association->user_id)
                                        <form method="POST" action="{{ route('campaigns.photos.delete', $photo) }}">
                                            @csrf @method('DELETE')
                                            <button class="show-gallery-delete" title="Supprimer">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ═══ TÂCHES LIÉES À LA CAMPAGNE ═══ --}}
            <div class="show-main-card mt-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="show-section-title mb-0">
                        <i class="bi bi-list-check"></i>
                        Missions bénévoles
                        @if($campaign->taches->count() > 0)
                            <span class="show-tache-count">{{ $campaign->taches->count() }}</span>
                        @endif
                    </h6>
                    @auth
                        @if(auth()->user()->id === $campaign->association->user_id)
                            <button class="show-tache-add-btn" onclick="toggleTacheForm()" id="tacheToggleBtn">
                                <i class="bi bi-plus-lg"></i> Ajouter une mission
                            </button>
                        @endif
                    @endauth
                </div>

                {{-- Formulaire création tâche (association seulement) --}}
                @auth
                    @if(auth()->user()->id === $campaign->association->user_id)
                        <div id="tacheForm" style="display:none;">
                            <form method="POST" action="{{ route('taches.store') }}" class="show-tache-form">
                                @csrf
                                <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                                <div class="show-tache-grid mb-2">
                                    <div>
                                        <label class="fm-label-sm">Titre de la mission *</label>
                                        <input type="text" name="title" class="fm-input fm-input--sm"
                                            placeholder="Ex: Distribution couffins - Zone Nord" required>
                                    </div>
                                    <div>
                                        <label class="fm-label-sm">Compétence requise *</label>
                                        <input type="text" name="competence_requise" class="fm-input fm-input--sm"
                                            placeholder="Ex: Logistique, Communication..." required>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="fm-label-sm">Description *</label>
                                    <textarea name="description" class="fm-input fm-input--sm" rows="2"
                                        placeholder="Décrivez la mission et les responsabilités..." required></textarea>
                                </div>
                                <div class="show-tache-grid mb-3">
                                    <div>
                                        <label class="fm-label-sm">
                                            Deadline
                                            <span style="font-weight:400; color:var(--cl-muted);">optionnel</span>
                                        </label>
                                        <input type="date" name="deadline" class="fm-input fm-input--sm">
                                    </div>
                                    <div style="display:flex; align-items:flex-end;">
                                        <button type="submit" class="fm-btn fm-btn--red fm-btn--sm w-100">
                                            <i class="bi bi-plus-circle"></i> Créer la mission
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                @endauth

                {{-- Liste des tâches --}}
                @if($campaign->taches->count() > 0)
                    <div class="show-taches-list">
                        @foreach($campaign->taches as $tache)
                            <div class="show-tache-item">
                                <div class="show-tache-left">
                                    <div class="show-tache-status-dot show-tache-status-dot--{{ $tache->status }}"></div>
                                    <div class="show-tache-body">
                                        <span class="show-tache-title">{{ $tache->title }}</span>
                                        <span class="show-tache-meta">
                                            <i class="bi bi-tools"></i> {{ $tache->competence_requise }}
                                            @if($tache->deadline)
                                                &nbsp;·&nbsp;
                                                <i class="bi bi-calendar3"></i> {{ $tache->deadline->format('d/m/Y') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="show-tache-right">
                                    @switch($tache->status)
                                        @case('ouverte')
                                            <span class="show-tache-badge show-tache-badge--open">Ouverte</span>
                                            @auth
                                                @if(auth()->user()->isBenevole() && !$tache->benevole_id)
                                                    <form method="POST" action="{{ route('taches.postuler', $tache) }}" style="margin:0;">
                                                        @csrf
                                                        <button type="submit" class="show-tache-btn-postuler">
                                                            <i class="bi bi-hand-index-thumb"></i> Postuler
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth
                                            @break
                                        @case('en_cours')
                                            <span class="show-tache-badge show-tache-badge--progress">En cours</span>
                                            @if($tache->benevole)
                                                <span class="show-tache-benevole">
                                                    <i class="bi bi-person-fill"></i> {{ $tache->benevole->name }}
                                                </span>
                                            @endif
                                            @break
                                        @case('validee')
                                            <span class="show-tache-badge show-tache-badge--done">Validée ✓</span>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="show-tache-empty">
                        <i class="bi bi-people"></i>
                        <span>Aucune mission bénévole pour cette campagne.</span>
                    </div>
                @endif
            </div>

            {{-- ═══ TRANSPARENCE FINANCIÈRE ═══ --}}
            <div class="show-main-card mt-3">
                <h6 class="show-section-title"><i class="bi bi-eye"></i> Transparence financière</h6>

                {{-- Résumé solde --}}
                <div class="show-finance-summary">
                    <div class="show-finance-item show-finance-item--green">
                        <span class="show-finance-label">Total entrées</span>
                        <span class="show-finance-val">{{ number_format($totalEntrees, 2) }} DT</span>
                    </div>
                    <div class="show-finance-item show-finance-item--red">
                        <span class="show-finance-label">Total dépenses</span>
                        <span class="show-finance-val">{{ number_format($totalSorties, 2) }} DT</span>
                    </div>
                    <div class="show-finance-item show-finance-item--blue">
                        <span class="show-finance-label">Solde</span>
                        <span class="show-finance-val">{{ number_format($solde, 2) }} DT</span>
                    </div>
                </div>

                {{-- Formulaire ajout transaction (association seulement) --}}
                @auth
                    @if(auth()->user()->id === $campaign->association->user_id)
                        <div class="show-transaction-form">
                            <h6 class="show-section-title" style="font-size:0.82rem;">
                                <i class="bi bi-plus-circle"></i> Ajouter une entrée / sortie
                            </h6>
                            <form method="POST" action="{{ route('campaigns.transactions.store', $campaign) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="fm-row-3">
                                    <div>
                                        <select name="type" class="fm-input fm-input--sm" required>
                                            <option value="entree">💚 Entrée</option>
                                            <option value="sortie">🔴 Sortie</option>
                                        </select>
                                    </div>
                                    <div>
                                        <input type="text" name="description" class="fm-input fm-input--sm"
                                            placeholder="Description" required>
                                    </div>
                                    <div>
                                        <div class="fm-input-suffix-wrap">
                                            <input type="number" name="montant" class="fm-input fm-input--sm fm-input--has-suffix"
                                                placeholder="Montant" min="0" step="0.01" required>
                                            <span class="fm-input-suffix" style="font-size:0.75rem;">DT</span>
                                        </div>
                                        @error('montant')
                                            <p style="color:red; font-size:0.75rem; margin-top:0.25rem;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="fm-row" style="margin-top:0.6rem;">
                                    <div>
                                        <input type="date" name="date_transaction" class="fm-input fm-input--sm"
                                            min="2000-01-01" max="2100-12-31" required>
                                    </div>
                                    <div>
                                        <input type="file" name="justificatif" class="fm-input fm-input--sm fm-input-file"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                                <div style="text-align:right; margin-top:0.75rem;">
                                    <button type="submit" class="fm-btn fm-btn--red fm-btn--sm">
                                        <i class="bi bi-plus"></i> Ajouter
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                @endauth

                {{-- Liste transactions --}}
                @if($campaign->transactions->count() > 0)
                    <div class="show-transactions-list">
                        @foreach($campaign->transactions as $tx)
                            <div class="show-tx-item show-tx-item--{{ $tx->type }}">
                                <div class="show-tx-icon">
                                    <i class="bi bi-{{ $tx->type === 'entree' ? 'arrow-down-circle-fill' : 'arrow-up-circle-fill' }}"></i>
                                </div>
                                <div class="show-tx-info">
                                    <span class="show-tx-desc">{{ $tx->description }}</span>
                                    <span class="show-tx-date">{{ $tx->date_transaction->format('d/m/Y') }}</span>
                                </div>
                                <div class="show-tx-right">
                                    <span class="show-tx-amount show-tx-amount--{{ $tx->type }}">
                                        {{ $tx->type === 'entree' ? '+' : '-' }}{{ number_format($tx->montant, 2) }} DT
                                    </span>
                                    @if($tx->justificatif)
                                        <a href="{{ asset('storage/' . $tx->justificatif) }}" target="_blank"
                                            class="show-tx-justif" title="Voir justificatif">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </a>
                                    @endif
                                    @auth
                                        @if(auth()->user()->id === $campaign->association->user_id)
                                            <form method="POST" action="{{ route('campaigns.transactions.delete', $tx) }}" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button class="show-tx-delete" onclick="return confirm('Supprimer ?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="font-size:0.82rem; color:var(--cl-muted); text-align:center; padding:1rem 0;">
                        Aucune transaction enregistrée pour le moment.
                    </p>
                @endif
            </div>

            {{-- ═══ NOTATION ⭐ ═══ --}}
            <div class="show-main-card mt-3">
                <h6 class="show-section-title">
                    <i class="bi bi-star-fill" style="color:#F5A623;"></i>
                    Note de la campagne
                    @if($avgRating)
                        <span class="show-avg-rating">{{ $avgRating }}/5</span>
                        <span style="font-size:0.75rem; color:var(--cl-muted); font-weight:400;">
                            ({{ $campaign->ratings->count() }} avis)
                        </span>
                    @endif
                </h6>

                <div class="show-stars-display">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $avgRating >= $i ? '-fill' : ($avgRating >= $i - 0.5 ? '-half' : '') }}"
                            style="color:#F5A623; font-size:1.4rem;"></i>
                    @endfor
                </div>

                @auth
                    <form method="POST" action="{{ route('campaigns.rate', $campaign) }}" class="show-rate-form">
                        @csrf
                        <div class="show-star-picker">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="note" id="star{{ $i }}" value="{{ $i }}"
                                    {{ ($userRating && $userRating->note == $i) ? 'checked' : '' }}>
                                <label for="star{{ $i }}"><i class="bi bi-star-fill"></i></label>
                            @endfor
                        </div>
                        <button type="submit" class="fm-btn fm-btn--red fm-btn--sm" style="margin-top:0.75rem;">
                            <i class="bi bi-star"></i>
                            {{ $userRating ? 'Modifier ma note' : 'Soumettre ma note' }}
                        </button>
                    </form>
                @else
                    <p style="font-size:0.82rem; color:var(--cl-muted); margin-top:0.5rem;">
                        <a href="{{ route('login') }}" style="color:var(--cl-red);">Connectez-vous</a> pour noter cette campagne.
                    </p>
                @endauth
            </div>

        </div>

        {{-- ═══ RIGHT COLUMN (SIDEBAR) ═══ --}}
        <div class="col-lg-5">
            <div class="show-sidebar" style="position:sticky; top:90px;">

                <div class="show-progress-card">
                    <div class="show-progress-header">
                        <span class="show-progress-label">
                            <i class="bi bi-graph-up-arrow"></i> Progression de la collecte
                        </span>
                    </div>

                    @if($campaign->goal_amount)
                        <div class="show-progress-amount-wrap">
                            <span class="show-progress-amount">{{ number_format($campaign->current_amount, 0) }}</span>
                            <span class="show-progress-currency">DT</span>
                        </div>
                        <div class="show-progress-sub">collectés sur {{ number_format($campaign->goal_amount, 0) }} DT</div>
                        <div class="show-progress-track">
                            <div class="show-progress-fill" style="width:{{ $campaign->progressPercentage() }}%;"></div>
                        </div>
                        <div class="show-progress-meta">
                            <div class="show-progress-pct">{{ $campaign->progressPercentage() }}%</div>
                            <div class="show-progress-remaining">
                                @php $remaining = $campaign->goal_amount - $campaign->current_amount; @endphp
                                @if($remaining > 0) Il reste {{ number_format($remaining, 0) }} DT
                                @else Objectif atteint ! 🎉 @endif
                            </div>
                        </div>
                    @elseif($campaign->objectif_description)
                        <div class="show-objectif-card" style="margin-bottom:1rem;">
                            <i class="bi bi-bullseye"></i>
                            <div>
                                <span class="show-objectif-label">Objectif</span>
                                <span class="show-objectif-val">{{ $campaign->objectif_description }}</span>
                            </div>
                        </div>
                    @endif

                    @auth
                        @if(auth()->user()->isDonateur())
                            <a href="{{ route('donations.create', $campaign) }}" class="show-btn-donate">
                                <i class="bi bi-heart-fill"></i> Faire un don
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="show-btn-donate show-btn-donate-outline">
                            <i class="bi bi-box-arrow-in-right"></i> Connectez-vous pour donner
                        </a>
                    @endauth

                    <a href="{{ route('chatbot.index') }}" class="show-chatbot-link">
                        <div class="show-chatbot-icon"><i class="bi bi-robot"></i></div>
                        <div>
                            <span class="show-chatbot-title">Besoin d'aide ?</span>
                            <span class="show-chatbot-sub">Parler à l'assistant IA</span>
                        </div>
                        <i class="bi bi-chevron-right show-chatbot-arrow"></i>
                    </a>
                </div>

                <div class="show-trust-row">
                    <div class="show-trust-item"><i class="bi bi-shield-check"></i><span>Association vérifiée</span></div>
                    <div class="show-trust-item"><i class="bi bi-lock-fill"></i><span>Don sécurisé</span></div>
                    <div class="show-trust-item"><i class="bi bi-eye-fill"></i><span>Transparent</span></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .show-back { display:inline-flex; align-items:center; gap:0.4rem; font-size:0.85rem; font-weight:600; color:var(--cl-muted); text-decoration:none; padding:0.5rem 0; margin-bottom:1.5rem; transition:color 0.2s ease; }
        .show-back:hover { color:var(--cl-red); }
        .show-flash { display:flex; align-items:center; gap:0.5rem; padding:0.75rem 1rem; border-radius:var(--radius-md); font-size:0.84rem; font-weight:500; margin-bottom:1.25rem; }
        .show-flash--success { background:var(--cl-green-soft); color:#1A8C38; border:1px solid rgba(45,198,83,0.15); }
        .show-affiche { width:100%; max-height:320px; object-fit:cover; border-radius:var(--radius-xl); margin-bottom:1rem; }
        .show-main-card { background:var(--cl-card-bg); border:1px solid var(--cl-card-border); border-radius:var(--radius-xl); padding:1.75rem; transition:all 0.35s ease; }
        .show-top-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem; }
        .show-badge-cat { display:inline-flex; align-items:center; gap:0.3rem; background:var(--cl-blue-soft); color:var(--cl-blue); font-size:0.7rem; font-weight:700; padding:0.3rem 0.65rem; border-radius:var(--radius-full); }
        .show-badge-status { display:inline-flex; align-items:center; gap:0.35rem; font-size:0.7rem; font-weight:600; color:var(--cl-green); background:var(--cl-green-soft); padding:0.25rem 0.6rem; border-radius:var(--radius-full); }
        .show-status-dot { width:6px; height:6px; background:var(--cl-green); border-radius:50%; }
        .show-title { font-size:clamp(1.3rem,3vw,1.75rem); font-weight:700; line-height:1.25; margin-bottom:1.5rem; color:var(--cl-dark); }
        .show-assoc-card { display:flex; align-items:center; gap:1rem; padding:1rem; background:var(--cl-light); border:1px solid var(--cl-border); border-radius:var(--radius-lg); text-decoration:none; margin-bottom:1.75rem; transition:all 0.25s ease; }
        .show-assoc-card:hover { border-color:var(--cl-red); background:var(--cl-red-glow); }
        .show-assoc-avatar { width:48px; height:48px; background:var(--cl-card-bg); border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:var(--shadow-sm); }
        .show-assoc-avatar i { font-size:1.15rem; color:var(--cl-red); }
        .show-assoc-info { display:flex; flex-direction:column; gap:0.15rem; flex:1; }
        .show-assoc-label { font-size:0.72rem; color:var(--cl-muted); text-transform:uppercase; letter-spacing:0.06em; font-weight:500; }
        .show-assoc-name { font-size:0.95rem; font-weight:700; color:var(--cl-dark); }
        .show-assoc-region { font-size:0.78rem; color:var(--cl-muted); display:flex; align-items:center; gap:0.25rem; }
        .show-assoc-arrow { font-size:0.9rem; color:var(--cl-muted); transition:all 0.2s ease; }
        .show-assoc-card:hover .show-assoc-arrow { color:var(--cl-red); transform:translateX(3px); }
        .show-section { margin-bottom:1.5rem; }
        .show-section-title { font-family:'Inter',sans-serif; font-size:0.9rem; font-weight:700; color:var(--cl-dark); margin-bottom:0.75rem; display:flex; align-items:center; gap:0.5rem; }
        .show-section-title i { color:var(--cl-red); font-size:0.85rem; }
        .show-description { font-size:0.92rem; color:var(--cl-body); line-height:1.8; }
        .show-objectif-card { display:flex; align-items:center; gap:0.75rem; padding:0.85rem 1rem; background:var(--cl-blue-soft); border:1px solid rgba(29,53,87,0.12); border-radius:var(--radius-md); margin-bottom:1rem; }
        .show-objectif-card i { font-size:1.2rem; color:var(--cl-blue); flex-shrink:0; }
        .show-objectif-label { display:block; font-size:0.72rem; color:var(--cl-muted); font-weight:500; }
        .show-objectif-val { display:block; font-size:0.9rem; font-weight:700; color:var(--cl-dark); }
        .show-dates-row { display:flex; gap:1rem; margin-bottom:1.25rem; }
        .show-date-item { display:flex; align-items:center; gap:0.6rem; padding:0.75rem 1rem; background:var(--cl-light); border:1px solid var(--cl-border); border-radius:var(--radius-md); flex:1; }
        .show-date-item i { font-size:1.1rem; color:var(--cl-red); flex-shrink:0; }
        .show-date-label { display:block; font-size:0.72rem; color:var(--cl-muted); font-weight:500; }
        .show-date-val { display:block; font-size:0.88rem; font-weight:700; color:var(--cl-dark); }
        .show-report-block { background:var(--cl-green-soft); border:1px solid rgba(45,198,83,0.15); border-radius:var(--radius-md); padding:1rem; font-size:0.85rem; color:var(--cl-body); line-height:1.7; }
        .show-owner-actions { padding-top:1.25rem; border-top:1px solid var(--cl-border); margin-top:1.5rem; }
        .show-btn-edit { display:inline-flex; align-items:center; gap:0.35rem; font-size:0.85rem; font-weight:600; color:var(--cl-muted); text-decoration:none; padding:0.5rem 1rem; border-radius:var(--radius-sm); transition:all 0.2s ease; }
        .show-btn-edit:hover { color:var(--cl-dark); background:var(--cl-light); }

        /* Gallery */
        .show-gallery { display:grid; grid-template-columns:repeat(3,1fr); gap:0.5rem; margin-top:0.75rem; }
        .show-gallery-item { position:relative; border-radius:var(--radius-md); overflow:hidden; aspect-ratio:1; }
        .show-gallery-item img { width:100%; height:100%; object-fit:cover; }
        .show-gallery-delete { position:absolute; top:4px; right:4px; background:rgba(0,0,0,0.5); color:#fff; border:none; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:0.7rem; }

        /* Tâches */
        .show-tache-count { background:var(--cl-red-glow); color:var(--cl-red); font-size:0.72rem; font-weight:700; padding:0.15rem 0.5rem; border-radius:var(--radius-full); margin-left:0.4rem; }
        .show-tache-add-btn { display:inline-flex; align-items:center; gap:0.3rem; font-size:0.8rem; font-weight:600; color:var(--cl-red); background:var(--cl-red-glow); border:1px solid rgba(230,57,70,0.15); border-radius:var(--radius-sm); padding:0.35rem 0.8rem; cursor:pointer; transition:all 0.2s ease; }
        .show-tache-add-btn:hover { background:var(--cl-red); color:#fff; }
        .show-tache-form { background:var(--cl-light); border:1px solid var(--cl-border); border-radius:var(--radius-md); padding:1rem; margin-bottom:1rem; }
        .show-tache-grid { display:grid; grid-template-columns:1fr 1fr; gap:0.75rem; }
        .fm-label-sm { display:block; font-family:'Inter',sans-serif; font-weight:600; font-size:0.75rem; color:var(--cl-body); margin-bottom:0.3rem; }
        .show-taches-list { display:flex; flex-direction:column; gap:0.5rem; }
        .show-tache-item { display:flex; align-items:center; justify-content:space-between; gap:1rem; padding:0.85rem 1rem; background:var(--cl-light); border:1px solid var(--cl-border); border-radius:var(--radius-md); transition:all 0.2s ease; }
        .show-tache-item:hover { border-color:var(--cl-red); background:var(--cl-red-glow); }
        .show-tache-left { display:flex; align-items:center; gap:0.75rem; flex:1; min-width:0; }
        .show-tache-status-dot { width:10px; height:10px; border-radius:50%; flex-shrink:0; }
        .show-tache-status-dot--ouverte { background:var(--cl-green); box-shadow:0 0 0 3px rgba(45,198,83,0.2); }
        .show-tache-status-dot--en_cours { background:#f59e0b; box-shadow:0 0 0 3px rgba(245,158,11,0.2); }
        .show-tache-status-dot--validee { background:var(--cl-muted); }
        .show-tache-body { min-width:0; }
        .show-tache-title { display:block; font-size:0.88rem; font-weight:600; color:var(--cl-dark); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .show-tache-meta { display:flex; align-items:center; gap:0.3rem; font-size:0.73rem; color:var(--cl-muted); margin-top:0.15rem; flex-wrap:wrap; }
        .show-tache-meta i { font-size:0.7rem; color:var(--cl-red); }
        .show-tache-right { display:flex; align-items:center; gap:0.5rem; flex-shrink:0; }
        .show-tache-badge { font-size:0.7rem; font-weight:700; padding:0.25rem 0.6rem; border-radius:var(--radius-full); white-space:nowrap; }
        .show-tache-badge--open { background:var(--cl-green-soft); color:var(--cl-green); }
        .show-tache-badge--progress { background:rgba(245,158,11,0.12); color:#b45309; }
        .show-tache-badge--done { background:var(--cl-light); color:var(--cl-muted); border:1px solid var(--cl-border); }
        .show-tache-btn-postuler { display:inline-flex; align-items:center; gap:0.3rem; font-size:0.78rem; font-weight:700; background:var(--cl-red); color:#fff; border:none; border-radius:var(--radius-full); padding:0.35rem 0.85rem; cursor:pointer; transition:all 0.2s ease; white-space:nowrap; }
        .show-tache-btn-postuler:hover { background:var(--cl-red-hover); transform:translateY(-1px); }
        .show-tache-benevole { font-size:0.75rem; color:var(--cl-muted); display:flex; align-items:center; gap:0.25rem; }
        .show-tache-empty { display:flex; align-items:center; gap:0.6rem; padding:1.25rem; color:var(--cl-muted); font-size:0.85rem; justify-content:center; }
        .show-tache-empty i { font-size:1.2rem; color:var(--cl-border); }

        /* Finance */
        .show-finance-summary { display:grid; grid-template-columns:repeat(3,1fr); gap:0.75rem; margin-bottom:1.25rem; }
        .show-finance-item { padding:0.85rem; border-radius:var(--radius-md); text-align:center; }
        .show-finance-item--green { background:var(--cl-green-soft); }
        .show-finance-item--red { background:var(--cl-red-soft, var(--cl-red-glow)); }
        .show-finance-item--blue { background:var(--cl-blue-soft); }
        .show-finance-label { display:block; font-size:0.72rem; font-weight:600; color:var(--cl-muted); margin-bottom:0.25rem; }
        .show-finance-val { display:block; font-size:0.95rem; font-weight:800; color:var(--cl-dark); }
        .show-transaction-form { background:var(--cl-light); border:1px solid var(--cl-border); border-radius:var(--radius-md); padding:1rem; margin-bottom:1rem; }
        .fm-row-3 { display:grid; grid-template-columns:1fr 2fr 1fr; gap:0.5rem; }
        .fm-input--sm { padding:0.45rem 0.7rem; font-size:0.82rem; }
        .fm-row { display:grid; grid-template-columns:1fr 1fr; gap:0.5rem; }
        .fm-input { width:100%; font-family:'Inter',sans-serif; color:var(--cl-dark); background:var(--cl-card-bg); border:1.5px solid var(--cl-border); border-radius:var(--radius-md); outline:none !important; transition:all 0.25s ease; }
        .fm-input:focus { border-color:var(--cl-red) !important; box-shadow:0 0 0 3px rgba(230,57,70,0.08) !important; }
        .fm-input-file { cursor:pointer; }
        .fm-input--has-suffix { padding-right:2.5rem; }
        .fm-input-suffix-wrap { position:relative; }
        .fm-input-suffix { position:absolute; right:0.75rem; top:50%; transform:translateY(-50%); font-weight:700; color:var(--cl-dark); pointer-events:none; }
        .show-transactions-list { display:flex; flex-direction:column; gap:0.5rem; }
        .show-tx-item { display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; background:var(--cl-light); border-radius:var(--radius-md); }
        .show-tx-icon i { font-size:1.2rem; }
        .show-tx-item--entree .show-tx-icon i { color:var(--cl-green); }
        .show-tx-item--sortie .show-tx-icon i { color:var(--cl-red); }
        .show-tx-info { flex:1; min-width:0; }
        .show-tx-desc { display:block; font-size:0.85rem; font-weight:600; color:var(--cl-dark); }
        .show-tx-date { display:block; font-size:0.75rem; color:var(--cl-muted); }
        .show-tx-right { display:flex; align-items:center; gap:0.5rem; flex-shrink:0; }
        .show-tx-amount { font-size:0.9rem; font-weight:800; }
        .show-tx-amount--entree { color:var(--cl-green); }
        .show-tx-amount--sortie { color:var(--cl-red); }
        .show-tx-justif { color:var(--cl-muted); font-size:0.9rem; transition:color 0.2s; }
        .show-tx-justif:hover { color:var(--cl-red); }
        .show-tx-delete { background:none; border:none; color:var(--cl-muted); cursor:pointer; font-size:0.85rem; transition:color 0.2s; }
        .show-tx-delete:hover { color:var(--cl-red); }

        /* Rating */
        .show-avg-rating { background:rgba(245,166,35,0.12); color:#B8860B; padding:0.2rem 0.5rem; border-radius:var(--radius-full); font-size:0.78rem; font-weight:700; margin-left:0.4rem; }
        .show-stars-display { margin-bottom:0.75rem; }
        .show-rate-form { margin-top:0.5rem; }
        .show-star-picker { display:flex; flex-direction:row-reverse; gap:0.25rem; width:fit-content; }
        .show-star-picker input { display:none; }
        .show-star-picker label { font-size:1.6rem; color:#ddd; cursor:pointer; transition:color 0.15s; }
        .show-star-picker input:checked ~ label,
        .show-star-picker label:hover,
        .show-star-picker label:hover ~ label { color:#F5A623; }

        /* Sidebar */
        .show-sidebar { display:flex; flex-direction:column; gap:1rem; }
        .show-progress-card { background:var(--cl-card-bg); border:1px solid var(--cl-card-border); border-radius:var(--radius-xl); padding:1.75rem; }
        .show-progress-label { font-size:0.82rem; font-weight:600; color:var(--cl-muted); display:flex; align-items:center; gap:0.4rem; }
        .show-progress-label i { color:var(--cl-red); }
        .show-progress-header { margin-bottom:1.5rem; }
        .show-progress-amount-wrap { text-align:center; margin-bottom:0.35rem; }
        .show-progress-amount { font-family:'Playfair Display',serif; font-size:2.5rem; font-weight:700; color:var(--cl-red); line-height:1; }
        .show-progress-currency { font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:700; color:var(--cl-red); opacity:0.6; }
        .show-progress-sub { text-align:center; font-size:0.82rem; color:var(--cl-muted); margin-bottom:1.25rem; }
        .show-progress-track { height:8px; background:var(--cl-light); border-radius:var(--radius-full); overflow:hidden; margin-bottom:0.75rem; }
        .show-progress-fill { height:100%; background:linear-gradient(90deg,var(--cl-red),#f87171); border-radius:var(--radius-full); transition:width 1.2s cubic-bezier(0.22,1,0.36,1); }
        .show-progress-meta { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; }
        .show-progress-pct { font-weight:800; font-size:1rem; color:var(--cl-red); background:var(--cl-red-glow); padding:0.25rem 0.65rem; border-radius:var(--radius-full); }
        .show-progress-remaining { font-size:0.8rem; color:var(--cl-muted); font-weight:500; }
        .show-btn-donate { display:flex; align-items:center; justify-content:center; gap:0.5rem; width:100%; background:var(--cl-red); color:#fff; border:none; border-radius:var(--radius-full); padding:0.9rem; font-size:1rem; font-weight:700; text-decoration:none; transition:all 0.3s ease; margin-bottom:0.75rem; }
        .show-btn-donate:hover { background:var(--cl-red-hover); color:#fff; transform:translateY(-2px); box-shadow:0 8px 30px rgba(230,57,70,0.35); }
        .show-btn-donate-outline { background:transparent; border:2px solid var(--cl-red); color:var(--cl-red); }
        .show-chatbot-link { display:flex; align-items:center; gap:0.75rem; padding:0.85rem 1rem; background:var(--cl-light); border:1px solid var(--cl-border); border-radius:var(--radius-lg); text-decoration:none; transition:all 0.25s ease; }
        .show-chatbot-link:hover { border-color:var(--cl-blue); }
        .show-chatbot-icon { width:38px; height:38px; background:var(--cl-blue-soft); border-radius:var(--radius-sm); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .show-chatbot-icon i { font-size:1rem; color:var(--cl-blue); }
        .show-chatbot-title { display:block; font-size:0.85rem; font-weight:600; color:var(--cl-dark); }
        .show-chatbot-sub { display:block; font-size:0.75rem; color:var(--cl-muted); }
        .show-chatbot-arrow { font-size:0.85rem; color:var(--cl-muted); margin-left:auto; transition:all 0.2s ease; }
        .show-chatbot-link:hover .show-chatbot-arrow { color:var(--cl-blue); transform:translateX(3px); }
        .show-trust-row { display:flex; justify-content:center; gap:1.25rem; padding:1rem; background:var(--cl-card-bg); border:1px solid var(--cl-card-border); border-radius:var(--radius-lg); }
        .show-trust-item { display:flex; align-items:center; gap:0.4rem; font-size:0.75rem; font-weight:500; color:var(--cl-muted); }
        .show-trust-item i { font-size:0.85rem; color:var(--cl-green); }
        .fm-btn { display:inline-flex; align-items:center; gap:0.45rem; padding:0.6rem 1.4rem; font-family:'Inter',sans-serif; font-weight:600; font-size:0.84rem; border-radius:var(--radius-md); text-decoration:none; cursor:pointer; transition:all 0.25s ease; border:none !important; }
        .fm-btn--red { background:var(--cl-red); color:#fff; }
        .fm-btn--red:hover { background:var(--cl-red-hover); color:#fff; }
        .fm-btn--sm { padding:0.45rem 1rem; font-size:0.8rem; }
        @media (max-width:767.98px) {
            .show-finance-summary { grid-template-columns:1fr; }
            .show-gallery { grid-template-columns:repeat(2,1fr); }
            .fm-row-3 { grid-template-columns:1fr; }
            .show-dates-row { flex-direction:column; }
            .show-tache-grid { grid-template-columns:1fr; }
            .show-tache-item { flex-direction:column; align-items:flex-start; gap:0.5rem; }
            .show-tache-right { width:100%; justify-content:flex-end; }
        }
    </style>

    <script>
    function toggleTacheForm() {
        const form = document.getElementById('tacheForm');
        const btn  = document.getElementById('tacheToggleBtn');
        const open = form.style.display === 'none' || form.style.display === '';
        form.style.display = open ? 'block' : 'none';
        btn.innerHTML = open
            ? '<i class="bi bi-x-lg"></i> Annuler'
            : '<i class="bi bi-plus-lg"></i> Ajouter une mission';
    }
    </script>
</x-app-layout>
