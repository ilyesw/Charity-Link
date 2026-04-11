<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historique des dons') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Mes dons ({{ $donations->total() }})
                </h3>

                @if($donations->isEmpty())
                    <div class="text-center text-gray-500 py-8">
                        <div class="text-4xl mb-3">💝</div>
                        <p>Vous n'avez pas encore effectué de don.</p>
                        <a href="{{ route('campaigns.index') }}"
                            class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Voir les campagnes
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($donations as $donation)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <!-- Type badge -->
                                        @if($donation->type === 'financier')
                                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                                💰 Don financier
                                            </span>
                                        @elseif($donation->type === 'nature')
                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                                👕 Don en nature
                                            </span>
                                        @else
                                            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">
                                                🧠 Don de compétences
                                            </span>
                                        @endif

                                        <h4 class="font-semibold text-gray-800 mt-2">
                                            {{ $donation->campaign->title }}
                                        </h4>

                                        <!-- Détails selon type -->
                                        @if($donation->type === 'financier')
                                            <p class="text-sm text-gray-600 mt-1">
                                                Montant : <strong>{{ number_format($donation->amount, 2) }} DT</strong>
                                            </p>
                                        @elseif($donation->type === 'nature')
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ ucfirst($donation->category) }} —
                                                {{ $donation->quantity }} unité(s)
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Lieu dépôt : {{ $donation->pickup_address }}
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-600 mt-1">
                                                Compétence : {{ $donation->competence }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Disponibilité : {{ $donation->availability }}
                                            </p>
                                        @endif

                                        @if($donation->message)
                                            <p class="text-xs text-gray-400 mt-1 italic">
                                                "{{ $donation->message }}"
                                            </p>
                                        @endif
                                    </div>

                                    <div class="text-right">
                                        <!-- Statut -->
                                        <span class="text-xs px-2 py-1 rounded
                                            {{ $donation->status === 'confirme'
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                        <p class="text-xs text-gray-400 mt-2">
                                            {{ $donation->created_at->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $donations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
