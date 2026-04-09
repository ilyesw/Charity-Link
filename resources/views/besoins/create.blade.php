<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-800">
            Déclarer un besoin d'aide
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Sans inscription — Nous vous mettrons en contact avec une association
        </p>
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

    <form method="POST" action="{{ route('besoins.store') }}">
        @csrf

        <!-- Nom -->
        <div>
            <x-input-label for="nom" :value="__('Votre nom')" />
            <x-text-input id="nom" name="nom" type="text"
                class="block mt-1 w-full"
                :value="old('nom')" required />
            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email"
                class="block mt-1 w-full"
                :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Téléphone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Téléphone (optionnel)')" />
            <x-text-input id="phone" name="phone" type="text"
                class="block mt-1 w-full"
                :value="old('phone')" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Catégorie -->
        <div class="mt-4">
            <x-input-label for="categorie" :value="__('Type de besoin')" />
            <select name="categorie" id="categorie"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="alimentation">Alimentation</option>
                <option value="sante">Santé</option>
                <option value="education">Éducation</option>
                <option value="logement">Logement</option>
                <option value="autre">Autre</option>
            </select>
            <x-input-error :messages="$errors->get('categorie')" class="mt-2" />
        </div>

        <!-- Région -->
        <div class="mt-4">
            <x-input-label for="region" :value="__('Région')" />
            <select name="region" id="region"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="Tunis">Tunis</option>
                <option value="Sfax">Sfax</option>
                <option value="Sousse">Sousse</option>
                <option value="Kairouan">Kairouan</option>
                <option value="Bizerte">Bizerte</option>
                <option value="Gabès">Gabès</option>
                <option value="Ariana">Ariana</option>
                <option value="Monastir">Monastir</option>
                <option value="Nabeul">Nabeul</option>
                <option value="Autre">Autre</option>
            </select>
            <x-input-error :messages="$errors->get('region')" class="mt-2" />
        </div>

        <!-- Urgence -->
        <div class="mt-4">
            <x-input-label for="urgence" :value="__('Niveau d\'urgence')" />
            <select name="urgence" id="urgence"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="normale">Normale</option>
                <option value="urgente">Urgente</option>
                <option value="critique">Critique</option>
            </select>
            <x-input-error :messages="$errors->get('urgence')" class="mt-2" />
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Description de votre besoin')" />
            <textarea id="description" name="description"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                rows="4" required>{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                {{ __('Soumettre ma demande') }}
            </x-primary-button>
        </div>

    </form>
</x-guest-layout>
