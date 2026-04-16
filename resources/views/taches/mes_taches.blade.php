<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes tâches') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold">
                    Mes tâches ({{ $taches->count() }})
                </h3>
                <a href="{{ route('taches.index') }}"
                    class="text-blue-600 hover:underline text-sm">
                    ← Voir toutes les tâches
                </a>
            </div>

            @if($taches->isEmpty())
                <div class="bg-white p-8 rounded shadow text-center text-gray-500">
                    <div class="text-4xl mb-3">🤝</div>
                    <p>Vous n'avez pas encore de tâches.</p>
                    <a href="{{ route('taches.index') }}"
                        class="mt-4 inline-block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                        Voir les tâches disponibles
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($taches as $tache)
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-semibold text-gray-800">
                                    {{ $tache->title }}
                                </h4>
                                <span class="text-xs px-2 py-1 rounded
                                    {{ $tache->status === 'en_cours'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($tache->status) }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-500 mb-2">
                                🏢 {{ $tache->association->name }}
                            </p>
                            <p class="text-gray-600 text-sm mb-3">
                                {{ $tache->description }}
                            </p>

                            @if($tache->deadline)
                                <p class="text-xs text-gray-400 mb-3">
                                    📅 Deadline : {{ $tache->deadline->format('d/m/Y') }}
                                </p>
                            @endif

                            <!-- Formulaire compte rendu -->
                            @if($tache->status === 'en_cours')
                                <form method="POST"
                                    action="{{ route('taches.compte_rendu', $tache) }}"
                                    class="mt-4 border-t pt-4">
                                    @csrf
                                    <div class="mb-3">
                                        <x-input-label for="compte_rendu_{{ $tache->id }}"
                                            :value="__('Compte rendu')" />
                                        <textarea
                                            id="compte_rendu_{{ $tache->id }}"
                                            name="compte_rendu"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                            rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <x-input-label for="feedback_{{ $tache->id }}"
                                            :value="__('Feedback (optionnel)')" />
                                        <textarea
                                            id="feedback_{{ $tache->id }}"
                                            name="feedback"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                            rows="2"></textarea>
                                    </div>
                                    <x-primary-button>
                                        {{ __('Soumettre le compte rendu') }}
                                    </x-primary-button>
                                </form>
                            @endif

                            @if($tache->compte_rendu)
                                <div class="mt-4 border-t pt-4 bg-green-50 p-3 rounded">
                                    <p class="text-sm font-medium text-green-800">
                                        ✅ Compte rendu soumis :
                                    </p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $tache->compte_rendu }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
