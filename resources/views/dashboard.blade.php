<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php $user = auth()->user(); @endphp

            {{-- DASHBOARD DONATEUR --}}
            @if($user->isDonateur())
                @include('dashboard.donateur')

            {{-- DASHBOARD ASSOCIATION --}}
            @elseif($user->isAssociation())
                @include('dashboard.association')

            {{-- DASHBOARD ADMIN --}}
            @elseif($user->isAdmin())
                @include('dashboard.admin')

            {{-- DASHBOARD BENEVOLE --}}
            @elseif($user->isBenevole())
                @include('dashboard.benevole')

            {{-- DEFAULT --}}
            @else
                <div class="bg-white p-6 rounded shadow text-center">
                    <p class="text-gray-600">Bienvenue sur Charity-Link !</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
