<?php
namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Association;
use App\Models\CampaignPhoto;
use App\Models\CampaignTransaction;
use App\Models\CampaignRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    // ===================== LISTE PUBLIQUE =====================
// ✅ Méthode index() — remplace l'ancienne dans CampaignController.php

    public function index()
    {
        $campaigns = Campaign::active()
            ->with('association')
            ->withAvg('ratings', 'note')   // ← moyenne des notes
            ->withCount('ratings')          // ← nombre d'avis
            ->latest()
            ->paginate(12);

        return view('campaigns.index', compact('campaigns'));
    }

    // ===================== DÉTAIL + TRANSPARENCE =====================

    // ════════════════════════════════════════════════
    // 2. CampaignController — remplace la méthode show()
    //    (charge les tâches liées à la campagne)
    // ════════════════════════════════════════════════

    public function show(Campaign $campaign)
    {
        $campaign->load([
            'photos',
            'transactions' => fn($q) => $q->orderBy('date_transaction', 'desc'),
            'ratings',
            'taches.benevole',   // ← nouveau : tâches avec le bénévole assigné
        ]);

        $totalEntrees = $campaign->transactions->where('type', 'entree')->sum('montant');
        $totalSorties = $campaign->transactions->where('type', 'sortie')->sum('montant');
        $solde        = $totalEntrees - $totalSorties;

        $avgRating  = $campaign->ratings->avg('note')
                    ? round($campaign->ratings->avg('note'), 1)
                    : null;
        $userRating = auth()->check()
                    ? $campaign->ratings->where('user_id', auth()->id())->first()
                    : null;

        return view('campaigns.show', compact(
            'campaign',
            'totalEntrees',
            'totalSorties',
            'solde',
            'avgRating',
            'userRating'
        ));
    }
    // ===================== CRÉER =====================
    public function create()
    {
        $association = Association::where('user_id', Auth::id())
            ->where('status', 'validee')
            ->first();
        if (!$association) {
            return redirect()->route('associations.index')
                ->with('error', 'Votre association doit être validée pour publier une campagne.');
        }
        return view('campaigns.create', compact('association'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'                => ['required', 'string', 'max:255'],
            'nature'               => ['required', 'string', 'max:255'],
            'description'          => ['required', 'string'],
            'affiche'              => ['required', 'image', 'max:2048'],
            'goal_amount'          => ['nullable', 'numeric', 'min:0'],
            'objectif_description' => ['nullable', 'string', 'max:255'],
            'date_debut'           => ['nullable', 'date'],
            'deadline'             => ['nullable', 'date', 'after:today'],
            'photos.*'             => ['nullable', 'image', 'max:2048'],
        ]);

        $association = Association::where('user_id', Auth::id())
            ->where('status', 'validee')
            ->firstOrFail();

        // Upload affiche
        $affichePath = $request->file('affiche')->store('campaigns/affiches', 'public');

        $campaign = Campaign::create([
            'association_id'       => $association->id,
            'title'                => $request->title,
            'nature'               => $request->nature,
            'description'          => $request->description,
            'affiche'              => $affichePath,
            'goal_amount'          => $request->goal_amount,
            'objectif_description' => $request->objectif_description,
            'date_debut'           => $request->date_debut,
            'deadline'             => $request->deadline,
            'status'               => 'active',
        ]);

        // Upload photos galerie
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('campaigns/photos', 'public');
                CampaignPhoto::create([
                    'campaign_id' => $campaign->id,
                    'path'        => $path,
                ]);
            }
        }

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Campagne publiée avec succès !');
    }

    // ===================== MODIFIER =====================
    public function edit(Campaign $campaign)
    {
        if ($campaign->association->user_id !== Auth::id()) abort(403);
        return view('campaigns.edit', compact('campaign'));
    }

    // ✅ Méthode update()

    public function update(Request $request, Campaign $campaign)
    {
        if ($campaign->association->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title'                 => ['required', 'string', 'max:255'],
            'description'           => ['required', 'string'],
            'nature'                => ['nullable', 'string', 'max:255'],
            'goal_amount'           => ['nullable', 'numeric', 'min:1'],
            'objectif_description'  => ['nullable', 'string', 'max:500'],
            'date_debut'            => ['nullable', 'date'],
            'deadline'              => ['nullable', 'date'],
            'status'                => ['required', 'in:active,terminee,suspendue'],
            'compte_rendu'          => ['nullable', 'string'],
            'affiche'               => ['nullable', 'image', 'max:5120'],
            'photos.*'              => ['nullable', 'image', 'max:5120'],
        ]);

        $data = [
            'title'                => $request->title,
            'description'          => $request->description,
            'nature'               => $request->nature,
            'goal_amount'          => $request->goal_amount,
            'objectif_description' => $request->objectif_description,
            'date_debut'           => $request->date_debut,
            'deadline'             => $request->deadline,
            'status'               => $request->status,
            'compte_rendu'         => $request->compte_rendu,
        ];

        // Affiche — remplace l'ancienne si nouvelle uploadée
        if ($request->hasFile('affiche')) {
            if ($campaign->affiche) {
                Storage::disk('public')->delete($campaign->affiche);
            }
            $data['affiche'] = $request->file('affiche')->store('campaigns/affiches', 'public');
        }

        $campaign->update($data);

        // Nouvelles photos de galerie
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('campaigns/photos', 'public');
                $campaign->photos()->create(['path' => $path]);
            }
        }

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Campagne mise à jour avec succès !');
    }

        // ===================== SUPPRIMER =====================
        public function destroy(Campaign $campaign)
        {
            if ($campaign->association->user_id !== Auth::id()) abort(403);
            $campaign->delete();
            return redirect()->route('campaigns.index')
                ->with('success', 'Campagne supprimée.');
        }

        // ===================== SUPPRIMER UNE PHOTO =====================
        public function deletePhoto(CampaignPhoto $photo)
        {
            if ($photo->campaign->association->user_id !== Auth::id()) abort(403);
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
            return back()->with('success', 'Photo supprimée.');
        }

    // ===================== TRANSACTIONS (ENTRÉES/SORTIES) =====================
    public function storeTransaction(Request $request, Campaign $campaign)
    {
        if ($campaign->association->user_id !== Auth::id()) abort(403);

        $request->validate([
            'type'             => ['required', 'in:entree,sortie'],
            'description'      => ['required', 'string', 'max:255'],
            'montant'          => ['required', 'numeric', 'min:0'],
            'date_transaction' => ['required', 'date'],
            'justificatif'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        if ($request->type === 'sortie') {
            $totalEntrees = $campaign->transactions()->where('type', 'entree')->sum('montant');
            $totalSorties = $campaign->transactions()->where('type', 'sortie')->sum('montant');
            $soldeActuel  = $totalEntrees - $totalSorties;

            if ($request->montant > $soldeActuel) {
                return back()
                    ->withInput()
                    ->withErrors(['montant' => 'Solde insuffisant ! Solde actuel : ' . number_format($soldeActuel, 2) . ' DT']);
            }
        }

        $justifPath = null;
        if ($request->hasFile('justificatif')) {
            $justifPath = $request->file('justificatif')->store('campaigns/justificatifs', 'public');
        }

        CampaignTransaction::create([
            'campaign_id'      => $campaign->id,
            'type'             => $request->type,
            'description'      => $request->description,
            'montant'          => $request->montant,
            'date_transaction' => $request->date_transaction,
            'justificatif'     => $justifPath,
        ]);

        return back()->with('success', 'Transaction ajoutée !');
    }

    public function deleteTransaction(CampaignTransaction $transaction)
    {
        if ($transaction->campaign->association->user_id !== Auth::id()) abort(403);
        if ($transaction->justificatif) Storage::disk('public')->delete($transaction->justificatif);
        $transaction->delete();
        return back()->with('success', 'Transaction supprimée.');
    }

    // ===================== NOTATION ⭐ =====================
    public function rate(Request $request, Campaign $campaign)
    {
        if (!Auth::check()) return back()->with('error', 'Connectez-vous pour noter.');

        $request->validate([
            'note' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        CampaignRating::updateOrCreate(
            ['campaign_id' => $campaign->id, 'user_id' => Auth::id()],
            ['note' => $request->note]
        );

        return back()->with('success', 'Merci pour votre note !');
    }

    // ══════════════════════════════════════════════════════
    //  transparence méthode
    // ══════════════════════════════════════════════════════

    public function transparence(Campaign $campaign)
    {
        $dons = $campaign->donations()
            ->with('user')
            ->where('status', 'confirme')
            ->latest()
            ->get();

        $taches = $campaign->taches()
            ->with('benevole')
            ->orderByRaw("FIELD(status, 'validee', 'en_cours', 'ouverte')")
            ->get();

        $photos = $campaign->photos ?? collect();

        return view('campaigns.transparence', compact('campaign', 'dons', 'taches', 'photos'));
    }
}
