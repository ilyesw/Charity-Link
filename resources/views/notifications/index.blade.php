<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Mes notifications ({{ $notifications->total() }})
                </h3>

                @if($notifications->isEmpty())
                    <div class="text-center text-gray-500 py-8">
                        <div class="text-4xl mb-3">🔔</div>
                        <p>Aucune notification pour le moment.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($notifications as $notification)
                            <div class="border rounded-lg p-4
                                {{ $notification->is_read
                                    ? 'border-gray-200 bg-white'
                                    : 'border-blue-200 bg-blue-50' }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">
                                            {{ $notification->title }}
                                        </h4>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $notification->message }}
                                        </p>
                                        @if($notification->url)
                                            <a href="{{ $notification->url }}"
                                                class="text-blue-600 hover:underline text-xs mt-1 inline-block">
                                                Voir →
                                            </a>
                                        @endif
                                    </div>
                                    <div class="text-right ml-4">
                                        <span class="text-xs px-2 py-1 rounded
                                            {{ $notification->type === 'don' ? 'bg-green-100 text-green-800' :
                                               ($notification->type === 'validation' ? 'bg-blue-100 text-blue-800' :
                                               ($notification->type === 'tache' ? 'bg-purple-100 text-purple-800' :
                                               'bg-gray-100 text-gray-600')) }}">
                                            {{ ucfirst($notification->type) }}
                                        </span>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
