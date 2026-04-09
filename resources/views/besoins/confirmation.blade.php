<x-guest-layout>
    <div class="text-center">

        <div class="text-6xl mb-4">✅</div>

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Demande soumise avec succès !
        </h2>

        <p class="text-gray-600 mb-6">
            Votre demande d'aide a été reçue. Notre équipe va l'analyser
            et vous mettre en contact avec une association compétente
            dans les plus brefs délais.
        </p>

        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 text-left">
            <h3 class="font-semibold text-green-800 mb-2">Prochaines étapes :</h3>
            <ul class="text-sm text-green-700 space-y-1">
                <li>✓ Votre demande est enregistrée</li>
                <li>✓ Un administrateur va l'examiner</li>
                <li>✓ Une association sera contactée</li>
                <li>✓ Vous recevrez un email de suivi</li>
            </ul>
        </div>

        <div class="space-y-3">
            <a href="{{ route('associations.index') }}"
                class="block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                Voir les associations
            </a>
            <a href="{{ route('campaigns.index') }}"
                class="block bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300">
                Voir les campagnes
            </a>
        </div>

    </div>
</x-guest-layout>
