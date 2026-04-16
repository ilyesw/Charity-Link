<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tâches bénévoles disponibles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold">
                    Tâches ouvertes ({{ $taches->total() }})
                </h3>
                @auth
                    @if(auth()->user()->isAssociation())
                        <a href="{{ route('taches.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            + Créer une tâche
                        </a>
                    @endif
                    @if(auth()->user()->isBenevole())
                        <a href="{{ route('taches.mes_taches') }}"
                            class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                            Mes tâches →
                        </a>
                    @endif
                @endauth
            </div>

            @if($taches->isEmpty())
                <div class="bg-white p-8 rounded shadow text-center text-gray-500">
                    Aucune tâche disponible pour le moment.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($taches as $tache)
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-semibold text-gray-800">
                                    {{ $tache->title }}
                                </h4>
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                    Ouverte
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mb-2">
                                🏢 {{ $tache->association->name }}
                            </p>
                            <p class="text-gray-600 text-sm mb-3">
                                {{ Str::limit($tache->description, 100) }}
                            </p>
                            <p class="text-sm text-blue-600 mb-2">
                                🎯 Compétence : {{ $tache->competence_requise }}
                            </p>
                            @if($tache->deadline)
                                <p class="text-xs text-gray-400 mb-3">
                                    📅 Deadline : {{ $tache->deadline->format('d/m/Y') }}
                                </p>
                            @endif

                            @auth
                                @if(auth()->user()->isBenevole())
                                    <form method="POST"
                                        action="{{ route('taches.postuler', $tache) }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 w-full">
                                            ✋ Je prends cette tâche
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $taches->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
