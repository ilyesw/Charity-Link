<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2>✏️ Modifier la tâche</h2>
            <a href="{{ route('taches.index') }}" class="btn-cl-outline btn btn-sm">← Retour</a>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="cl-card p-4">

                @if($errors->any())
                    <div class="alert-cl-error mb-4">
                        @foreach($errors->all() as $error)
                            <div>• {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('taches.update', $tache) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Titre</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $tache->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="4" required>{{ old('description', $tache->description) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Compétence requise</label>
                            <input type="text" name="competence_requise" class="form-control"
                                value="{{ old('competence_requise', $tache->competence_requise) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Deadline</label>
                            <input type="date" name="deadline" class="form-control"
                                value="{{ old('deadline', $tache->deadline?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Statut</label>
                            <select name="status" class="form-select">
                                @foreach(['ouverte','en_cours','validee'] as $s)
                                    <option value="{{ $s }}" {{ old('status', $tache->status) == $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">

                        {{-- Supprimer --}}
                        <form method="POST" action="{{ route('taches.destroy', $tache) }}"
                            onsubmit="return confirm('Supprimer cette tâche ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm"
                                style="background:#FEF2F1;color:#E63946;border:1.5px solid #FECACA;border-radius:10px;font-weight:600;">
                                🗑️ Supprimer
                            </button>
                        </form>

                        <button type="submit" class="btn-cl btn">
                            💾 Sauvegarder
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
