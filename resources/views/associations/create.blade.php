<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer mon profil association') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-8">

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('associations.store') }}">
                    @csrf

                    <!-- Nom -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nom de l\'association')" />
                        <x-text-input id="name" name="name" type="text"
                            class="mt-1 block w-full"
                            :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            rows="4" required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Catégorie -->
                    <div class="mb-4">
                        <x-input-label for="category" :value="__('Catégorie')" />
                        <select name="category" id="category"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="enfants">Enfants</option>
                            <option value="education">Éducation</option>
                            <option value="sante">Santé</option>
                            <option value="alimentation">Alimentation</option>
                            <option value="environnement">Environnement</option>
                            <option value="autre">Autre</option>
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <!-- Région -->
                    <div class="mb-4">
                        <x-input-label for="region" :value="__('Région / Gouvernorat')" />
                        <select name="region" id="region"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="Tunis">Tunis</option>
                            <option value="Sfax">Sfax</option>
                            <option value="Sousse">Sousse</option>
                            <option value="Kairouan">Kairouan</option>
                            <option value="Bizerte">Bizerte</option>
                            <option value="Gabès">Gabès</option>
                            <option value="Ariana">Ariana</option>
                            <option value="Gafsa">Gafsa</option>
                            <option value="Monastir">Monastir</option>
                            <option value="Ben Arous">Ben Arous</option>
                            <option value="Kasserine">Kasserine</option>
                            <option value="Médenine">Médenine</option>
                            <option value="Nabeul">Nabeul</option>
                            <option value="Tataouine">Tataouine</option>
                            <option value="Beja">Béja</option>
                            <option value="Jendouba">Jendouba</option>
                            <option value="Zaghouan">Zaghouan</option>
                            <option value="Siliana">Siliana</option>
                            <option value="Kef">Kef</option>
                            <option value="Mahdia">Mahdia</option>
                            <option value="Sidi Bouzid">Sidi Bouzid</option>
                            <option value="Tozeur">Tozeur</option>
                            <option value="Kebili">Kébili</option>
                            <option value="Manouba">Manouba</option>
                        </select>
                        <x-input-error :messages="$errors->get('region')" class="mt-2" />
                    </div>

                    <!-- Site web -->
                    <div class="mb-4">
                        <x-input-label for="website" :value="__('Site web (optionnel)')" />
                        <x-text-input id="website" name="website" type="url"
                            class="mt-1 block w-full"
                            :value="old('website')" />
                        <x-input-error :messages="$errors->get('website')" class="mt-2" />
                    </div>

                    <!-- Facebook -->
                    <div class="mb-4">
                        <x-input-label for="facebook" :value="__('Page Facebook (optionnel)')" />
                        <x-text-input id="facebook" name="facebook" type="url"
                            class="mt-1 block w-full"
                            :value="old('facebook')" />
                        <x-input-error :messages="$errors->get('facebook')" class="mt-2" />
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('associations.index') }}"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-3 hover:bg-gray-300">
                            Annuler
                        </a>
                        <x-primary-button>
                            {{ __('Soumettre pour validation') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
