<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campagnes') }}
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
                    Campagnes actives ({{ $campaigns->total() }})
                </h3>
                @auth
                    @if(auth()->user()->isAssociation())
                        <a href="{{ route('campaigns.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            + Publier une campagne
                        </a>
                    @endif
                @endauth
            </div>

            @if($campaigns->isEmpty())
                <div class="bg-white p-8 rounded shadow text-center text-gray-500">
                    Aucune campagne active pour le moment.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($campaigns as $campaign)
                        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                            <h4 class="font-semibold text-gray-800 mb-2">
                                {{ $campaign->title }}
                            </h4>
                            <p class="text-sm text-gray-500 mb-1">
                                {{ $campaign->association->name }}
                            </p>
                            <p class="text-gray-600 text-sm mb-4">
                                {{ Str::limit($campaign->description, 80) }}
                            </p>

                            <!-- Barre de progression -->
                            <div class="mb-2">
                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                    <span>{{ number_format($campaign->current_amount, 2) }} DT</span>
                                    <span>{{ $campaign->progressPercentage() }}%</span>
                                    <span>{{ number_format($campaign->goal_amount, 2) }} DT</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full"
                                        style="width: {{ $campaign->progressPercentage() }}%">
                                    </div>
                                </div>
                            </div>

                            @if($campaign->deadline)
                                <p class="text-xs text-gray-400 mb-3">
                                    Deadline : {{ $campaign->deadline->format('d/m/Y') }}
                                </p>
                            @endif

                            <a href="{{ route('campaigns.show', $campaign) }}"
                                class="text-blue-600 hover:underline text-sm">
                                Voir la campagne →
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $campaigns->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
