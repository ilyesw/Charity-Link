<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Faire un don') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-8">

                <!-- Info campagne -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-blue-800">
                        {{ $campaign->title }}
                    </h3>
                    <p class="text-sm text-blue-600">
                        {{ $campaign->association->name }}
                    </p>
                    <div class="mt-2">
                        <div class="flex justify-between text-xs text-blue-500 mb-1">
                            <span>{{ number_format($campaign->current_amount, 2) }} DT</span>
                            <span>{{ $campaign->progressPercentage() }}%</span>
                            <span>{{ number_format($campaign->goal_amount, 2) }} DT</span>
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full"
                                style="width: {{ $campaign->progressPercentage() }}%">
                            </div>
                        </div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                    action="{{ route('donations.store', $campaign) }}"
                    id="donation-form">
                    @csrf

                    <!-- Type de don -->
                    <div class="mb-6">
                        <x-input-label :value="__('Type de don')" />
                        <div class="mt-2 grid grid-cols-3 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="financier"
                                    class="sr-only" onchange="showSection(this.value)"
                                    {{ old('type') == 'financier' ? 'checked' : '' }}>
                                <div class="type-card border-2 border-gray-200 rounded-lg p-3 text-center hover:border-blue-500 transition">
                                    <div class="text-2xl">💰</div>
                                    <div class="text-sm font-medium mt-1">Financier</div>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="nature"
                                    class="sr-only" onchange="showSection(this.value)"
                                    {{ old('type') == 'nature' ? 'checked' : '' }}>
                                <div class="type-card border-2 border-gray-200 rounded-lg p-3 text-center hover:border-blue-500 transition">
                                    <div class="text-2xl">👕</div>
                                    <div class="text-sm font-medium mt-1">En nature</div>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="competences"
                                    class="sr-only" onchange="showSection(this.value)"
                                    {{ old('type') == 'competences' ? 'checked' : '' }}>
                                <div class="type-card border-2 border-gray-200 rounded-lg p-3 text-center hover:border-blue-500 transition">
                                    <div class="text-2xl">🧠</div>
                                    <div class="text-sm font-medium mt-1">Compétences</div>
                                </div>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <!-- Section Don Financier -->
                    <div id="section-financier" class="hidden mb-4">
                        <x-input-label for="amount" :value="__('Montant (DT)')" />
                        <x-text-input id="amount" name="amount" type="number"
                            class="mt-1 block w-full"
                            :value="old('amount')" min="1" step="0.01" />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <!-- Section Don en Nature -->
                    <div id="section-nature" class="hidden mb-4 space-y-4">
                        <div>
                            <x-input-label for="category" :value="__('Catégorie')" />
                            <select name="category" id="category"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="vetements">Vêtements</option>
                                <option value="nourriture">Nourriture</option>
                                <option value="medicaments">Médicaments</option>
                                <option value="scolaire">Matériel scolaire</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="quantity" :value="__('Quantité')" />
                            <x-text-input id="quantity" name="quantity" type="number"
                                class="mt-1 block w-full"
                                :value="old('quantity')" min="1" />
                        </div>
                        <div>
                            <x-input-label for="pickup_address" :value="__('Lieu de dépôt')" />
                            <x-text-input id="pickup_address" name="pickup_address" type="text"
                                class="mt-1 block w-full"
                                :value="old('pickup_address')" />
                        </div>
                    </div>

                    <!-- Section Don de Compétences -->
                    <div id="section-competences" class="hidden mb-4 space-y-4">
                        <div>
                            <x-input-label for="competence" :value="__('Votre compétence')" />
                            <x-text-input id="competence" name="competence" type="text"
                                class="mt-1 block w-full"
                                placeholder="Ex: Médecin, Professeur, Développeur..."
                                :value="old('competence')" />
                        </div>
                        <div>
                            <x-input-label for="availability" :value="__('Disponibilité')" />
                            <x-text-input id="availability" name="availability" type="text"
                                class="mt-1 block w-full"
                                placeholder="Ex: Week-ends, Lundi matin..."
                                :value="old('availability')" />
                        </div>
                        <div>
                            <x-input-label for="competence_desc" :value="__('Description de l\'aide')" />
                            <textarea id="competence_desc" name="competence_desc"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                rows="3">{{ old('competence_desc') }}</textarea>
                        </div>
                    </div>

                    <!-- Message optionnel -->
                    <div class="mb-6">
                        <x-input-label for="message" :value="__('Message (optionnel)')" />
                        <textarea id="message" name="message"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            rows="2">{{ old('message') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('campaigns.show', $campaign) }}"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                            Annuler
                        </a>
                        <x-primary-button>
                            {{ __('Confirmer le don') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function showSection(type) {
            document.getElementById('section-financier').classList.add('hidden');
            document.getElementById('section-nature').classList.add('hidden');
            document.getElementById('section-competences').classList.add('hidden');
            document.getElementById('section-' + type).classList.remove('hidden');
        }

        // Restore on page load if old input
        @if(old('type'))
            showSection('{{ old('type') }}');
        @endif
    </script>
</x-app-layout>
