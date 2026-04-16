<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer une tâche bénévole') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-8">

                <p class="text-sm text-gray-500 mb-6">
                    Association : <strong>{{ $association->name }}</strong>
                </p>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('taches.store') }}">
                    @csrf

                    <!-- Titre -->
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Titre de la tâche')" />
                        <x-text-input id="title" name="title" type="text"
                            class="mt-1 block w-full"
                            :value="old('title')" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            rows="4" required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Compétence requise -->
                    <div class="mb-4">
                        <x-input-label for="competence_requise"
                            :value="__('Compétence requise')" />
                        <x-text-input id="competence_requise" name="competence_requise"
                            type="text" class="mt-1 block w-full"
                            placeholder="Ex: Médecin, Professeur, Développeur..."
                            :value="old('competence_requise')" required />
                        <x-input-error :messages="$errors->get('competence_requise')" class="mt-2" />
                    </div>

                    <!-- Deadline -->
                    <div class="mb-4">
                        <x-input-label for="deadline" :value="__('Date limite (optionnel)')" />
                        <x-text-input id="deadline" name="deadline" type="date"
                            class="mt-1 block w-full"
                            :value="old('deadline')" />
                        <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('taches.index') }}"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-3 hover:bg-gray-300">
                            Annuler
                        </a>
                        <x-primary-button>
                            {{ __('Créer la tâche') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
