<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
                Nouvelle tâche
            </div>
            <h2 class="mb-0" style="font-size:1.5rem;">Créer une tâche bénévole</h2>
            <p class="header-sub mb-0">Définissez une mission et trouvez des bénévoles.</p>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="fm-card">

                <div class="fm-context">
                    <div class="fm-context-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#E63946" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
                    </div>
                    <div>
                        <div class="fm-context-label">Tâche pour</div>
                        <div class="fm-context-name">{{ $association->name }}</div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="fm-alert">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#E63946" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('taches.store') }}">
                    @csrf

                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#E63946" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
                            </div>
                            <span class="fm-section-title">Détails de la mission</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-group">
                                <label class="fm-label">Titre de la tâche</label>
                                <input type="text" name="title" class="fm-input"
                                    value="{{ old('title') }}"
                                    placeholder="Ex: Cours de soutien scolaire" required>
                            </div>
                            <div class="fm-group">
                                <label class="fm-label">Description</label>
                                <textarea name="description" class="fm-input fm-textarea" rows="4"
                                    placeholder="Décrivez la tâche, le contexte et les attendus..." required>{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#E63946" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
                            </div>
                            <span class="fm-section-title">Exigences et durée</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-row">
                                <div class="fm-group">
                                    <label class="fm-label">Compétence requise</label>
                                    <div class="fm-input-icon-wrap">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                        <input type="text" name="competence_requise" class="fm-input fm-input--has-icon"
                                            value="{{ old('competence_requise') }}"
                                            placeholder="Ex: Professeur, Médecin..." required>
                                    </div>
                                </div>
                                <div class="fm-group">
                                    <label class="fm-label">Date limite <span class="fm-section-optional">optionnel</span></label>
                                    <div class="fm-input-icon-wrap">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        <input type="date" name="deadline" class="fm-input fm-input--has-icon"
                                            value="{{ old('deadline') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fm-actions">
                        <a href="{{ route('taches.index') }}" class="fm-btn fm-btn--ghost">
                            Annuler
                        </a>
                        <button type="submit" class="fm-btn fm-btn--red">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Créer la tâche
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .fm-context {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.85rem 1rem;
        background: var(--cl-light);
        border: 1px solid var(--cl-border);
        border-radius: var(--radius-md);
        margin-bottom: 1.5rem;
    }
    .fm-context-icon {
        width: 44px; height: 44px;
        background: var(--cl-card-bg);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: var(--shadow-xs);
    }
    .fm-context-label { font-size: 0.75rem; color: var(--cl-muted); font-weight: 500; }
    .fm-context-name { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.95rem; color: var(--cl-dark); }

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
    .fm-section:last-of-type { margin-bottom: 1.5rem; }
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
    .fm-textarea { resize: vertical; min-height: 100px; }
    .fm-input--has-icon { padding-left: 2.5rem; }

    .fm-input-icon-wrap { position: relative; }
    .fm-input-icon-wrap svg {
        position: absolute; left: 0.85rem; top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }
    .fm-input-icon-wrap:focus-within svg { stroke: #E63946 !important; }

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
    .fm-btn svg { flex-shrink: 0; }
    .fm-btn--red { background: var(--cl-red); color: #fff; box-shadow: 0 2px 8px rgba(230,57,70,0.2); }
    .fm-btn--red:hover { background: var(--cl-red-hover); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(230,57,70,0.28) !important; }
    .fm-btn--ghost { background: transparent; color: var(--cl-muted); border: 1.5px solid var(--cl-border) !important; }
    .fm-btn--ghost:hover { color: var(--cl-dark); border-color: var(--cl-muted) !important; background: var(--cl-light); }

    @media (max-width: 767.98px) {
        .fm-card { padding: 1.25rem 1.1rem; border-radius: var(--radius-lg); box-shadow: none; border: none; }
        .fm-row { grid-template-columns: 1fr; gap: 0; }
        .fm-actions { flex-direction: column-reverse; gap: 0.6rem; }
        .fm-btn { justify-content: center; width: 100%; padding: 0.7rem; }
    }
</style>
