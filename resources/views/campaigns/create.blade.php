<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label"><i class="bi bi-megaphone"></i> Nouvelle campagne</div>
            <h2 class="mb-0" style="font-size:1.5rem;">Publier une campagne</h2>
            <p class="header-sub mb-0">Créez une campagne pour votre association.</p>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="fm-card">

                <div class="fm-context">
                    <div class="fm-context-icon"><i class="bi bi-building"></i></div>
                    <div>
                        <div class="fm-context-label">Campagne pour</div>
                        <div class="fm-context-name">{{ $association->name }}</div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="fm-alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('campaigns.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Section 1 : Détails --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon"><i class="bi bi-megaphone"></i></div>
                            <span class="fm-section-title">Détails de la campagne</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-group">
                                <label class="fm-label">Titre de la campagne</label>
                                <input type="text" name="title" class="fm-input"
                                    value="{{ old('title') }}"
                                    placeholder="Ex: Distribution couffins Ramadan 2026" required>
                            </div>
                            <div class="fm-group">
                                <label class="fm-label">Nature / Type de campagne</label>
                                <input type="text" name="nature" class="fm-input"
                                    value="{{ old('nature') }}"
                                    placeholder="Ex: Couffins Ramadan, Distribution viande Aïd, Collecte vêtements..." required>
                                <small class="fm-hint">Décrivez librement le type de campagne (pas forcément monétaire)</small>
                            </div>
                            <div class="fm-group">
                                <label class="fm-label">Description</label>
                                <textarea name="description" class="fm-input fm-textarea" rows="4"
                                    placeholder="Décrivez l'objectif de votre campagne..." required>{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2 : Affiche --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon"><i class="bi bi-image"></i></div>
                            <span class="fm-section-title">Affiche de la campagne <span style="color:var(--cl-red)">*</span></span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-group">
                                <label class="fm-label">Affiche principale (obligatoire)</label>
                                <input type="file" name="affiche" class="fm-input fm-input-file" accept="image/*" required>
                                <small class="fm-hint">Image JPG/PNG, max 2Mo — sera affichée en couverture</small>
                            </div>
                            <div class="fm-group">
                                <label class="fm-label">Photos galerie <span class="fm-section-optional">optionnel</span></label>
                                <input type="file" name="photos[]" class="fm-input fm-input-file" accept="image/*" multiple>
                                <small class="fm-hint">Vous pouvez ajouter plusieurs photos (avant/pendant la campagne)</small>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3 : Objectif --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon"><i class="bi bi-bullseye"></i></div>
                            <span class="fm-section-title">Objectif et durée</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-group">
                                <label class="fm-label">Objectif financier <span class="fm-section-optional">optionnel — si collecte d'argent</span></label>
                                <div class="fm-input-suffix-wrap">
                                    <input type="number" name="goal_amount" class="fm-input fm-input--has-suffix"
                                        value="{{ old('goal_amount') }}"
                                        placeholder="Ex: 5000"
                                        min="0" step="0.01">
                                    <span class="fm-input-suffix">DT</span>
                                </div>
                            </div>
                            <div class="fm-group">
                                <label class="fm-label">Objectif en nature <span class="fm-section-optional">si pas monétaire</span></label>
                                <input type="text" name="objectif_description" class="fm-input"
                                    value="{{ old('objectif_description') }}"
                                    placeholder="Ex: 500 couffins, 200 familles aidées...">
                            </div>
                            <div class="fm-row">
                                <div class="fm-group">
                                    <label class="fm-label">Date de début <span class="fm-section-optional">optionnel</span></label>
                                    <div class="fm-input-icon-wrap">
                                        <i class="bi bi-calendar-check"></i>
                                        {{-- Après --}}
                                        <input type="date" name="date_debut" class="fm-input fm-input--has-icon"
                                            min="{{ date('Y-m-d') }}" max="2100-12-31"
                                            value="{{ old('date_debut', date('Y-m-d')) }}">
                                    </div>
                                </div>
                                <div class="fm-group">
                                    <label class="fm-label">Date limite <span class="fm-section-optional">optionnel</span></label>
                                    <div class="fm-input-icon-wrap">
                                        <i class="bi bi-calendar-event"></i>
                                        {{-- Après --}}
                                        <input type="date" name="deadline" class="fm-input fm-input--has-icon"
                                            min="{{ date('Y-m-d') }}" max="2100-12-31"
                                            value="{{ old('deadline') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="fm-actions">
                        <a href="{{ route('campaigns.index') }}" class="fm-btn fm-btn--ghost">Annuler</a>
                        <button type="submit" class="fm-btn fm-btn--red">
                            <i class="bi bi-rocket-takeoff"></i>
                            Publier la campagne
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .fm-context { display:flex; align-items:center; gap:0.85rem; padding:0.85rem 1rem; background:var(--cl-light); border:1px solid var(--cl-border); border-radius:var(--radius-md); margin-bottom:1.5rem; }
    .fm-context-icon { width:44px; height:44px; background:var(--cl-card-bg); border-radius:var(--radius-sm); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:var(--shadow-xs); }
    .fm-context-icon i { font-size:1.1rem; color:var(--cl-red); }
    .fm-context-label { font-size:0.75rem; color:var(--cl-muted); font-weight:500; }
    .fm-context-name { font-family:'Inter',sans-serif; font-weight:700; font-size:0.95rem; color:var(--cl-dark); }
    .fm-card { background:var(--cl-card-bg); border:1px solid var(--cl-card-border); border-radius:var(--radius-xl); padding:1.75rem 1.5rem; box-shadow:var(--shadow-sm); }
    .fm-alert { display:flex; align-items:flex-start; gap:0.75rem; padding:0.85rem 1.1rem; background:var(--cl-red-glow); border:1px solid rgba(230,57,70,0.15); border-radius:var(--radius-md); margin-bottom:1.5rem; font-size:0.82rem; color:var(--cl-red); }
    .fm-section { margin-bottom:1.75rem; }
    .fm-section-head { display:flex; align-items:center; gap:0.75rem; margin-bottom:1.15rem; padding-bottom:0.85rem; border-bottom:1px solid var(--cl-border); }
    .fm-section-icon { width:36px; height:36px; background:var(--cl-red-glow); border-radius:var(--radius-sm); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .fm-section-icon i { font-size:0.95rem; color:var(--cl-red); }
    .fm-section-title { font-family:'Inter',sans-serif; font-weight:700; font-size:0.92rem; color:var(--cl-dark); }
    .fm-section-optional { font-weight:400; font-size:0.78rem; color:var(--cl-muted-light); margin-left:0.4rem; }
    .fm-section-body { padding-left:0.25rem; }
    .fm-group { margin-bottom:1.1rem; }
    .fm-group:last-child { margin-bottom:0; }
    .fm-label { display:block; font-family:'Inter',sans-serif; font-weight:600; font-size:0.8rem; color:var(--cl-body); margin-bottom:0.4rem; }
    .fm-hint { display:block; font-size:0.75rem; color:var(--cl-muted); margin-top:0.3rem; }
    .fm-input { width:100%; padding:0.6rem 0.85rem; font-family:'Inter',sans-serif; font-size:0.85rem; color:var(--cl-dark); background:var(--cl-light); border:1.5px solid var(--cl-border); border-radius:var(--radius-md); outline:none !important; box-shadow:none !important; transition:all 0.25s ease; }
    .fm-input:focus { border-color:var(--cl-red) !important; box-shadow:0 0 0 3px rgba(230,57,70,0.08) !important; background:var(--cl-card-bg); }
    .fm-input::placeholder { color:var(--cl-muted-light); }
    .fm-textarea { resize:vertical; min-height:100px; }
    .fm-input-file { padding:0.5rem 0.85rem; cursor:pointer; }
    .fm-input--has-icon { padding-left:2.5rem; }
    .fm-input--has-suffix { padding-right:2.5rem; }
    .fm-input-icon-wrap { position:relative; }
    .fm-input-icon-wrap i { position:absolute; left:0.85rem; top:50%; transform:translateY(-50%); font-size:0.9rem; color:var(--cl-muted); pointer-events:none; }
    .fm-input-suffix-wrap { position:relative; }
    .fm-input-suffix { position:absolute; right:0.85rem; top:50%; transform:translateY(-50%); font-family:'Inter',sans-serif; font-weight:700; font-size:0.82rem; color:var(--cl-dark); pointer-events:none; }
    .fm-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .fm-actions { display:flex; justify-content:flex-end; gap:0.75rem; padding-top:1.25rem; border-top:1px solid var(--cl-border); }
    .fm-btn { display:inline-flex; align-items:center; gap:0.45rem; padding:0.6rem 1.4rem; font-family:'Inter',sans-serif; font-weight:600; font-size:0.84rem; border-radius:var(--radius-md); text-decoration:none; cursor:pointer; transition:all 0.25s ease; border:none !important; outline:none !important; }
    .fm-btn--red { background:var(--cl-red); color:#fff; box-shadow:0 2px 8px rgba(230,57,70,0.2); }
    .fm-btn--red:hover { background:var(--cl-red-hover); color:#fff; transform:translateY(-1px); }
    .fm-btn--ghost { background:transparent; color:var(--cl-muted); border:1.5px solid var(--cl-border) !important; }
    .fm-btn--ghost:hover { color:var(--cl-dark); border-color:var(--cl-muted) !important; background:var(--cl-light); }
    @media (max-width:767.98px) { .fm-card { padding:1.25rem 1.1rem; border-radius:var(--radius-lg); box-shadow:none; border:none; } .fm-row { grid-template-columns:1fr; gap:0; } .fm-actions { flex-direction:column-reverse; } .fm-btn { justify-content:center; width:100%; } }
</style>
