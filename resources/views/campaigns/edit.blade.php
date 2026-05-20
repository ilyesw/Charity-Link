<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label"><i class="bi bi-pencil-square"></i> Modifier</div>
            <h2 class="mb-0" style="font-size:1.5rem;">Modifier la campagne</h2>
            <p class="header-sub mb-0">Mettez à jour les informations de votre campagne.</p>
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

                {{-- Formulaire DELETE caché --}}
                <form id="deleteForm" method="POST" action="{{ route('campaigns.destroy', $campaign) }}"
                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette campagne ? Cette action est irréversible.')">
                    @csrf
                    @method('DELETE')
                </form>

                {{-- Formulaire UPDATE --}}
                <form method="POST" action="{{ route('campaigns.update', $campaign) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Section 1 : Contenu --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <span class="fm-section-title">Contenu de la campagne</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-group">
                                <label class="fm-label">Titre</label>
                                <input type="text" name="title" class="fm-input"
                                    value="{{ old('title', $campaign->title) }}"
                                    placeholder="Ex: Couffins Ramadan 2026" required>
                            </div>
                            <div class="fm-group">
                                <label class="fm-label">Nature / Type de campagne</label>
                                <input type="text" name="nature" class="fm-input"
                                    value="{{ old('nature', $campaign->nature) }}"
                                    placeholder="Ex: Distribution couffins, Collecte vêtements, Aide médicale...">
                                <span class="fm-hint">Décrivez librement la nature de cette campagne.</span>
                            </div>
                            <div class="fm-group">
                                <label class="fm-label">Description</label>
                                <textarea name="description" class="fm-input fm-textarea" rows="4"
                                    placeholder="Décrivez l'objectif et le déroulement de la campagne..." required>{{ old('description', $campaign->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2 : Affiche --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon">
                                <i class="bi bi-image"></i>
                            </div>
                            <span class="fm-section-title">Affiche de la campagne</span>
                        </div>
                        <div class="fm-section-body">
                            @if($campaign->affiche)
                                <div class="fm-current-image">
                                    <img src="{{ asset('storage/' . $campaign->affiche) }}" alt="Affiche actuelle">
                                    <span class="fm-current-label"><i class="bi bi-check-circle-fill"></i> Affiche actuelle</span>
                                </div>
                            @endif
                            <div class="fm-file-drop" id="afficheDrop">
                                <i class="bi bi-cloud-arrow-up fm-file-icon"></i>
                                <p class="fm-file-text">
                                    {{ $campaign->affiche ? 'Remplacer l\'affiche' : 'Ajouter une affiche' }}
                                </p>
                                <p class="fm-file-hint">PNG, JPG jusqu'à 5 Mo</p>
                                <input type="file" name="affiche" id="afficheInput"
                                       accept="image/*" class="fm-file-input">
                            </div>
                            <div id="affichePreview" style="display:none; margin-top:0.75rem;">
                                <img id="affichePreviewImg" src="" alt="Aperçu" class="fm-preview-img">
                                <span class="fm-preview-label">Nouvelle affiche</span>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3 : Photos galerie --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon">
                                <i class="bi bi-images"></i>
                            </div>
                            <span class="fm-section-title">
                                Photos de la galerie
                                <span class="fm-section-optional">optionnel</span>
                            </span>
                        </div>
                        <div class="fm-section-body">
                            {{-- Photos existantes --}}
                            @if($campaign->photos && $campaign->photos->count() > 0)
                                <div class="fm-gallery-existing">
                                    @foreach($campaign->photos as $photo)
                                        <div class="fm-gallery-item" id="photo-{{ $photo->id }}">
                                            <img src="{{ asset('storage/' . $photo->path) }}" alt="Photo">
                                            <button type="button" class="fm-gallery-delete"
                                                    onclick="deletePhoto({{ $photo->id }}, this)">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="fm-file-drop fm-file-drop--multi" id="photosDrop">
                                <i class="bi bi-plus-circle fm-file-icon fm-file-icon--sm"></i>
                                <p class="fm-file-text">Ajouter des photos</p>
                                <p class="fm-file-hint">Sélectionnez plusieurs fichiers (PNG, JPG)</p>
                                <input type="file" name="photos[]" id="photosInput"
                                       accept="image/*" multiple class="fm-file-input">
                            </div>
                            <div id="photosPreview" class="fm-gallery-preview"></div>
                        </div>
                    </div>

                    {{-- Section 4 : Paramètres --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon">
                                <i class="bi bi-gear"></i>
                            </div>
                            <span class="fm-section-title">Paramètres</span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-row fm-row--2">
                                <div class="fm-group">
                                    <label class="fm-label">
                                        Date de début
                                        <span class="fm-section-optional">optionnel</span>
                                    </label>
                                    {{-- fix date --}}
                                    <input type="date" name="date_debut" class="fm-input"
                                        min="2000-01-01" max="2100-12-31"
                                        value="{{ old('date_debut', $campaign->date_debut?->format('Y-m-d')) }}">
                                </div>
                                <div class="fm-group">
                                    <label class="fm-label">
                                        Date de fin (deadline)
                                        <span class="fm-section-optional">optionnel</span>
                                    </label>
                                    {{-- fix date --}}
                                    <input type="date" name="deadline" class="fm-input"
                                        min="2000-01-01" max="2100-12-31"
                                        value="{{ old('deadline', $campaign->deadline?->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="fm-row fm-row--2">
                                <div class="fm-group">
                                    <label class="fm-label">
                                        Objectif financier (DT)
                                        <span class="fm-section-optional">optionnel</span>
                                    </label>
                                    <div class="fm-input-suffix-wrap">
                                        <input type="number" name="goal_amount" class="fm-input fm-input--has-suffix"
                                            value="{{ old('goal_amount', $campaign->goal_amount) }}"
                                            min="1" placeholder="Laisser vide si non financier">
                                        <span class="fm-input-suffix">DT</span>
                                    </div>
                                </div>
                                <div class="fm-group">
                                    <label class="fm-label">Statut</label>
                                    <select name="status" class="fm-select">
                                        @foreach(['active','terminee','suspendue'] as $s)
                                            <option value="{{ $s }}" {{ old('status', $campaign->status) == $s ? 'selected' : '' }}>
                                                {{ ucfirst($s) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="fm-group">
                                <label class="fm-label">
                                    Description de l'objectif
                                    <span class="fm-section-optional">optionnel</span>
                                </label>
                                <input type="text" name="objectif_description" class="fm-input"
                                    value="{{ old('objectif_description', $campaign->objectif_description) }}"
                                    placeholder="Ex: Distribuer 500 couffins aux familles nécessiteuses">
                                <span class="fm-hint">Décrivez l'objectif si la campagne n'est pas une collecte d'argent.</span>
                            </div>
                        </div>
                    </div>

                    {{-- Section 5 : Compte rendu --}}
                    <div class="fm-section">
                        <div class="fm-section-head">
                            <div class="fm-section-icon fm-section-icon--muted">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <span class="fm-section-title">
                                Compte rendu
                                <span class="fm-section-optional">optionnel — à remplir après la campagne</span>
                            </span>
                        </div>
                        <div class="fm-section-body">
                            <div class="fm-group">
                                <textarea name="compte_rendu" class="fm-input fm-textarea" rows="4"
                                    placeholder="Décrivez ce qui a été accompli, combien de personnes ont été aidées, les résultats obtenus...">{{ old('compte_rendu', $campaign->compte_rendu) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="fm-actions fm-actions--split">
                        <button type="submit" form="deleteForm" class="fm-btn fm-btn--danger-outline">
                            <i class="bi bi-trash3"></i>
                            Supprimer
                        </button>
                        <div class="d-flex gap-2">
                            <a href="{{ route('campaigns.show', $campaign) }}" class="fm-btn fm-btn--ghost">
                                Annuler
                            </a>
                            <button type="submit" class="fm-btn fm-btn--red">
                                <i class="bi bi-check-lg"></i>
                                Sauvegarder
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .fm-card {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl);
        padding: 1.75rem 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.35s ease;
    }

    .fm-alert {
        display: flex; align-items: flex-start; gap: 0.75rem;
        padding: 0.85rem 1.1rem;
        background: var(--cl-red-glow);
        border: 1px solid rgba(230,57,70,0.15);
        border-radius: var(--radius-md);
        margin-bottom: 1.5rem;
        font-size: 0.82rem; color: var(--cl-red);
        font-family: 'Inter', sans-serif;
        animation: fm-shake 0.4s ease;
    }
    .fm-alert i { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
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
        transition: border-color 0.35s ease;
    }
    .fm-section-icon {
        width: 36px; height: 36px;
        background: var(--cl-red-glow);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; transition: background 0.35s ease;
    }
    .fm-section-icon i { font-size: 0.95rem; color: var(--cl-red); }
    .fm-section-icon--muted { background: var(--cl-light); border: 1px solid var(--cl-border); }
    .fm-section-icon--muted i { color: var(--cl-muted); }
    .fm-section-title {
        font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.92rem;
        color: var(--cl-dark); transition: color 0.35s ease;
    }
    .fm-section-optional {
        font-weight: 400; font-size: 0.78rem; color: var(--cl-muted-light);
        margin-left: 0.4rem;
    }
    .fm-section-body { padding-left: 0.25rem; }

    .fm-group { margin-bottom: 1.1rem; }
    .fm-group:last-child { margin-bottom: 0; }

    .fm-label {
        display: block; font-family: 'Inter', sans-serif; font-weight: 600;
        font-size: 0.8rem; color: var(--cl-body);
        margin-bottom: 0.4rem; transition: color 0.35s ease;
    }
    .fm-hint {
        display: block; font-size: 0.75rem; color: var(--cl-muted-light);
        margin-top: 0.3rem; font-family: 'Inter', sans-serif;
    }

    .fm-input {
        width: 100%; padding: 0.6rem 0.85rem;
        font-family: 'Inter', sans-serif; font-size: 0.85rem;
        color: var(--cl-dark); background: var(--cl-light);
        border: 1.5px solid var(--cl-border);
        border-radius: var(--radius-md);
        outline: none !important; box-shadow: none !important;
        transition: all 0.25s ease;
    }
    .fm-input:focus {
        border-color: var(--cl-red) !important;
        box-shadow: 0 0 0 3px rgba(230,57,70,0.08) !important;
        background: var(--cl-card-bg);
    }
    .fm-input::placeholder { color: var(--cl-muted-light); }
    .fm-textarea { resize: vertical; min-height: 100px; }
    .fm-input--has-suffix { padding-right: 2.5rem; }

    .fm-input-suffix-wrap { position: relative; }
    .fm-input-suffix {
        position: absolute; right: 0.85rem; top: 50%;
        transform: translateY(-50%);
        font-family: 'Inter', sans-serif; font-weight: 700;
        font-size: 0.82rem; color: var(--cl-dark);
        pointer-events: none;
    }

    .fm-select {
        width: 100%; padding: 0.6rem 2.2rem 0.6rem 0.85rem;
        font-family: 'Inter', sans-serif; font-size: 0.85rem;
        color: var(--cl-dark);
        background: var(--cl-light) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 0.85rem center;
        border: 1.5px solid var(--cl-border);
        border-radius: var(--radius-md);
        outline: none !important; box-shadow: none !important;
        appearance: none; -webkit-appearance: none;
        cursor: pointer; transition: all 0.25s ease;
    }
    .fm-select:focus {
        border-color: var(--cl-red) !important;
        box-shadow: 0 0 0 3px rgba(230,57,70,0.08) !important;
        background-color: var(--cl-card-bg);
    }

    /* File upload */
    .fm-file-drop {
        position: relative;
        border: 2px dashed var(--cl-border);
        border-radius: var(--radius-md);
        padding: 1.5rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
        background: var(--cl-light);
    }
    .fm-file-drop:hover {
        border-color: var(--cl-red);
        background: var(--cl-red-glow);
    }
    .fm-file-drop--multi { padding: 1.1rem 1rem; }
    .fm-file-icon { font-size: 1.8rem; color: var(--cl-muted); display: block; margin-bottom: 0.5rem; }
    .fm-file-icon--sm { font-size: 1.4rem; }
    .fm-file-text {
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.85rem;
        color: var(--cl-dark); margin: 0 0 0.2rem;
    }
    .fm-file-hint {
        font-size: 0.75rem; color: var(--cl-muted-light); margin: 0;
        font-family: 'Inter', sans-serif;
    }
    .fm-file-input {
        position: absolute; inset: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }

    /* Current image */
    .fm-current-image {
        margin-bottom: 0.75rem;
        border-radius: var(--radius-md);
        overflow: hidden;
        position: relative;
        max-height: 180px;
    }
    .fm-current-image img {
        width: 100%; height: 180px; object-fit: cover;
        border-radius: var(--radius-md);
    }
    .fm-current-label {
        position: absolute; bottom: 0.5rem; left: 0.5rem;
        background: rgba(0,0,0,0.55); color: #fff;
        font-size: 0.72rem; font-family: 'Inter', sans-serif; font-weight: 600;
        padding: 0.2rem 0.6rem; border-radius: 20px;
        display: flex; align-items: center; gap: 0.3rem;
    }
    .fm-current-label i { color: #4ade80; font-size: 0.75rem; }

    /* Preview */
    .fm-preview-img {
        width: 100%; max-height: 160px; object-fit: cover;
        border-radius: var(--radius-md);
        border: 2px solid var(--cl-red);
    }
    .fm-preview-label {
        display: block; font-size: 0.75rem; color: var(--cl-red);
        font-family: 'Inter', sans-serif; font-weight: 600;
        margin-top: 0.3rem;
    }

    /* Gallery existing */
    .fm-gallery-existing {
        display: flex; flex-wrap: wrap; gap: 0.6rem;
        margin-bottom: 0.75rem;
    }
    .fm-gallery-item {
        position: relative; width: 80px; height: 80px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        border: 2px solid var(--cl-border);
    }
    .fm-gallery-item img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .fm-gallery-delete {
        position: absolute; top: 2px; right: 2px;
        width: 20px; height: 20px;
        background: rgba(230,57,70,0.9); color: #fff;
        border: none; border-radius: 50%;
        font-size: 0.55rem;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: background 0.2s;
        padding: 0;
    }
    .fm-gallery-delete:hover { background: var(--cl-red); }

    /* Gallery preview (new photos) */
    .fm-gallery-preview {
        display: flex; flex-wrap: wrap; gap: 0.6rem;
        margin-top: 0.75rem;
    }
    .fm-gallery-preview img {
        width: 80px; height: 80px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 2px solid var(--cl-red);
    }

    /* Grid rows */
    .fm-row { display: grid; gap: 1rem; }
    .fm-row--2 { grid-template-columns: 1fr 1fr; }
    .fm-row--3 { grid-template-columns: 1fr 1fr 1fr; }

    /* Actions */
    .fm-actions {
        display: flex; justify-content: flex-end; gap: 0.75rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--cl-border);
        transition: border-color 0.35s ease;
    }
    .fm-actions--split { justify-content: space-between; }

    .fm-btn {
        display: inline-flex; align-items: center; gap: 0.45rem;
        padding: 0.6rem 1.4rem;
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.84rem;
        border-radius: var(--radius-md);
        text-decoration: none; cursor: pointer;
        transition: all 0.25s ease;
        border: none !important; outline: none !important; box-shadow: none !important;
    }
    .fm-btn:focus { outline: none !important; box-shadow: none !important; }
    .fm-btn i { font-size: 0.88rem; }
    .fm-btn--red {
        background: var(--cl-red); color: #fff;
        box-shadow: 0 2px 8px rgba(230,57,70,0.2);
    }
    .fm-btn--red:hover {
        background: var(--cl-red-hover); color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(230,57,70,0.28) !important;
    }
    .fm-btn--ghost {
        background: transparent; color: var(--cl-muted);
        border: 1.5px solid var(--cl-border) !important;
    }
    .fm-btn--ghost:hover {
        color: var(--cl-dark); border-color: var(--cl-muted) !important;
        background: var(--cl-light);
    }
    .fm-btn--danger-outline {
        background: var(--cl-red-glow); color: var(--cl-red);
        border: 1.5px solid rgba(230,57,70,0.2) !important;
    }
    .fm-btn--danger-outline:hover {
        background: var(--cl-red); color: #fff;
        border-color: var(--cl-red) !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(230,57,70,0.25) !important;
    }

    @media (max-width: 991.98px) {
        .fm-row--3 { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 767.98px) {
        .fm-card { padding: 1.25rem 1.1rem; border-radius: var(--radius-lg); box-shadow: none; border: none; }
        .fm-row--2, .fm-row--3 { grid-template-columns: 1fr; gap: 0; }
        .fm-actions--split { flex-direction: column-reverse; gap: 0.6rem; }
        .fm-actions--split > .d-flex { flex-direction: column-reverse; gap: 0.6rem; width: 100%; }
        .fm-btn { justify-content: center; width: 100%; padding: 0.7rem; }
    }
    @media (max-width: 575.98px) {
        .fm-card { padding: 1rem 0.85rem; }
    }
</style>

<script>
// Aperçu affiche
document.getElementById('afficheInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('affichePreviewImg').src = e.target.result;
        document.getElementById('affichePreview').style.display = 'block';
    };
    reader.readAsDataURL(file);
});

// Aperçu photos multiples
document.getElementById('photosInput').addEventListener('change', function() {
    const preview = document.getElementById('photosPreview');
    preview.innerHTML = '';
    Array.from(this.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});

// Supprimer photo existante via AJAX
function deletePhoto(photoId, btn) {
    if (!confirm('Supprimer cette photo ?')) return;
    fetch(`/campaigns/photos/${photoId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('photo-' + photoId).remove();
        }
    })
    .catch(() => alert('Erreur lors de la suppression.'));
}
</script>
