<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nom -->
        <div>
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Téléphone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Téléphone (optionnel)')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text"
                name="phone" :value="old('phone')" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Rôle -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Je suis un(e)')" />
            <select name="role" id="role"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="donateur" {{ old('role') == 'donateur' ? 'selected' : '' }}>
                    Donateur
                </option>
                <option value="association" {{ old('role') == 'association' ? 'selected' : '' }}>
                    Association
                </option>
                <option value="benevole" {{ old('role') == 'benevole' ? 'selected' : '' }}>
                    Bénévole
                </option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Langue -->
        <div class="mt-4">
            <x-input-label for="language" :value="__('Langue préférée')" />
            <select name="language" id="language"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>
                    Français
                </option>
                <option value="ar" {{ old('language') == 'ar' ? 'selected' : '' }}>
                    العربية
                </option>
                <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>
                    English
                </option>
            </select>
            <x-input-error :messages="$errors->get('language')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation mot de passe -->
        <div class="mt-4">
            <x-input-label for="password_confirmation"
                :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                href="{{ route('login') }}">
                {{ __('Déjà inscrit ?') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('S\'inscrire') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
