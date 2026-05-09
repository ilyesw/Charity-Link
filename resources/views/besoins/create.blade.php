<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                {{ __('Demande d\'aide') }}
            </div>
            <h2 class="mb-0" style="font-size:1.5rem;">{{ __('Besoin d\'aide') }}</h2>
            <p class="header-sub mb-0">{{ __('Décrivez votre situation — nous relayons aux associations partenaires') }}</p>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">

                <div class="cl-split-card">
                    <div class="row g-0">

                        {{-- Panneau gauche --}}
                        <div class="col-md-5 cl-split-left d-flex flex-column justify-content-center p-4 p-md-5 position-relative overflow-hidden">
                            <div class="position-relative" style="z-index: 2;">

                                <div class="cl-split-badge mb-4">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="13 17 18 12 13 7"/><polyline points="6 17 11 12 6 7"/></svg>
                                    <span>{{ __('Formulaire rapide') }}</span>
                                </div>

                                <h3 class="cl-split-title mb-3">
                                    {{ __('Nous sommes là') }}<br>{{ __('pour vous.') }}
                                </h3>

                                <p class="cl-split-text mb-4">
                                    {{ __('Exprimez votre besoin en quelques secondes. Votre demande est transmise automatiquement aux associations les plus proches de chez vous.') }}
                                </p>

                                <div class="cl-split-stats">
                                    <div class="cl-split-stat">
                                        <div class="cl-split-stat-num">24h</div>
                                        <div class="cl-split-stat-label">{{ __('Délai moyen') }}</div>
                                    </div>
                                    <div class="cl-split-stat-sep"></div>
                                    <div class="cl-split-stat">
                                        <div class="cl-split-stat-num">100%</div>
                                        <div class="cl-split-stat-label">{{ __('Gratuit') }}</div>
                                    </div>
                                    <div class="cl-split-stat-sep"></div>
                                    <div class="cl-split-stat">
                                        <div class="cl-split-stat-icon">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                        </div>
                                        <div class="cl-split-stat-label">{{ __('Confidentiel') }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="cl-split-orb cl-split-orb-1"></div>
                            <div class="cl-split-orb cl-split-orb-2"></div>
                            <div class="cl-split-grid-lines"></div>
                        </div>

                        {{-- Panneau droit — Formulaire --}}
                        <div class="col-md-7 cl-split-right p-4 p-md-5">

                            <div class="section-label mb-4">{{ __('Votre demande') }}</div>

                            @if ($errors->any())
                                <div class="cl-alert-error mb-4">
                                    <div class="d-flex align-items-start gap-2">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                        <div>
                                            @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- ✅ FEATURE 1 : Info validation --}}
                            <div class="cl-info-box mb-4">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ __('Votre demande sera visible après validation par notre équipe.') }}
                            </div>

                            {{-- ✅ enctype multipart pour l'upload --}}
                            <form action="{{ route('besoins.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                                @csrf

                                {{-- Nom + Email --}}
                                <div class="row g-3 mb-2">
                                    <div class="col-md-6">
                                        <label for="nom" class="cl-label">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                            {{ __('Nom complet') }}
                                        </label>
                                        <input type="text" name="nom" id="nom"
                                               class="cl-input @error('nom') cl-input-error @enderror"
                                               placeholder="Mohamed Ali" required
                                               value="{{ old('nom') }}">
                                    </div>
                                    <div class="col-md-6">
                                        {{-- ✅ Email OPTIONNEL --}}
                                        <label for="email" class="cl-label">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                            {{ __('Email') }}
                                            <span style="color:var(--cl-muted);font-weight:400;">({{ __('optionnel') }})</span>
                                        </label>
                                        <input type="email" name="email" id="email"
                                               class="cl-input @error('email') cl-input-error @enderror"
                                               placeholder="exemple@email.com"
                                               value="{{ old('email') }}">
                                    </div>
                                </div>

                                {{-- ✅ Téléphone OBLIGATOIRE --}}
                                <div class="mb-2">
                                    <label for="phone" class="cl-label">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                        {{ __('Téléphone') }}
                                    </label>
                                    <input type="text" name="phone" id="phone"
                                           class="cl-input @error('phone') cl-input-error @enderror"
                                           placeholder="55 123 456" required
                                           value="{{ old('phone') }}">
                                </div>

                                {{-- ✅ FEATURE 2 : Toggle Anonyme --}}
                                <div class="cl-anon-toggle mb-2">
                                    <label class="cl-anon-label" for="is_anonymous">
                                        <div class="cl-anon-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><line x1="23" y1="1" x2="1" y2="23"/></svg>
                                        </div>
                                        <div class="cl-anon-text">
                                            <span class="cl-anon-title">{{ __('Rester anonyme') }}</span>
                                            <span class="cl-anon-sub">{{ __('Votre nom ne sera pas affiché publiquement') }}</span>
                                        </div>
                                        <div class="cl-toggle-wrap">
                                            <input type="checkbox" name="is_anonymous" id="is_anonymous"
                                                   value="1" {{ old('is_anonymous') ? 'checked' : '' }}
                                                   class="cl-toggle-input">
                                            <span class="cl-toggle-slider"></span>
                                        </div>
                                    </label>
                                </div>

                                <div class="cl-sep"></div>

                                {{-- Région + Catégorie --}}
                                <div class="row g-3 mb-2">
                                    <div class="col-md-6">
                                        <label for="region" class="cl-label">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                            {{ __('Région') }}
                                        </label>
                                        <select name="region" id="region" class="cl-input cl-select @error('region') cl-input-error @enderror" required>
                                            <option value="" disabled selected>{{ __('Choisir...') }}</option>
                                            @foreach(['Tunis','Ariana','Ben Arous','Manouba','Nabeul','Zaghouan','Bizerte','Béja','Jendouba','Le Kef','Siliana','Sousse','Monastir','Mahdia','Sfax','Kairouan','Kasserine','Sidi Bouzid','Gabès','Medenine','Tataouine','Gafsa','Tozeur','Kebili'] as $reg)
                                                <option value="{{ $reg }}" {{ old('region') == $reg ? 'selected' : '' }}>{{ $reg }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="categorie" class="cl-label">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                                            {{ __('Type de besoin') }}
                                        </label>
                                        <select name="categorie" id="categorie" class="cl-input cl-select @error('categorie') cl-input-error @enderror" required>
                                            <option value="" disabled selected>{{ __('Choisir...') }}</option>
                                            <option value="alimentation" {{ old('categorie') == 'alimentation' ? 'selected' : '' }}>{{ __('Alimentaire') }}</option>
                                            <option value="sante"        {{ old('categorie') == 'sante'        ? 'selected' : '' }}>{{ __('Médical / Santé') }}</option>
                                            <option value="education"    {{ old('categorie') == 'education'    ? 'selected' : '' }}>{{ __('Éducation') }}</option>
                                            <option value="logement"     {{ old('categorie') == 'logement'     ? 'selected' : '' }}>{{ __('Hébergement') }}</option>
                                            <option value="autre"        {{ old('categorie') == 'autre'        ? 'selected' : '' }}>{{ __('Autre') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="cl-sep"></div>

                                {{-- Description --}}
                                <div class="mb-2">
                                    <label for="description" class="cl-label">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
                                        {{ __('Détails de votre besoin') }}
                                    </label>
                                    <textarea name="description" id="description" rows="4"
                                              class="cl-input cl-textarea @error('description') cl-input-error @enderror"
                                              placeholder="{{ __('Expliquez brièvement votre situation...') }}"
                                              required>{{ old('description') }}</textarea>
                                </div>

                                {{-- ✅ FEATURE 3 : Pièce jointe OBLIGATOIRE --}}
                                <div class="mb-2">
                                    <label for="attachment" class="cl-label">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                        {{ __('Pièce jointe') }}
                                    </label>
                                    <div class="cl-file-zone" id="fileZone">
                                        <input type="file" name="attachment" id="attachment"
                                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                               class="cl-file-input @error('attachment') cl-input-error @enderror"
                                               onchange="updateFileName(this)" required>
                                        <div class="cl-file-content" id="fileContent">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                            <span class="cl-file-text">{{ __('Cliquez ou glissez un fichier ici') }}</span>
                                            <span class="cl-file-hint">JPG, PNG, PDF, DOC — max 5 Mo</span>
                                        </div>
                                    </div>
                                    <div id="filePreview" class="cl-file-preview d-none">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        <span id="fileName"></span>
                                        <button type="button" onclick="clearFile()" class="cl-file-clear">✕</button>
                                    </div>
                                </div>

                                <div class="cl-sep"></div>

                                {{-- Urgence --}}
                                <div class="mb-2">
                                    <label class="cl-label">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        {{ __('Niveau d\'urgence') }}
                                    </label>
                                    <div class="cl-urgence-grid">
                                        <label class="cl-urgence-card cl-normale">
                                            <input type="radio" name="urgence" value="normale" {{ old('urgence', 'normale') == 'normale' ? 'checked' : '' }}>
                                            <span class="cl-urgence-dot"></span>
                                            <span class="cl-urgence-title">{{ __('Normale') }}</span>
                                            <span class="cl-urgence-sub">{{ __('Quelques jours') }}</span>
                                        </label>
                                        <label class="cl-urgence-card cl-urgente">
                                            <input type="radio" name="urgence" value="urgente" {{ old('urgence') == 'urgente' ? 'checked' : '' }}>
                                            <span class="cl-urgence-dot"></span>
                                            <span class="cl-urgence-title">{{ __('Urgente') }}</span>
                                            <span class="cl-urgence-sub">{{ __('Sous 24h') }}</span>
                                        </label>
                                        <label class="cl-urgence-card cl-critique">
                                            <input type="radio" name="urgence" value="critique" {{ old('urgence') == 'critique' ? 'checked' : '' }}>
                                            <span class="cl-urgence-dot"></span>
                                            <span class="cl-urgence-title">{{ __('Critique') }}</span>
                                            <span class="cl-urgence-sub">{{ __('Immédiat') }}</span>
                                        </label>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="mt-4">
                                    <button type="submit" class="cl-btn-submit">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                        {{ __('Envoyer ma demande') }}
                                    </button>
                                    <p class="cl-confidence-note">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                        {{ __('Vos informations sont traitées en toute confidentialité') }}
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .cl-split-card { border-radius: var(--radius-xl); overflow: hidden; border: 1px solid var(--cl-card-border); box-shadow: var(--shadow-lg); background: var(--cl-card-bg); }
        .cl-split-left { background: var(--cl-blue); color: #fff; min-height: 520px; }
        html.dark .cl-split-left { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); }
        .cl-split-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.12); border-radius: var(--radius-sm); font-size: 0.72rem; font-weight: 600; color: rgba(255,255,255,0.85); backdrop-filter: blur(8px); }
        .cl-split-title { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.6rem; line-height: 1.25; color: #fff; }
        .cl-split-text { font-size: 0.85rem; line-height: 1.65; color: rgba(255,255,255,0.6); max-width: 280px; }
        .cl-split-stats { display: flex; align-items: center; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.08); border-radius: var(--radius-md); padding: 12px 0; backdrop-filter: blur(8px); }
        .cl-split-stat { flex: 1; text-align: center; padding: 0 8px; }
        .cl-split-stat-num { font-size: 0.95rem; font-weight: 700; color: #fff; }
        .cl-split-stat-icon { display: flex; align-items: center; justify-content: center; margin-bottom: 2px; }
        .cl-split-stat-icon svg { color: rgba(255,255,255,0.8); }
        .cl-split-stat-label { font-size: 0.65rem; color: rgba(255,255,255,0.5); font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; }
        .cl-split-stat-sep { width: 1px; height: 28px; background: rgba(255,255,255,0.1); flex-shrink: 0; }
        .cl-split-orb { position: absolute; border-radius: 50%; pointer-events: none; }
        .cl-split-orb-1 { width: 180px; height: 180px; background: radial-gradient(circle, rgba(230,57,70,0.25) 0%, transparent 70%); top: -30px; right: -40px; }
        .cl-split-orb-2 { width: 120px; height: 120px; background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%); bottom: 40px; left: -30px; }
        .cl-split-grid-lines { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 40px 40px; pointer-events: none; z-index: 1; }
        .cl-split-right { background: var(--cl-card-bg); padding-top: 2rem !important; padding-bottom: 2rem !important; }
        .cl-label { display: inline-flex; align-items: center; gap: 5px; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.8rem; color: var(--cl-dark); margin-bottom: 0.4rem; }
        .cl-label svg { color: var(--cl-muted); flex-shrink: 0; }
        .cl-input { border: 1.5px solid var(--cl-border); border-radius: var(--radius-md); padding: 0.62rem 0.95rem; font-family: 'Inter', sans-serif; font-size: 0.88rem; color: var(--cl-dark); background: var(--cl-light); transition: all 0.25s ease; width: 100%; }
        .cl-input:focus { outline: none; border-color: var(--cl-red); box-shadow: 0 0 0 3px rgba(230,57,70,0.08); background: var(--cl-card-bg); }
        .cl-input::placeholder { color: var(--cl-muted-light); }
        .cl-textarea { resize: vertical; min-height: 105px; }
        .cl-input-error { border-color: var(--cl-red) !important; }
        .cl-select { cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 2.5rem; appearance: none; }
        .cl-sep { height: 1px; background: var(--cl-border); margin: 1.15rem 0; }

        /* ✅ Info box validation */
        .cl-info-box {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.7rem 1rem;
            background: rgba(59,130,246,0.07);
            border: 1px solid rgba(59,130,246,0.15);
            border-radius: var(--radius-md);
            font-size: 0.8rem; color: var(--cl-blue);
            font-weight: 500;
        }
        html.dark .cl-info-box { background: rgba(59,130,246,0.1); }

        /* ✅ Toggle anonyme */
        .cl-anon-toggle {
            background: var(--cl-light);
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-md);
            transition: border-color 0.2s ease, background 0.2s ease;
        }
        .cl-anon-toggle:has(input:checked) {
            border-color: var(--cl-blue);
            background: rgba(59,130,246,0.04);
        }
        .cl-anon-label {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.75rem 1rem;
            cursor: pointer; margin: 0;
        }
        .cl-anon-icon {
            width: 36px; height: 36px; flex-shrink: 0;
            background: var(--cl-card-bg);
            border: 1px solid var(--cl-border);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
        }
        .cl-anon-icon svg { color: var(--cl-muted); }
        .cl-anon-text { flex: 1; }
        .cl-anon-title { display: block; font-size: 0.82rem; font-weight: 600; color: var(--cl-dark); }
        .cl-anon-sub { display: block; font-size: 0.72rem; color: var(--cl-muted); }
        /* Toggle switch */
        .cl-toggle-wrap { position: relative; flex-shrink: 0; }
        .cl-toggle-input { position: absolute; opacity: 0; width: 0; height: 0; }
        .cl-toggle-slider {
            display: block; width: 40px; height: 22px;
            background: var(--cl-border);
            border-radius: 11px;
            transition: background 0.25s ease;
            position: relative; cursor: pointer;
        }
        .cl-toggle-slider::after {
            content: '';
            position: absolute;
            top: 3px; left: 3px;
            width: 16px; height: 16px;
            background: #fff;
            border-radius: 50%;
            transition: transform 0.25s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .cl-toggle-input:checked ~ .cl-toggle-slider { background: var(--cl-blue); }
        .cl-toggle-input:checked ~ .cl-toggle-slider::after { transform: translateX(18px); }

        /* ✅ Zone upload */
        .cl-file-zone {
            position: relative;
            border: 2px dashed var(--cl-border);
            border-radius: var(--radius-md);
            background: var(--cl-light);
            transition: all 0.25s ease;
            cursor: pointer;
            overflow: hidden;
        }
        .cl-file-zone:hover { border-color: var(--cl-red); background: var(--cl-card-bg); }
        .cl-file-input {
            position: absolute; inset: 0;
            opacity: 0; cursor: pointer; width: 100%; height: 100%;
        }
        .cl-file-content {
            display: flex; flex-direction: column; align-items: center;
            padding: 1.25rem 1rem; gap: 0.35rem;
            pointer-events: none;
        }
        .cl-file-text { font-size: 0.82rem; font-weight: 600; color: var(--cl-dark); }
        .cl-file-hint { font-size: 0.72rem; color: var(--cl-muted); }
        .cl-file-preview {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            background: var(--cl-green-soft);
            border: 1px solid rgba(45,198,83,0.2);
            border-radius: var(--radius-sm);
            margin-top: 0.5rem;
            font-size: 0.8rem; color: #1A8C38; font-weight: 500;
        }
        .cl-file-clear {
            margin-left: auto; background: none; border: none;
            color: #1A8C38; cursor: pointer; font-size: 0.85rem;
            padding: 0 4px;
        }

        /* Urgence */
        .cl-urgence-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .cl-urgence-card { position: relative; border: 1.5px solid var(--cl-border); border-radius: var(--radius-md); padding: 1rem 0.65rem; text-align: center; cursor: pointer; background: var(--cl-card-bg); transition: all 0.22s ease; user-select: none; }
        .cl-urgence-card:hover { border-color: var(--cl-muted); }
        .cl-urgence-card input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
        .cl-urgence-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-bottom: 0.4rem; transition: transform 0.22s ease; }
        .cl-urgence-title { display: block; font-size: 0.78rem; font-weight: 600; color: var(--cl-dark); }
        .cl-urgence-sub { display: block; font-size: 0.66rem; color: var(--cl-muted); margin-top: 0.12rem; }
        .cl-urgence-card.cl-normale .cl-urgence-dot { background: #22C55E; }
        .cl-urgence-card.cl-normale:has(input:checked) { border-color: #22C55E; background: rgba(34,197,94,0.06); box-shadow: 0 0 0 3px rgba(34,197,94,0.1); }
        .cl-urgence-card.cl-normale:has(input:checked) .cl-urgence-dot { transform: scale(1.4); }
        .cl-urgence-card.cl-urgente .cl-urgence-dot { background: #F59E0B; }
        .cl-urgence-card.cl-urgente:has(input:checked) { border-color: #F59E0B; background: rgba(245,158,11,0.06); box-shadow: 0 0 0 3px rgba(245,158,11,0.1); }
        .cl-urgence-card.cl-urgente:has(input:checked) .cl-urgence-dot { transform: scale(1.4); }
        .cl-urgence-card.cl-critique .cl-urgence-dot { background: var(--cl-red); }
        .cl-urgence-card.cl-critique:has(input:checked) { border-color: var(--cl-red); background: var(--cl-red-glow); box-shadow: 0 0 0 3px rgba(230,57,70,0.1); }
        .cl-urgence-card.cl-critique:has(input:checked) .cl-urgence-dot { transform: scale(1.4); }

        /* Submit */
        .cl-btn-submit { display: flex; align-items: center; justify-content: center; gap: 9px; width: 100%; padding: 0.82rem 1.5rem; background: var(--cl-red); color: #fff; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.9rem; border: none; border-radius: var(--radius-md); cursor: pointer; transition: all 0.25s ease; box-shadow: 0 2px 10px rgba(230,57,70,0.2); }
        .cl-btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(230,57,70,0.3); background: var(--cl-red-hover); color: #fff; }
        .cl-confidence-note { display: flex; align-items: center; justify-content: center; gap: 5px; margin-top: 0.85rem; font-size: 0.75rem; color: var(--cl-muted); }
        .cl-alert-error { background: var(--cl-red-soft); border: 1px solid rgba(230,57,70,0.15); color: var(--cl-red); border-radius: var(--radius-md); padding: 0.85rem 1.1rem; font-size: 0.8rem; line-height: 1.6; }

        @media (max-width: 767.98px) {
            .cl-split-left { min-height: auto; padding: 2rem 1.5rem !important; }
            .cl-split-title { font-size: 1.3rem; }
            .cl-urgence-grid { grid-template-columns: 1fr; }
            .cl-split-right { padding: 1.5rem !important; }
            .cl-split-card { border-radius: var(--radius-lg); border: none; box-shadow: none; }
        }
    </style>

    <script>
        function updateFileName(input) {
            const preview = document.getElementById('filePreview');
            const nameEl = document.getElementById('fileName');
            const zone = document.getElementById('fileZone');

            if (input.files && input.files[0]) {
                nameEl.textContent = input.files[0].name;
                preview.classList.remove('d-none');
                zone.style.borderColor = 'var(--cl-red)';
                zone.style.background = 'var(--cl-card-bg)';
            }
        }

        function clearFile() {
            const input = document.getElementById('attachment');
            const preview = document.getElementById('filePreview');
            const zone = document.getElementById('fileZone');

            input.value = '';
            preview.classList.add('d-none');
            zone.style.borderColor = '';
            zone.style.background = '';
        }
    </script>
</x-app-layout>
