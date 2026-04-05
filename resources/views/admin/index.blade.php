<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Administrateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-3xl font-bold text-blue-600">
                        {{ $stats['total_users'] }}
                    </div>
                    <div class="text-gray-500 mt-1">Utilisateurs</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-3xl font-bold text-green-600">
                        {{ $stats['total_associations'] }}
                    </div>
                    <div class="text-gray-500 mt-1">Associations</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-3xl font-bold text-yellow-600">
                        {{ $stats['en_attente'] }}
                    </div>
                    <div class="text-gray-500 mt-1">En attente</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-3xl font-bold text-purple-600">
                        {{ $stats['validees'] }}
                    </div>
                    <div class="text-gray-500 mt-1">Validées</div>
                </div>
            </div>

            <!-- Associations en attente -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Associations en attente de validation
                    ({{ $associations_en_attente->count() }})
                </h3>

                @if($associations_en_attente->isEmpty())
                    <p class="text-gray-500 text-center py-4">
                        Aucune association en attente ! ✅
                    </p>
                @else
                    <div class="space-y-4">
                        @foreach($associations_en_attente as $association)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">
                                            {{ $association->name }}
                                        </h4>
                                        <p class="text-sm text-gray-500">
                                            {{ $association->region }} —
                                            {{ ucfirst($association->category) }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ Str::limit($association->description, 100) }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            Soumis par : {{ $association->user->name }}
                                            ({{ $association->user->email }})
                                        </p>
                                    </div>

                                    <div class="flex gap-2 ml-4">
                                        <!-- Valider -->
                                        <form method="POST"
                                            action="{{ route('admin.associations.valider', $association) }}">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                                ✅ Valider
                                            </button>
                                        </form>

                                        <!-- Rejeter -->
                                        <form method="POST"
                                            action="{{ route('admin.associations.rejeter', $association) }}"
                                            class="flex gap-2">
                                            @csrf
                                            <input type="text" name="rejection_reason"
                                                placeholder="Motif du rejet..."
                                                class="border border-gray-300 rounded px-2 py-1 text-sm w-48"
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

        </div>
    </div>
</x-app-layout>
