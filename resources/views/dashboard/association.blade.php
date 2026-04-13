@php
    $association = \App\Models\Association::where('user_id', auth()->id())
        ->first();
@endphp

@if(!$association)
    <div class="bg-white p-6 rounded shadow text-center">
        <p class="text-gray-600 mb-4">
            Vous n'avez pas encore créé votre profil association.
        </p>
        <a href="{{ route('associations.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Créer mon profil
        </a>
    </div>
@else
@php
    $campaigns = $association->campaigns()->latest()->get();
    $totalDons = 0;
    $totalDonateurs = 0;
    foreach($campaigns as $campaign) {
        $totalDons += $campaign->current_amount;
        $totalDonateurs += $campaign->donations()->count();
    }
@endphp

<div class="mb-6">
    <h3 class="text-xl font-bold text-gray-800">
        Bonjour, {{ $association->name }} ! 👋
    </h3>
    <p class="text-gray-500">
        Statut :
        <span class="px-2 py-1 rounded text-xs
            {{ $association->status === 'validee'
                ? 'bg-green-100 text-green-800'
                : 'bg-yellow-100 text-yellow-800' }}">
            {{ ucfirst($association->status) }}
        </span>
    </p>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <div class="text-3xl font-bold text-green-600">
            {{ number_format($totalDons, 2) }} DT
        </div>
        <div class="text-gray-500 mt-1">Total collecté</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <div class="text-3xl font-bold text-blue-600">
            {{ $campaigns->count() }}
        </div>
        <div class="text-gray-500 mt-1">Campagnes</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <div class="text-3xl font-bold text-purple-600">
            {{ $totalDonateurs }}
        </div>
        <div class="text-gray-500 mt-1">Contributions reçues</div>
    </div>
</div>

<!-- Campagnes -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h4 class="font-semibold text-gray-800">Mes campagnes</h4>
        <a href="{{ route('campaigns.create') }}"
            class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
            + Nouvelle campagne
        </a>
    </div>

    @if($campaigns->isEmpty())
        <p class="text-gray-500 text-center py-4">
            Aucune campagne créée.
        </p>
    @else
        <div class="space-y-4">
            @foreach($campaigns as $campaign)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <h5 class="font-medium text-gray-800">
                            {{ $campaign->title }}
                        </h5>
                        <span class="text-xs px-2 py-1 rounded
                            {{ $campaign->status === 'active'
                                ? 'bg-green-100 text-green-800'
                                : 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($campaign->status) }}
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                        <div class="bg-blue-600 h-2 rounded-full"
                            style="width: {{ $campaign->progressPercentage() }}%">
                        </div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>{{ number_format($campaign->current_amount, 2) }} DT</span>
                        <span>{{ $campaign->progressPercentage() }}%</span>
                        <span>{{ number_format($campaign->goal_amount, 2) }} DT</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Liens rapides -->
<div class="grid grid-cols-2 gap-4">
    <a href="{{ route('campaigns.create') }}"
        class="bg-blue-600 text-white p-4 rounded-lg text-center hover:bg-blue-700">
        📢 Publier une campagne
    </a>
    <a href="{{ route('associations.show', $association) }}"
        class="bg-gray-600 text-white p-4 rounded-lg text-center hover:bg-gray-700">
        👁️ Voir mon profil
    </a>
</div>
@endif
