<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                Faire un don
            </div>
            <h2 class="mb-0" style="font-size:1.5rem;">Contribuer</h2>
            <p class="header-sub mb-0">Choisissez votre type de contribution.</p>
        </div>
        <a href="{{ route('campaigns.show', $campaign) }}" class="ls-header-btn ls-header-btn--ghost d-none d-md-inline-flex">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Retour
        </a>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-7">

            {{-- Info campagne --}}
            <div class="dn-campaign-card mb-4">
                <div class="dn-campaign-top">
                    <div class="dn-campaign-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E63946" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div class="dn-campaign-info">
                        <div class="dn-campaign-title">{{ $campaign->title }}</div>
                        <small class="dn-campaign-sub">{{ $campaign->association->name }}</small>
                    </div>
                </div>
                @if($campaign->goal_amount)
                <div class="dn-progress-wrap">
                    <div class="dn-progress-bar" style="width: {{ $campaign->progressPercentage() }}%"></div>
                </div>
                <div class="dn-progress-stats">
                    <span class="dn-progress-current">{{ number_format($campaign->current_amount, 0) }} DT</span>
                    <span class="dn-progress-pct">{{ $campaign->progressPercentage() }}%</span>
                    <span class="dn-progress-goal">Objectif : {{ number_format($campaign->goal_amount, 0) }} DT</span>
                </div>
                @elseif($campaign->objectif_description)
                <div class="dn-info-note dn-info-note--blue mt-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    {{ $campaign->objectif_description }}
                </div>
                @endif
            </div>

            {{-- Formulaire --}}
            <div class="fm-card">

                @if($errors->any())
                    <div class="fm-alert">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#E63946" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('donations.store', $campaign) }}">
                    @csrf

                    {{-- Type de don --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#E63946" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
                            </div>
                            <span class="fm-section-title">Type de don</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="dn-type-grid">

                                <label class="dn-type-card">
                                    <input type="radio" name="type" value="financier" class="dn-type-radio"
                                        onchange="showSection('financier')"
                                        {{ old('type') == 'financier' ? 'checked' : '' }}>
                                    <div class="dn-type-icon dn-type-icon--finance">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                    </div>
                                    <span class="dn-type-label">Financier</span>
                                </label>

                                <label class="dn-type-card">
                                    <input type="radio" name="type" value="nature" class="dn-type-radio"
                                        onchange="showSection('nature')"
                                        {{ old('type') == 'nature' ? 'checked' : '' }}>
                                    <div class="dn-type-icon dn-type-icon--nature">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                                    </div>
                                    <span class="dn-type-label">En nature</span>
                                </label>

                                <label class="dn-type-card">
                                    <input type="radio" name="type" value="competences" class="dn-type-radio"
                                        onchange="showSection('competences')"
                                        {{ old('type') == 'competences' ? 'checked' : '' }}>
                                    <div class="dn-type-icon dn-type-icon--skill">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a8 8 0 0 0-8 8c0 6 8 12 8 12s8-6 8-12a8 8 0 0 0-8-8z"/><circle cx="12" cy="10" r="3"/></svg>
                                    </div>
                                    <span class="dn-type-label">Compétences</span>
                                </label>

                            </div>
                        </div>
                    </div>

                    {{-- Section Financier --}}
                    <div id="section-financier" class="dn-section d-none">
                        <div class="dn-info-note dn-info-note--green">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            Don simulé en Dinar Tunisien — pas de vrai paiement
                        </div>
                        <div class="fm-group">
                            <label class="fm-label">Montant (DT)</label>
                            <div class="dn-amount-chips">
                                @foreach([10, 25, 50, 100] as $m)
                                    <button type="button" class="dn-chip" onclick="setAmount({{ $m }})">
                                        {{ $m }} DT
                                    </button>
                                @endforeach
                            </div>
                            <div class="fm-input-suffix-wrap mt-2">
                                <span class="fm-input-suffix">DT</span>
                                <input type="number" name="amount" id="amount" class="fm-input fm-input--has-suffix"
                                    value="{{ old('amount') }}" min="1" step="0.01"
                                    placeholder="Montant personnalisé">
                            </div>
                        </div>
                    </div>

                    {{-- Section Nature --}}
                    <div id="section-nature" class="dn-section d-none">
                        <div class="fm-row">
                            <div class="fm-group">
                                <label class="fm-label">Catégorie</label>
                                <div class="fm-input-icon-wrap">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                                    <select name="category" class="fm-input fm-input--has-icon fm-select">
                                        <option value="vetements" {{ old('category') == 'vetements' ? 'selected' : '' }}>Vêtements</option>
                                        <option value="nourriture" {{ old('category') == 'nourriture' ? 'selected' : '' }}>Nourriture</option>
                                        <option value="medicaments" {{ old('category') == 'medicaments' ? 'selected' : '' }}>Médicaments</option>
                                        <option value="scolaire" {{ old('category') == 'scolaire' ? 'selected' : '' }}>Matériel scolaire</option>
                                        <option value="autre" {{ old('category') == 'autre' ? 'selected' : '' }}>Autre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="fm-group">
                                <label class="fm-label">Quantité</label>
                                <input type="number" name="quantity" class="fm-input"
                                    value="{{ old('quantity') }}" min="1" placeholder="Ex: 5">
                            </div>
                        </div>
                        <div class="fm-group">
                            <label class="fm-label">Description de l'article <span class="fm-section-optional">optionnel</span></label>
                            <input type="text" name="item_description" class="fm-input"
                                value="{{ old('item_description') }}"
                                placeholder="Ex: Manteaux adultes taille M/L, livres scolaires primaire...">
                        </div>
                        <div class="fm-group">
                            <label class="fm-label">Lieu de dépôt</label>
                            <div class="fm-input-icon-wrap">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <input type="text" name="pickup_address" class="fm-input fm-input--has-icon"
                                    value="{{ old('pickup_address') }}"
                                    placeholder="Ex: 12 Rue de la Paix, Sousse">
                            </div>
                        </div>
                    </div>

                    {{-- Section Compétences --}}
                    <div id="section-competences" class="dn-section d-none">
                        <div class="fm-group">
                            <label class="fm-label">Votre compétence</label>
                            <div class="fm-input-icon-wrap">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <input type="text" name="competence" class="fm-input fm-input--has-icon"
                                    value="{{ old('competence') }}"
                                    placeholder="Ex: Médecin, Professeur, Développeur...">
                            </div>
                        </div>
                        <div class="fm-group">
                            <label class="fm-label">Disponibilité</label>
                            <div class="fm-input-icon-wrap">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <input type="text" name="availability" class="fm-input fm-input--has-icon"
                                    value="{{ old('availability') }}"
                                    placeholder="Ex: Week-ends, Lundi matin...">
                            </div>
                        </div>
                        <div class="fm-group">
                            <label class="fm-label">Description de l'aide</label>
                            <textarea name="competence_desc" class="fm-input fm-textarea" rows="3"
                                placeholder="Décrivez comment vous pouvez aider...">{{ old('competence_desc') }}</textarea>
                        </div>
                    </div>

                    {{-- Message --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon fm-section-icon--muted">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </div>
                            <span class="fm-section-title">Message <span class="fm-section-optional">optionnel</span></span>
                        </div>
                        <div class="fm-section-body">
                            <textarea name="message" class="fm-input fm-textarea" rows="2"
                                placeholder="Un mot d'encouragement...">{{ old('message') }}</textarea>
                        </div>
                    </div>

                    {{-- ═══ ANONYMAT ═══ --}}
                    <div class="dn-anon-box">
                        <label class="dn-anon-label" for="is_anonymous">
                            <div class="dn-anon-left">
                                <div class="dn-anon-icon">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                        <line x1="2" y1="2" x2="22" y2="22"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="dn-anon-title">Don anonyme</div>
                                    <div class="dn-anon-sub">Votre nom n'apparaîtra pas publiquement</div>
                                </div>
                            </div>
                            {{-- Toggle switch --}}
                            <div class="dn-toggle-wrap">
                                <input type="checkbox" name="is_anonymous" id="is_anonymous"
                                    class="dn-toggle-input"
                                    value="1"
                                    {{ old('is_anonymous') ? 'checked' : '' }}
                                    onchange="updateAnonPreview(this.checked)">
                                <span class="dn-toggle-track">
                                    <span class="dn-toggle-thumb"></span>
                                </span>
                            </div>
                        </label>

                        {{-- Preview --}}
                        <div id="anon-preview" class="dn-anon-preview d-none">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            Votre don sera affiché comme : <strong>Donateur anonyme</strong>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="fm-actions">
                        <a href="{{ route('campaigns.show', $campaign) }}" class="fm-btn fm-btn--ghost">
                            Annuler
                        </a>
                        <button type="submit" class="fm-btn fm-btn--red">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                            Confirmer le don
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function showSection(type) {
            ['financier','nature','competences'].forEach(t => {
                document.getElementById('section-' + t).classList.add('d-none');
            });
            document.getElementById('section-' + type).classList.remove('d-none');
        }

        function setAmount(val) {
            document.getElementById('amount').value = val;
            document.querySelectorAll('.dn-chip').forEach(c => c.classList.remove('dn-chip--active'));
            event.target.classList.add('dn-chip--active');
        }

        function updateAnonPreview(checked) {
            const preview = document.getElementById('anon-preview');
            const box = document.querySelector('.dn-anon-box');
            if (checked) {
                preview.classList.remove('d-none');
                box.classList.add('dn-anon-box--active');
            } else {
                preview.classList.add('d-none');
                box.classList.remove('dn-anon-box--active');
            }
        }

        @if(old('type'))
            showSection('{{ old('type') }}');
        @endif

        @if(old('is_anonymous'))
            updateAnonPreview(true);
        @endif
    </script>

    <style>
        .ls-header-btn {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.5rem 1rem;
            font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.82rem;
            border-radius: var(--radius-md);
            text-decoration: none; cursor: pointer;
            transition: all 0.25s ease;
            border: 1.5px solid var(--cl-border);
            color: var(--cl-muted); background: var(--cl-card-bg);
        }
        .ls-header-btn:hover { color: var(--cl-dark); border-color: var(--cl-muted); background: var(--cl-light); }

        /* ─── Campaign card ─── */
        .dn-campaign-card {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-xl);
            padding: 1.25rem 1.35rem;
            box-shadow: var(--shadow-sm);
        }
        .dn-campaign-top { display: flex; align-items: center; gap: 0.85rem; margin-bottom: 1rem; }
        .dn-campaign-icon {
            width: 46px; height: 46px;
            background: var(--cl-red-glow);
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .dn-campaign-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.95rem; color: var(--cl-dark); }
        .dn-campaign-sub { font-size: 0.82rem; color: var(--cl-muted); }
        .dn-progress-wrap {
            width: 100%; height: 6px;
            background: var(--cl-light);
            border-radius: var(--radius-full);
            overflow: hidden;
        }
        .dn-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--cl-red), #FF6B6B);
            border-radius: var(--radius-full);
            transition: width 0.5s ease;
        }
        .dn-progress-stats {
            display: flex; justify-content: space-between;
            margin-top: 0.5rem;
        }
        .dn-progress-current { font-size: 0.82rem; font-weight: 700; color: var(--cl-dark); }
        .dn-progress-pct { font-size: 0.82rem; font-weight: 700; color: var(--cl-red); }
        .dn-progress-goal { font-size: 0.78rem; color: var(--cl-muted); }

        /* ─── Form patterns ─── */
        .fm-card {
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-card-border);
            border-radius: var(--radius-xl);
            padding: 1.75rem 1.5rem;
            box-shadow: var(--shadow-sm);
        }
        .fm-alert {
            display: flex; align-items: flex-start; gap: 0.75rem;
            padding: 0.85rem 1.1rem;
            background: var(--cl-red-glow);
            border: 1px solid rgba(230,57,70,0.15);
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
            font-size: 0.82rem; color: var(--cl-red);
            animation: fm-shake 0.4s ease;
        }
        .fm-alert svg { flex-shrink: 0; margin-top: 2px; }
        @keyframes fm-shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-4px); }
            40% { transform: translateX(4px); }
            60% { transform: translateX(-3px); }
            80% { transform: translateX(3px); }
        }
        .fm-section { margin-bottom: 1.75rem; }
        .fm-section-head {
            display: flex; align-items: center; gap: 0.75rem;
            margin-bottom: 1.15rem; padding-bottom: 0.85rem;
            border-bottom: 1px solid var(--cl-border);
        }
        .fm-section-icon {
            width: 36px; height: 36px;
            background: var(--cl-red-glow);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .fm-section-icon--muted { background: var(--cl-light); border: 1px solid var(--cl-border); }
        .fm-section-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.92rem; color: var(--cl-dark); }
        .fm-section-optional { font-weight: 400; font-size: 0.78rem; color: var(--cl-muted-light); margin-left: 0.4rem; }
        .fm-section-body { padding-left: 0.25rem; }
        .fm-group { margin-bottom: 1.1rem; }
        .fm-group:last-child { margin-bottom: 0; }
        .fm-label { display: block; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.8rem; color: var(--cl-body); margin-bottom: 0.4rem; }
        .fm-input {
            width: 100%; padding: 0.6rem 0.85rem;
            font-family: 'Inter', sans-serif; font-size: 0.85rem;
            color: var(--cl-dark); background: var(--cl-light);
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-md);
            outline: none !important; box-shadow: none !important;
            transition: all 0.25s ease;
        }
        .fm-input:focus { border-color: var(--cl-red) !important; box-shadow: 0 0 0 3px rgba(230,57,70,0.08) !important; background: var(--cl-card-bg); }
        .fm-input::placeholder { color: var(--cl-muted-light); }
        .fm-textarea { resize: vertical; min-height: 80px; }
        .fm-input--has-icon { padding-left: 2.5rem; }
        .fm-input--has-suffix { padding-right: 2.5rem; }
        .fm-input-icon-wrap { position: relative; }
        .fm-input-icon-wrap svg {
            position: absolute; left: 0.85rem; top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }
        .fm-input-icon-wrap:focus-within svg { stroke: #E63946 !important; }
        .fm-input-suffix-wrap { position: relative; }
        .fm-input-suffix {
            position: absolute; right: 0.85rem; top: 50%;
            transform: translateY(-50%);
            font-family: 'Inter', sans-serif; font-weight: 700;
            font-size: 0.82rem; color: var(--cl-muted);
            pointer-events: none;
        }
        .fm-select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 2.5rem;
            appearance: none; -webkit-appearance: none;
        }
        .fm-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .fm-actions {
            display: flex; justify-content: flex-end; gap: 0.75rem;
            padding-top: 1.25rem; border-top: 1px solid var(--cl-border);
        }
        .fm-btn {
            display: inline-flex; align-items: center; gap: 0.45rem;
            padding: 0.6rem 1.4rem;
            font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.84rem;
            border-radius: var(--radius-md);
            text-decoration: none; cursor: pointer;
            transition: all 0.25s ease;
            border: none !important; outline: none !important; box-shadow: none !important;
        }
        .fm-btn--red { background: var(--cl-red); color: #fff; box-shadow: 0 2px 8px rgba(230,57,70,0.2); }
        .fm-btn--red:hover { background: var(--cl-red-hover); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(230,57,70,0.28) !important; }
        .fm-btn--ghost { background: transparent; color: var(--cl-muted); border: 1.5px solid var(--cl-border) !important; }
        .fm-btn--ghost:hover { color: var(--cl-dark); border-color: var(--cl-muted) !important; background: var(--cl-light); }

        /* ─── Type cards ─── */
        .dn-type-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; }
        .dn-type-card {
            display: flex; flex-direction: column; align-items: center; gap: 0.6rem;
            padding: 1.25rem 0.75rem;
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-lg);
            cursor: pointer;
            background: var(--cl-card-bg);
            transition: all 0.25s ease;
            user-select: none;
        }
        .dn-type-card:hover {
            border-color: var(--cl-red);
            background: var(--cl-red-glow);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        .dn-type-radio { position: absolute; opacity: 0; width: 0; height: 0; }
        .dn-type-icon {
            width: 48px; height: 48px;
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            transition: all 0.25s ease;
        }
        .dn-type-icon--finance { background: rgba(230,57,70,0.08); color: #E63946; }
        .dn-type-icon--nature { background: rgba(45,198,83,0.08); color: #2DC653; }
        .dn-type-icon--skill { background: rgba(29,53,87,0.08); color: var(--cl-blue); }
        html.dark .dn-type-icon--skill { color: #93bbfd; }
        .dn-type-label { font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.82rem; color: var(--cl-dark); }

        .dn-type-card:has(input:checked) {
            border-color: var(--cl-red);
            background: var(--cl-red-glow);
            box-shadow: 0 0 0 3px rgba(230,57,70,0.1);
        }
        .dn-type-card:has(input:checked) .dn-type-icon--finance { background: var(--cl-red); color: #fff; }
        .dn-type-card:has(input:checked) .dn-type-icon--nature { background: var(--cl-green); color: #fff; }
        .dn-type-card:has(input:checked) .dn-type-icon--skill { background: var(--cl-blue); color: #fff; }

        /* ─── Sections dynamiques ─── */
        .dn-section {
            margin-bottom: 1.75rem;
            padding: 1.15rem;
            background: var(--cl-light);
            border: 1px solid var(--cl-border);
            border-radius: var(--radius-lg);
            animation: dn-fadeIn 0.25s ease;
        }
        @keyframes dn-fadeIn { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }

        .dn-info-note {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.65rem 0.9rem;
            border-radius: var(--radius-md);
            font-size: 0.8rem; font-weight: 500;
            margin-bottom: 1rem;
        }
        .dn-info-note svg { flex-shrink: 0; }
        .dn-info-note--green { background: var(--cl-green-soft); color: #1A8C38; border: 1px solid rgba(45,198,83,0.15); }
        .dn-info-note--blue { background: rgba(29,53,87,0.06); color: var(--cl-blue); border: 1px solid rgba(29,53,87,0.12); margin-bottom: 0; }

        /* ─── Amount chips ─── */
        .dn-amount-chips { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .dn-chip {
            padding: 0.45rem 1rem;
            font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.82rem;
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-full);
            background: var(--cl-card-bg);
            color: var(--cl-body);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .dn-chip:hover { border-color: var(--cl-red); color: var(--cl-red); background: var(--cl-red-glow); }
        .dn-chip--active {
            background: var(--cl-red) !important;
            color: #fff !important;
            border-color: var(--cl-red) !important;
        }

        /* ─── Anonymat ─── */
        .dn-anon-box {
            margin-bottom: 1.75rem;
            padding: 1rem 1.15rem;
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-lg);
            background: var(--cl-card-bg);
            transition: all 0.25s ease;
        }
        .dn-anon-box--active {
            border-color: rgba(107,114,128,0.5);
            background: var(--cl-light);
        }
        .dn-anon-label {
            display: flex; align-items: center; justify-content: space-between;
            cursor: pointer; margin: 0;
            gap: 1rem;
        }
        .dn-anon-left { display: flex; align-items: center; gap: 0.85rem; }
        .dn-anon-icon {
            width: 38px; height: 38px; flex-shrink: 0;
            background: var(--cl-light);
            border: 1px solid var(--cl-border);
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            color: var(--cl-muted);
            transition: all 0.25s ease;
        }
        .dn-anon-box--active .dn-anon-icon {
            background: rgba(107,114,128,0.12);
            border-color: rgba(107,114,128,0.3);
            color: var(--cl-body);
        }
        .dn-anon-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.88rem; color: var(--cl-dark); }
        .dn-anon-sub { font-size: 0.78rem; color: var(--cl-muted); margin-top: 0.1rem; }

        /* Toggle switch */
        .dn-toggle-wrap { position: relative; flex-shrink: 0; }
        .dn-toggle-input { position: absolute; opacity: 0; width: 0; height: 0; }
        .dn-toggle-track {
            display: block; width: 44px; height: 24px;
            background: var(--cl-border);
            border-radius: var(--radius-full);
            cursor: pointer;
            transition: background 0.25s ease;
            position: relative;
        }
        .dn-toggle-thumb {
            display: block; width: 18px; height: 18px;
            background: #fff;
            border-radius: 50%;
            position: absolute; top: 3px; left: 3px;
            transition: transform 0.25s ease;
            box-shadow: 0 1px 4px rgba(0,0,0,0.18);
        }
        .dn-toggle-input:checked + .dn-toggle-track { background: #6b7280; }
        .dn-toggle-input:checked + .dn-toggle-track .dn-toggle-thumb { transform: translateX(20px); }
        html.dark .dn-toggle-track { background: rgba(255,255,255,0.15); }
        html.dark .dn-toggle-input:checked + .dn-toggle-track { background: #9ca3af; }

        /* Anon preview */
        .dn-anon-preview {
            display: flex; align-items: center; gap: 0.4rem;
            margin-top: 0.85rem; padding-top: 0.75rem;
            border-top: 1px dashed var(--cl-border);
            font-size: 0.79rem; color: var(--cl-muted);
            animation: dn-fadeIn 0.2s ease;
        }
        .dn-anon-preview strong { color: var(--cl-body); }

        @media (max-width: 767.98px) {
            .fm-card { padding: 1.25rem 1.1rem; border-radius: var(--radius-lg); box-shadow: none; border: none; }
            .dn-campaign-card { border-radius: var(--radius-lg); box-shadow: none; border: none; }
            .dn-type-grid { grid-template-columns: 1fr; }
            .fm-row { grid-template-columns: 1fr; gap: 0; }
            .fm-actions { flex-direction: column-reverse; gap: 0.6rem; }
            .fm-btn { justify-content: center; width: 100%; }
            .dn-section { padding: 1rem; border-radius: var(--radius-md); }
            .dn-anon-box { padding: 0.9rem 1rem; }
        }
    </style>
</x-app-layout>
