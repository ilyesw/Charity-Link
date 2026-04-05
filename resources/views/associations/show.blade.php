<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $association->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-8">

                <!-- Header association -->
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <span class="text-blue-600 font-bold text-2xl">
                            {{ strtoupper(substr($association->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ $association->name }}
                        </h3>
                        <p class="text-gray-500">
                            {{ $association->region }} —
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                {{ ucfirst($association->category) }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 mb-2">Description</h4>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $association->description }}
                    </p>
                </div>

                <!-- Liens -->
                @if($association->website || $association->facebook)
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Liens</h4>
                        @if($association->website)
                            <a href="{{ $association->website }}" target="_blank"
                                class="text-blue-600 hover:underline mr-4">
                                🌐 Site web
                            </a>
                        @endif
                        @if($association->facebook)
                            <a href="{{ $association->facebook }}" target="_blank"
                                class="text-blue-600 hover:underline">
                                📘 Facebook
                            </a>
                        @endif
                    </div>
                @endif

                <!-- Bouton retour -->
                <div class="mt-6">
                    <a href="{{ route('associations.index') }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        ← Retour aux associations
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
