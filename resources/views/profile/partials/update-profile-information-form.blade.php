<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informations du profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Mettez à jour vos informations personnelles et votre email.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Nom -->
        <div>
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)" required />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Téléphone -->
        <div>
            <x-input-label for="phone" :value="__('Téléphone')" />
            <x-text-input id="phone" name="phone" type="text"
                class="mt-1 block w-full"
                :value="old('phone', $user->phone)" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Rôle (lecture seule) -->
        <div>
            <x-input-label for="role" :value="__('Rôle')" />
            <x-text-input id="role" type="text"
                class="mt-1 block w-full bg-gray-100"
                :value="ucfirst($user->role)" disabled />
        </div>

        <!-- Langue -->
        <div>
            <x-input-label for="language" :value="__('Langue préférée')" />
            <select name="language" id="language"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="fr" {{ $user->language == 'fr' ? 'selected' : '' }}>
                    Français
                </option>
                <option value="ar" {{ $user->language == 'ar' ? 'selected' : '' }}>
                    العربية
                </option>
                <option value="en" {{ $user->language == 'en' ? 'selected' : '' }}>
                    English
                </option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('language')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ __('Sauvegarder') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-gray-600">
                    {{ __('Profil mis à jour avec succès !') }}
                </p>
            @endif
        </div>
    </form>
</section>
