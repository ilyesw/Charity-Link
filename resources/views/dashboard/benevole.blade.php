@php
    $taches = \App\Models\Tache::where('benevole_id', auth()->id())
        ->with('association')
        ->latest()
        ->get();

    $tachesOuvertes = \App\Models\Tache::ouverte()
        ->with('association')
        ->latest()
        ->take(3)
        ->get();
@endphp

<div class="mb-6">
    <h3 class="text-xl font-bold text-gray-800">
        Bonjour, {{ auth()->user()->name }} ! 👋
    </h3>
    <p class="text-gray-500">Espace Bénévole — Charity-Link</p>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <div class="text-3xl font-bold text-purple-600">
            {{ $taches->count() }}
        </div>
        <div class="text-gray-500 mt-1">Mes tâches</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <div class="text-3xl font-bold text-yellow-600">
            {{ $taches->where('status', 'en_cours')->count() }}
        </div>
        <div class="text-gray-500 mt-1">En cours</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <div class="text-3xl font-bold text-green-600">
            {{ $taches->where('status', 'validee')->count() }}
        </div>
        <div class="text-gray-500 mt-1">Validées</div>
    </div>
</div>

<!-- Mes tâches en cours -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h4 class="font-semibold text-gray-800">Mes tâches en cours</h4>
        <a href="{{ route('taches.mes_taches') }}"
            class="text-purple-600 hover:underline text-sm">
            Voir tout →
        </a>
    </div>

    @if($taches->isEmpty())
        <p class="text-gray-500 text-center py-4">
            Aucune tâche assignée.
        </p>
    @else
        <div class="space-y-3">
            @foreach($taches->take(3) as $tache)
                <div class="flex justify-between items-center border-b pb-2">
                    <div>
                        <span class="text-sm font-medium">{{ $tache->title }}</span>
                        <p class="text-xs text-gray-500">
                            🏢 {{ $tache->association->name }}
                        </p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded
                        {{ $tache->status === 'en_cours'
                            ? 'bg-yellow-100 text-yellow-800'
                            : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($tache->status) }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Tâches disponibles -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h4 class="font-semibold text-gray-800">Tâches disponibles</h4>
        <a href="{{ route('taches.index') }}"
            class="text-blue-600 hover:underline text-sm">
            Voir tout →
        </a>
    </div>

    @if($tachesOuvertes->isEmpty())
        <p class="text-gray-500 text-center py-4">
            Aucune tâche disponible.
        </p>
    @else
        <div class="space-y-3">
            @foreach($tachesOuvertes as $tache)
                <div class="flex justify-between items-center border-b pb-2">
                    <div>
                        <span class="text-sm font-medium">{{ $tache->title }}</span>
                        <p class="text-xs text-gray-500">
                            🎯 {{ $tache->competence_requise }}
                        </p>
                    </div>
                    <a href="{{ route('taches.index') }}"
                        class="text-purple-600 hover:underline text-xs">
                        Voir →
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Liens rapides -->
<div class="grid grid-cols-2 gap-4">
    <a href="{{ route('taches.index') }}"
        class="bg-purple-600 text-white p-4 rounded-lg text-center hover:bg-purple-700">
        🤝 Voir les tâches
    </a>
    <a href="{{ route('taches.mes_taches') }}"
        class="bg-gray-600 text-white p-4 rounded-lg text-center hover:bg-gray-700">
        📋 Mes tâches
    </a>
</div>
