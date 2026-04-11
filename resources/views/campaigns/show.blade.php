<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $campaign->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-8">

                <!-- Association -->
                <p class="text-sm text-gray-500 mb-4">
                    Par : <a href="{{ route('associations.show', $campaign->association) }}"
                        class="text-blue-600 hover:underline">
                        {{ $campaign->association->name }}
                    </a>
                </p>

                <!-- Description -->
                <p class="text-gray-600 leading-relaxed mb-6">
                    {{ $campaign->description }}
                </p>

                <!-- Barre progression -->
                <div class="mb-6">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>
                            <strong>{{ number_format($campaign->current_amount, 2) }} DT</strong>
                            collectés
                        </span>
                        <span>{{ $campaign->progressPercentage() }}%</span>
                        <span>
                            Objectif :
                            <strong>{{ number_format($campaign->goal_amount, 2) }} DT</strong>
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-blue-600 h-4 rounded-full transition-all"
                            style="width: {{ $campaign->progressPercentage() }}%">
                        </div>
                    </div>
                </div>

                <!-- Deadline -->
                @if($campaign->deadline)
                    <p class="text-sm text-gray-500 mb-6">
                        Date limite : {{ $campaign->deadline->format('d/m/Y') }}
                    </p>
                @endif

                <!-- Bouton Don -->
                @auth
                    @if(auth()->user()->isDonateur())
                        <a href="{{ route('donations.create', $campaign) }}"
                            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 inline-block mb-4">
                            💚 Faire un don
                        </a>
                    @endif
                @endauth

                <!-- Retour -->
                <div class="mt-4">
                    <a href="{{ route('campaigns.index') }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        ← Retour aux campagnes
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
