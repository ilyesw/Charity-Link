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

                <form method="POST" action="{{ route('associations.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Section 1 : Infos générales --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon"><i class="bi bi-building-add"></i></div>
                            <span class="fm-section-title">Informations générales</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-group">
                                <label class="fm-label">Nom de l'association</label>
                                <input type="text" name="name" class="fm-input @error('name') fm-input-error @enderror"
                                    value="{{ old('name') }}" placeholder="Ex: SOS Enfants Tunisie" required>
                            </div>
                            <div class="fm-group">
                                <label class="fm-label">Description</label>
                                <textarea name="description" rows="4"
                                    class="fm-input fm-textarea @error('description') fm-input-error @enderror"
                                    placeholder="Décrivez la mission et les actions de votre association..." required>{{ old('description') }}</textarea>
                            </div>

                            {{-- Photo --}}
                            <div class="fm-group">
                                <label class="fm-label">
                                    <i class="bi bi-image me-1"></i> Photo / Logo de l'association
                                </label>
                                <div class="fm-file-zone @error('logo') fm-file-zone-error @enderror" id="logoZone">
                                    <input type="file" name="logo" id="logo"
                                           accept=".jpg,.jpeg,.png,.webp"
                                           class="fm-file-input"
                                           onchange="previewLogo(this)" required>
                                    <div class="fm-file-content" id="logoContent">
                                        <i class="bi bi-image" style="font-size:1.5rem;color:var(--cl-muted);"></i>
                                        <span class="fm-file-text">Cliquez pour ajouter le logo</span>
                                        <span class="fm-file-hint">JPG, PNG, WEBP — max 3 Mo</span>
                                    </div>
                                    <img id="logoPreviewImg" src="#" alt="preview"
                                         style="display:none;max-height:120px;border-radius:var(--radius-md);object-fit:cover;">
                                </div>
                                @error('logo')<div class="fm-error-text">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section 2 : Contact --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon"><i class="bi bi-telephone"></i></div>
                            <span class="fm-section-title">Coordonnées de contact</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-row">
                                <div class="fm-group">
                                    <label class="fm-label">📱 Téléphone portable</label>
                                    <input type="text" name="phone_mobile"
                                           class="fm-input @error('phone_mobile') fm-input-error @enderror"
                                           value="{{ old('phone_mobile') }}"
                                           placeholder="Ex: 55 123 456" required>
                                    @error('phone_mobile')<div class="fm-error-text">{{ $message }}</div>@enderror
                                </div>
                                <div class="fm-group">
                                    <label class="fm-label">
                                        ☎️ Téléphone fixe
                                        <span class="fm-section-optional">optionnel</span>
                                    </label>
                                    <input type="text" name="phone_fix"
                                           class="fm-input @error('phone_fix') fm-input-error @enderror"
                                           value="{{ old('phone_fix') }}"
                                           placeholder="Ex: 71 123 456">
                                </div>
                            </div>
                            <div class="fm-group">
                                <label class="fm-label">📧 Email de l'association</label>
                                <div class="fm-input-icon-wrap">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" name="email"
                                           class="fm-input fm-input--has-icon @error('email') fm-input-error @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="contact@association.tn" required>
                                </div>
                                @error('email')<div class="fm-error-text">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section 3 : Localisation --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon"><i class="bi bi-geo-alt"></i></div>
                            <span class="fm-section-title">Localisation et catégorie</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-row">
                                <div class="fm-group">
                                    <label class="fm-label">Catégorie</label>
                                    <select name="category" class="fm-select" required>
                                        @foreach(['enfants','education','sante','alimentation','environnement','autre'] as $cat)
                                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                                                {{ ucfirst($cat) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="fm-group">
                                    <label class="fm-label">Région</label>
                                    <select name="region" class="fm-select" required>
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

                    {{-- Section 4 : Documents justificatifs --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon"><i class="bi bi-file-earmark-text"></i></div>
                            <span class="fm-section-title">Documents justificatifs</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-doc-info">
                                <i class="bi bi-info-circle"></i>
                                Ces documents sont requis pour valider votre association. Ils restent confidentiels.
                            </div>

                            {{-- RNE --}}
                            <div class="fm-group">
                                <label class="fm-label">
                                    <i class="bi bi-file-earmark-ruled me-1"></i>
                                    Extrait du Registre National des Entreprises (RNE)
                                </label>
                                <div class="fm-file-zone @error('doc_rne') fm-file-zone-error @enderror" id="rneZone">
                                    <input type="file" name="doc_rne" id="doc_rne"
                                           accept=".jpg,.jpeg,.png,.pdf"
                                           class="fm-file-input"
                                           onchange="updateDocName(this, 'rnePreview', 'rneZone')" required>
                                    <div class="fm-file-content" id="rneContent">
                                        <i class="bi bi-file-earmark-arrow-up" style="font-size:1.5rem;color:var(--cl-muted);"></i>
                                        <span class="fm-file-text">Cliquez ou glissez le document RNE</span>
                                        <span class="fm-file-hint">JPG, PNG, PDF — max 5 Mo</span>
                                    </div>
                                </div>
                                <div id="rnePreview" class="fm-file-preview d-none">
                                    <i class="bi bi-file-earmark-check text-success"></i>
                                    <span class="fm-preview-name"></span>
                                    <button type="button" onclick="clearDoc('doc_rne','rnePreview','rneZone')" class="fm-file-clear">✕</button>
                                </div>
                                @error('doc_rne')<div class="fm-error-text">{{ $message }}</div>@enderror
                            </div>

                            {{-- Carte fiscale --}}
                            <div class="fm-group">
                                <label class="fm-label">
                                    <i class="bi bi-credit-card me-1"></i>
                                    Carte d'identification fiscale
                                </label>
                                <div class="fm-file-zone @error('doc_fiscal') fm-file-zone-error @enderror" id="fiscalZone">
                                    <input type="file" name="doc_fiscal" id="doc_fiscal"
                                           accept=".jpg,.jpeg,.png,.pdf"
                                           class="fm-file-input"
                                           onchange="updateDocName(this, 'fiscalPreview', 'fiscalZone')" required>
                                    <div class="fm-file-content" id="fiscalContent">
                                        <i class="bi bi-file-earmark-arrow-up" style="font-size:1.5rem;color:var(--cl-muted);"></i>
                                        <span class="fm-file-text">Cliquez ou glissez la carte fiscale</span>
                                        <span class="fm-file-hint">JPG, PNG, PDF — max 5 Mo</span>
                                    </div>
                                </div>
                                <div id="fiscalPreview" class="fm-file-preview d-none">
                                    <i class="bi bi-file-earmark-check text-success"></i>
                                    <span class="fm-preview-name"></span>
                                    <button type="button" onclick="clearDoc('doc_fiscal','fiscalPreview','fiscalZone')" class="fm-file-clear">✕</button>
                                </div>
                                @error('doc_fiscal')<div class="fm-error-text">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section 5 : Réseaux --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon fm-section-icon--muted"><i class="bi bi-link-45deg"></i></div>
                            <span class="fm-section-title">Réseaux et liens <span class="fm-section-optional">optionnel</span></span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-row">
                                <div class="fm-group">
                                    <label class="fm-label">Site web</label>
                                    <div class="fm-input-icon-wrap">
                                        <i class="bi bi-globe"></i>
                                        <input type="url" name="website" class="fm-input fm-input--has-icon"
                                            value="{{ old('website') }}" placeholder="https://monsite.tn">
                                    </div>
                                </div>
                                <div class="fm-group">
                                    <label class="fm-label">Facebook</label>
                                    <div class="fm-input-icon-wrap">
                                        <i class="bi bi-facebook"></i>
                                        <input type="url" name="facebook" class="fm-input fm-input--has-icon"
                                            value="{{ old('facebook') }}" placeholder="https://facebook.com/...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="fm-actions">
                        <a href="{{ route('associations.index') }}" class="fm-btn fm-btn--ghost">Annuler</a>
                        <button type="submit" class="fm-btn fm-btn--red">
                            <i class="bi bi-send"></i> Soumettre pour validation
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .fm-card { background: var(--cl-card-bg); border: 1px solid var(--cl-card-border); border-radius: var(--radius-xl); padding: 1.75rem 1.5rem; box-shadow: var(--shadow-sm); }
    .fm-alert { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.85rem 1.1rem; background: var(--cl-red-glow); border: 1px solid rgba(230,57,70,0.15); border-radius: var(--radius-md); margin-bottom: 1.5rem; font-size: 0.82rem; color: var(--cl-red); font-family: 'Inter', sans-serif; }
    .fm-section { margin-bottom: 1.75rem; }
    .fm-section-head { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.15rem; padding-bottom: 0.85rem; border-bottom: 1px solid var(--cl-border); }
    .fm-section-icon { width: 36px; height: 36px; background: var(--cl-red-glow); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .fm-section-icon i { font-size: 0.95rem; color: var(--cl-red); }
    .fm-section-icon--muted { background: var(--cl-light); border: 1px solid var(--cl-border); }
    .fm-section-icon--muted i { color: var(--cl-muted); }
    .fm-section-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.92rem; color: var(--cl-dark); }
    .fm-section-optional { font-weight: 400; font-size: 0.78rem; color: var(--cl-muted-light); margin-left: 0.4rem; }
    .fm-section-body { padding-left: 0.25rem; }
    .fm-group { margin-bottom: 1.1rem; }
    .fm-group:last-child { margin-bottom: 0; }
    .fm-label { display: block; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.8rem; color: var(--cl-body); margin-bottom: 0.4rem; }
    .fm-input { width: 100%; padding: 0.6rem 0.85rem; font-family: 'Inter', sans-serif; font-size: 0.85rem; color: var(--cl-dark); background: var(--cl-light); border: 1.5px solid var(--cl-border); border-radius: var(--radius-md); outline: none !important; transition: all 0.25s ease; }
    .fm-input:focus { border-color: var(--cl-red) !important; box-shadow: 0 0 0 3px rgba(230,57,70,0.08) !important; background: var(--cl-card-bg); }
    .fm-input::placeholder { color: var(--cl-muted-light); }
    .fm-input-error { border-color: var(--cl-red) !important; }
    .fm-textarea { resize: vertical; min-height: 100px; }
    .fm-input--has-icon { padding-left: 2.5rem; }
    .fm-input-icon-wrap { position: relative; }
    .fm-input-icon-wrap i { position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); font-size: 0.9rem; color: var(--cl-muted); pointer-events: none; }
    .fm-input-icon-wrap:focus-within i { color: var(--cl-red); }
    .fm-select { width: 100%; padding: 0.6rem 2.2rem 0.6rem 0.85rem; font-family: 'Inter', sans-serif; font-size: 0.85rem; color: var(--cl-dark); background: var(--cl-light) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 0.85rem center; border: 1.5px solid var(--cl-border); border-radius: var(--radius-md); outline: none !important; appearance: none; cursor: pointer; transition: all 0.25s ease; }
    .fm-select:focus { border-color: var(--cl-red) !important; box-shadow: 0 0 0 3px rgba(230,57,70,0.08) !important; }
    .fm-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .fm-error-text { font-size: 0.75rem; color: var(--cl-red); margin-top: 0.3rem; }

    /* Doc info box */
    .fm-doc-info { display: flex; align-items: center; gap: 0.5rem; padding: 0.65rem 0.9rem; background: rgba(59,130,246,0.07); border: 1px solid rgba(59,130,246,0.15); border-radius: var(--radius-md); font-size: 0.8rem; color: var(--cl-blue); font-weight: 500; margin-bottom: 1rem; }

    /* File zones */
    .fm-file-zone { position: relative; border: 2px dashed var(--cl-border); border-radius: var(--radius-md); background: var(--cl-light); cursor: pointer; overflow: hidden; transition: all 0.25s ease; text-align: center; }
    .fm-file-zone:hover { border-color: var(--cl-red); background: var(--cl-card-bg); }
    .fm-file-zone-error { border-color: var(--cl-red) !important; }
    .fm-file-input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .fm-file-content { display: flex; flex-direction: column; align-items: center; padding: 1.25rem 1rem; gap: 0.3rem; pointer-events: none; }
    .fm-file-text { font-size: 0.82rem; font-weight: 600; color: var(--cl-dark); }
    .fm-file-hint { font-size: 0.72rem; color: var(--cl-muted); }
    .fm-file-preview { display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 0.75rem; background: var(--cl-green-soft); border: 1px solid rgba(45,198,83,0.2); border-radius: var(--radius-sm); margin-top: 0.5rem; font-size: 0.8rem; color: #1A8C38; font-weight: 500; }
    .fm-preview-name { flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .fm-file-clear { margin-left: auto; background: none; border: none; color: #1A8C38; cursor: pointer; font-size: 0.85rem; padding: 0 4px; }

    /* Actions */
    .fm-actions { display: flex; justify-content: flex-end; gap: 0.75rem; padding-top: 1.25rem; border-top: 1px solid var(--cl-border); }
    .fm-btn { display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.6rem 1.4rem; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.84rem; border-radius: var(--radius-md); text-decoration: none; cursor: pointer; transition: all 0.25s ease; border: none !important; outline: none !important; }
    .fm-btn--red { background: var(--cl-red); color: #fff; }
    .fm-btn--red:hover { background: var(--cl-red-hover); color: #fff; transform: translateY(-1px); }
    .fm-btn--ghost { background: transparent; color: var(--cl-muted); border: 1.5px solid var(--cl-border) !important; }
    .fm-btn--ghost:hover { color: var(--cl-dark); border-color: var(--cl-muted) !important; background: var(--cl-light); }

    @media (max-width: 767.98px) {
        .fm-card { padding: 1.25rem 1.1rem; border-radius: var(--radius-lg); box-shadow: none; border: none; }
        .fm-row { grid-template-columns: 1fr; gap: 0; }
        .fm-actions { flex-direction: column-reverse; gap: 0.6rem; }
        .fm-btn { justify-content: center; width: 100%; padding: 0.7rem; }
    }
</style>

<script>
    function previewLogo(input) {
        const zone = document.getElementById('logoZone');
        const content = document.getElementById('logoContent');
        const img = document.getElementById('logoPreviewImg');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                img.style.display = 'block';
                content.style.display = 'none';
                zone.style.padding = '0.75rem';
                zone.style.borderStyle = 'solid';
                zone.style.borderColor = 'var(--cl-red)';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updateDocName(input, previewId, zoneId) {
        const preview = document.getElementById(previewId);
        const zone = document.getElementById(zoneId);
        if (input.files && input.files[0]) {
            preview.querySelector('.fm-preview-name').textContent = input.files[0].name;
            preview.classList.remove('d-none');
            zone.style.borderColor = 'var(--cl-red)';
            zone.style.borderStyle = 'solid';
        }
    }

    function clearDoc(inputId, previewId, zoneId) {
        document.getElementById(inputId).value = '';
        document.getElementById(previewId).classList.add('d-none');
        const zone = document.getElementById(zoneId);
        zone.style.borderColor = '';
        zone.style.borderStyle = '';
    }
</script>
