<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label"><i class="bi bi-building-add"></i> Nouvelle association</div>
            <h2 class="mb-0" style="font-size:1.5rem;">Créer mon profil association</h2>
            <p class="header-sub mb-0">Remplissez les informations ci-dessous pour soumettre votre association.</p>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="fm-card">

                @if($errors->any())
                    <div class="fm-alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('associations.store') }}">
                    @csrf

                    {{-- Section 1 : Infos générales --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon">
                                <i class="bi bi-building-add"></i>
                            </div>
                            <span class="fm-section-title">Informations générales</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-group">
                                <label class="fm-label">Nom de l'association</label>
                                <input type="text" name="name" class="fm-input"
                                    value="{{ old('name') }}" placeholder="Ex: SOS Enfants Tunisie" required>
                            </div>
                            <div class="fm-group">
                                <label class="fm-label">Description</label>
                                <textarea name="description" class="fm-input fm-textarea" rows="4"
                                    placeholder="Décrivez la mission et les actions de votre association..." required>{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2 : Localisation --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <span class="fm-section-title">Localisation et catégorie</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-row">
                                <div class="fm-group">
                                    <label class="fm-label">Catégorie</label>
                                    <select name="category" class="fm-select">
                                        @foreach(['enfants','education','sante','alimentation','environnement','autre'] as $cat)
                                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                                                {{ ucfirst($cat) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="fm-group">
                                    <label class="fm-label">Région</label>
                                    <select name="region" class="fm-select">
                                        @foreach(['Tunis','Sfax','Sousse','Kairouan','Bizerte','Gabès','Ariana','Gafsa','Monastir','Ben Arous','Kasserine','Médenine','Nabeul','Tataouine','Béja','Jendouba','Zaghouan','Siliana','Kef','Mahdia','Sidi Bouzid','Tozeur','Kébili','Manouba'] as $reg)
                                            <option value="{{ $reg }}" {{ old('region') == $reg ? 'selected' : '' }}>
                                                {{ $reg }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3 : Réseaux --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon fm-section-icon--muted">
                                <i class="bi bi-link-45deg"></i>
                            </div>
                            <span class="fm-section-title">Réseaux et contact <span class="fm-section-optional">optionnel</span></span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-row">
                                <div class="fm-group">
                                    <label class="fm-label">Site web</label>
                                    <div class="fm-input-icon-wrap">
                                        <i class="bi bi-globe"></i>
                                        <input type="url" name="website" class="fm-input fm-input--has-icon"
                                            value="{{ old('website') }}" placeholder="<https://monsite.tn>">
                                    </div>
                                </div>
                                <div class="fm-group">
                                    <label class="fm-label">Facebook</label>
                                    <div class="fm-input-icon-wrap">
                                        <i class="bi bi-facebook"></i>
                                        <input type="url" name="facebook" class="fm-input fm-input--has-icon"
                                            value="{{ old('facebook') }}" placeholder="<https://facebook.com/>...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="fm-actions">
                        <a href="{{ route('associations.index') }}" class="fm-btn fm-btn--ghost">
                            Annuler
                        </a>
                        <button type="submit" class="fm-btn fm-btn--red">
                            <i class="bi bi-send"></i>
                            Soumettre pour validation
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    /* ════════════════ FORM CARD ════════════════ */
    .fm-card {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl);
        padding: 1.75rem 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.35s ease;
    }

    /* ════════════════ ALERT ════════════════ */
    .fm-alert {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.85rem 1.1rem;
        background: var(--cl-red-glow);
        border: 1px solid rgba(230,57,70,0.15);
        border-radius: var(--radius-md);
        margin-bottom: 1.5rem;
        font-size: 0.82rem;
        color: var(--cl-red);
        font-family: 'Inter', sans-serif;
        animation: fm-shake 0.4s ease;
    }
    .fm-alert i {
        font-size: 1rem;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .fm-alert div div { margin-bottom: 0.15rem; }
    .fm-alert div div:last-child { margin-bottom: 0; }
    @keyframes fm-shake {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-4px); }
        40% { transform: translateX(4px); }
        60% { transform: translateX(-3px); }
        80% { transform: translateX(3px); }
    }

    /* ════════════════ SECTION ════════════════ */
    .fm-section {
        margin-bottom: 1.75rem;
    }
    .fm-section:last-of-type {
        margin-bottom: 1.5rem;
    }
    .fm-section-head {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.15rem;
        padding-bottom: 0.85rem;
        border-bottom: 1px solid var(--cl-border);
        transition: border-color 0.35s ease;
    }
    .fm-section-icon {
        width: 36px; height: 36px;
        background: var(--cl-red-glow);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: background 0.35s ease;
    }
    .fm-section-icon i { font-size: 0.95rem; color: var(--cl-red); }
    .fm-section-icon--muted {
        background: var(--cl-light);
        border: 1px solid var(--cl-border);
    }
    .fm-section-icon--muted i { color: var(--cl-muted); }
    .fm-section-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--cl-dark);
        transition: color 0.35s ease;
    }
    .fm-section-optional {
        font-weight: 400;
        font-size: 0.78rem;
        color: var(--cl-muted-light);
        margin-left: 0.4rem;
        transition: color 0.35s ease;
    }
    .fm-section-body {
        padding-left: 0.25rem;
    }

    /* ════════════════ GROUP ════════════════ */
    .fm-group {
        margin-bottom: 1.1rem;
    }
    .fm-group:last-child {
        margin-bottom: 0;
    }

    /* ════════════════ LABEL ════════════════ */
    .fm-label {
        display: block;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--cl-body);
        margin-bottom: 0.4rem;
        transition: color 0.35s ease;
    }

    /* ════════════════ INPUT ════════════════ */
    .fm-input {
        width: 100%;
        padding: 0.6rem 0.85rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: var(--cl-dark);
        background: var(--cl-light);
        border: 1.5px solid var(--cl-border);
        border-radius: var(--radius-md);
        outline: none !important;
        box-shadow: none !important;
        transition: all 0.25s ease;
    }
    .fm-input:focus {
        border-color: var(--cl-red) !important;
        box-shadow: 0 0 0 3px rgba(230,57,70,0.08) !important;
        background: var(--cl-card-bg);
    }
    .fm-input::placeholder {
        color: var(--cl-muted-light);
    }
    .fm-textarea {
        resize: vertical;
        min-height: 100px;
    }
    .fm-input--has-icon {
        padding-left: 2.5rem;
    }

    /* ════════════════ INPUT WITH ICON ════════════════ */
    .fm-input-icon-wrap {
        position: relative;
    }
    .fm-input-icon-wrap i {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.9rem;
        color: var(--cl-muted);
        pointer-events: none;
        transition: color 0.25s ease;
    }
    .fm-input-icon-wrap .fm-input:focus ~ i,
    .fm-input-icon-wrap:focus-within i {
        color: var(--cl-red);
    }

    /* ════════════════ SELECT ════════════════ */
    .fm-select {
        width: 100%;
        padding: 0.6rem 2.2rem 0.6rem 0.85rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: var(--cl-dark);
        background: var(--cl-light) url("data:image/svg+xml,%3Csvg xmlns='<http://www.w3.org/2000/svg>' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 0.85rem center;
        border: 1.5px solid var(--cl-border);
        border-radius: var(--radius-md);
        outline: none !important;
        box-shadow: none !important;
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .fm-select:focus {
        border-color: var(--cl-red) !important;
        box-shadow: 0 0 0 3px rgba(230,57,70,0.08) !important;
        background-color: var(--cl-card-bg);
    }
    html.dark .fm-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='<http://www.w3.org/2000/svg>' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    }

    /* ════════════════ ROW ════════════════ */
    .fm-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    /* ════════════════ ACTIONS ════════════════ */
    .fm-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--cl-border);
        transition: border-color 0.35s ease;
    }

    /* ════════════════ BUTTONS ════════════════ */
    .fm-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.6rem 1.4rem;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.84rem;
        border-radius: var(--radius-md);
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s ease;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }
    .fm-btn:focus {
        outline: none !important;
        box-shadow: none !important;
    }
    .fm-btn i { font-size: 0.88rem; }
    .fm-btn--red {
        background: var(--cl-red);
        color: #fff;
        box-shadow: 0 2px 8px rgba(230,57,70,0.2);
    }
    .fm-btn--red:hover {
        background: var(--cl-red-hover);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(230,57,70,0.28) !important;
    }
    .fm-btn--ghost {
        background: transparent;
        color: var(--cl-muted);
        border: 1.5px solid var(--cl-border) !important;
    }
    .fm-btn--ghost:hover {
        color: var(--cl-dark);
        border-color: var(--cl-muted) !important;
        background: var(--cl-light);
    }

    /* ════════════════ RESPONSIVE ════════════════ */
    @media (max-width: 767.98px) {
        .fm-card {
            padding: 1.25rem 1.1rem;
            border-radius: var(--radius-lg);
            box-shadow: none;
            border: none;
        }
        .fm-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
        .fm-actions {
            flex-direction: column-reverse;
            gap: 0.6rem;
        }
        .fm-btn {
            justify-content: center;
            width: 100%;
            padding: 0.7rem;
        }
    }
    @media (max-width: 575.98px) {
        .fm-card {
            padding: 1rem 0.85rem;
        }
    }
</style>
