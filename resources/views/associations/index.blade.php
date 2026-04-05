<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Associations') }}
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
                    Associations validées ({{ $associations->total() }})
                </h3>
                @auth
                    @if(auth()->user()->isAssociation())
                        <a href="{{ route('associations.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            + Créer mon profil association
                        </a>
                    @endif
                @endauth
            </div>

            @if($associations->isEmpty())
                <div class="bg-white p-8 rounded shadow text-center text-gray-500">
                    Aucune association validée pour le moment.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($associations as $association)
                        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-blue-600 font-bold text-lg">
                                        {{ strtoupper(substr($association->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">
                                        {{ $association->name }}
                                    </h4>
                                    <span class="text-xs text-gray-500">
                                        {{ $association->region }}
                                    </span>
                                </div>
                            </div>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ Str::limit($association->description, 100) }}
                            </p>

                            <div class="flex justify-between items-center">
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                    {{ ucfirst($association->category) }}
                                </span>
                                <a href="{{ route('associations.show', $association) }}"
                                    class="text-blue-600 hover:underline text-sm">
                                    Voir plus →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $associations->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
