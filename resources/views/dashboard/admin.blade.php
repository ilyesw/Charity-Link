@php
    $stats = [
        'total_users'        => \App\Models\User::count(),
        'total_associations' => \App\Models\Association::count(),
        'validees'           => \App\Models\Association::where('status', 'validee')->count(),
        'en_attente'         => \App\Models\Association::where('status', 'en_attente')->count(),
        'total_campaigns'    => \App\Models\Campaign::count(),
        'total_donations'    => \App\Models\Donation::count(),
        'total_besoins'      => \App\Models\Besoin::count(),
        'total_collected'    => \App\Models\Donation::where('type', 'financier')->sum('amount'),
    ];

    $associations_en_attente = \App\Models\Association::where('status', 'en_attente')
        ->with('user')->latest()->get();
    $besoins_en_attente = \App\Models\Besoin::where('status', 'en_attente')
        ->latest()->take(5)->get();
@endphp

<div class="mb-6">
    <h3 class="text-xl font-bold text-gray-800">
        Panel Administrateur 🛡️
    </h3>
    <p class="text-gray-500">Vue globale de la plateforme Charity-Link</p>
</div>

<!-- Statistiques globales -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-blue-600">{{ $stats['total_users'] }}</div>
        <div class="text-gray-500 text-sm mt-1">Utilisateurs</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-green-600">{{ $stats['validees'] }}</div>
        <div class="text-gray-500 text-sm mt-1">Associations validées</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-yellow-600">{{ $stats['en_attente'] }}</div>
        <div class="text-gray-500 text-sm mt-1">En attente</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-purple-600">{{ $stats['total_campaigns'] }}</div>
        <div class="text-gray-500 text-sm mt-1">Campagnes</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-red-600">{{ $stats['total_donations'] }}</div>
        <div class="text-gray-500 text-sm mt-1">Dons effectués</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-green-600">
            {{ number_format($stats['total_collected'], 2) }} DT
        </div>
        <div class="text-gray-500 text-sm mt-1">Total collecté</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-orange-600">{{ $stats['total_besoins'] }}</div>
        <div class="text-gray-500 text-sm mt-1">Besoins déclarés</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <div class="text-2xl font-bold text-gray-600">{{ $stats['total_associations'] }}</div>
        <div class="text-gray-500 text-sm mt-1">Total associations</div>
    </div>
</div>

<!-- Associations en attente -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h4 class="font-semibold text-gray-800 mb-4">
        Associations en attente ({{ $associations_en_attente->count() }})
    </h4>
    @if($associations_en_attente->isEmpty())
        <p class="text-gray-500 text-center py-4">Aucune association en attente ✅</p>
    @else
        <div class="space-y-4">
            @foreach($associations_en_attente as $association)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h5 class="font-semibold">{{ $association->name }}</h5>
                            <p class="text-sm text-gray-500">
                                {{ $association->region }} — {{ ucfirst($association->category) }}
                            </p>
                            <p class="text-xs text-gray-400">
                                Par : {{ $association->user->name }}
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <form method="POST"
                                action="{{ route('admin.associations.valider', $association) }}">
                                @csrf
                                <button type="submit"
                                    class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                    ✅ Valider
                                </button>
                            </form>
                            <form method="POST"
                                action="{{ route('admin.associations.rejeter', $association) }}"
                                class="flex gap-2">
                                @csrf
                                <input type="text" name="rejection_reason"
                                    placeholder="Motif..."
                                    class="border border-gray-300 rounded px-2 py-1 text-sm w-32"
                                    required />
                                <button type="submit"
                                    class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                    ❌ Rejeter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Besoins en attente -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h4 class="font-semibold text-gray-800 mb-4">
        Derniers besoins déclarés ({{ $besoins_en_attente->count() }})
    </h4>
    @if($besoins_en_attente->isEmpty())
        <p class="text-gray-500 text-center py-4">Aucun besoin déclaré</p>
    @else
        <div class="space-y-3">
            @foreach($besoins_en_attente as $besoin)
                <div class="border border-gray-200 rounded-lg p-3">
                    <div class="flex justify-between">
                        <div>
                            <span class="font-medium text-sm">{{ $besoin->nom }}</span>
                            <span class="ml-2 text-xs px-2 py-1 rounded
                                {{ $besoin->urgence === 'critique' ? 'bg-red-100 text-red-800' :
                                   ($besoin->urgence === 'urgente' ? 'bg-yellow-100 text-yellow-800' :
                                   'bg-gray-100 text-gray-600') }}">
                                {{ ucfirst($besoin->urgence) }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ ucfirst($besoin->categorie) }} — {{ $besoin->region }}
                            </p>
                        </div>
                        <span class="text-xs text-gray-400">
                            {{ $besoin->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Liens rapides Admin -->
<div class="grid grid-cols-2 gap-4">
    <a href="{{ route('admin.index') }}"
        class="bg-blue-600 text-white p-4 rounded-lg text-center hover:bg-blue-700">
        🛡️ Panel Admin complet
    </a>
    <a href="{{ route('associations.index') }}"
        class="bg-gray-600 text-white p-4 rounded-lg text-center hover:bg-gray-700">
        🏢 Voir associations
    </a>
</div>
