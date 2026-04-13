@php
    $donations = \App\Models\Donation::where('user_id', auth()->id())
        ->with('campaign')
        ->latest()
        ->take(5)
        ->get();

    $totalFinancier = \App\Models\Donation::where('user_id', auth()->id())
        ->where('type', 'financier')
        ->sum('amount');

    $totalDons = \App\Models\Donation::where('user_id', auth()->id())
        ->count();
@endphp

<div class="mb-6">
    <h3 class="text-xl font-bold text-gray-800">
        Bonjour, {{ auth()->user()->name }} ! 👋
    </h3>
    <p class="text-gray-500">Voici un résumé de vos contributions</p>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <div class="text-3xl font-bold text-green-600">
            {{ number_format($totalFinancier, 2) }} DT
        </div>
        <div class="text-gray-500 mt-1">Total dons financiers</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <div class="text-3xl font-bold text-blue-600">
            {{ $totalDons }}
        </div>
        <div class="text-gray-500 mt-1">Total contributions</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <div class="text-3xl font-bold text-purple-600">
            {{ \App\Models\Donation::where('user_id', auth()->id())
                ->where('type', 'competences')->count() }}
        </div>
        <div class="text-gray-500 mt-1">Dons de compétences</div>
    </div>
</div>

<!-- Derniers dons -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h4 class="font-semibold text-gray-800">Mes derniers dons</h4>
        <a href="{{ route('donations.historique') }}"
            class="text-blue-600 hover:underline text-sm">
            Voir tout →
        </a>
    </div>

    @if($donations->isEmpty())
        <p class="text-gray-500 text-center py-4">
            Aucun don effectué.
            <a href="{{ route('campaigns.index') }}" class="text-blue-600">
                Voir les campagnes
            </a>
        </p>
    @else
        <div class="space-y-3">
            @foreach($donations as $donation)
                <div class="flex justify-between items-center border-b pb-2">
                    <div>
                        <span class="text-sm font-medium">
                            {{ $donation->campaign->title }}
                        </span>
                        <span class="ml-2 text-xs px-2 py-1 rounded
                            {{ $donation->type === 'financier' ? 'bg-green-100 text-green-800' :
                               ($donation->type === 'nature' ? 'bg-blue-100 text-blue-800' :
                               'bg-purple-100 text-purple-800') }}">
                            {{ $donation->type }}
                        </span>
                    </div>
                    <div class="text-right">
                        @if($donation->type === 'financier')
                            <span class="font-semibold text-green-600">
                                {{ number_format($donation->amount, 2) }} DT
                            </span>
                        @else
                            <span class="text-gray-500 text-sm">
                                {{ ucfirst($donation->type) }}
                            </span>
                        @endif
                        <p class="text-xs text-gray-400">
                            {{ $donation->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Liens rapides -->
<div class="grid grid-cols-2 gap-4">
    <a href="{{ route('campaigns.index') }}"
        class="bg-green-600 text-white p-4 rounded-lg text-center hover:bg-green-700">
        💚 Faire un don
    </a>
    <a href="{{ route('associations.index') }}"
        class="bg-blue-600 text-white p-4 rounded-lg text-center hover:bg-blue-700">
        🏢 Voir les associations
    </a>
</div>
