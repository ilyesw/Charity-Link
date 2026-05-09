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
    public function index()
    {
        $campaigns = Campaign::active()
            ->with(['association', 'ratings'])
            ->latest()
            ->paginate(12);
        return view('campaigns.index', compact('campaigns'));
    }

    // ===================== DÉTAIL + TRANSPARENCE =====================
    public function show(Campaign $campaign)
    {
        $campaign->load([
            'association', 'photos', 'ratings.user',
            'transactions' => fn($q) => $q->orderBy('date_transaction', 'desc'),
            'taches',
            'donations' => fn($q) => $q->latest(),
        ]);

        $totalEntrees = $campaign->totalEntrees();
        $totalSorties = $campaign->totalSorties();
        $solde        = $campaign->solde();
        $avgRating    = $campaign->averageRating();

        // Note de l'utilisateur connecté (si connecté)
        $userRating = null;
        if (Auth::check()) {
            $userRating = $campaign->ratings()->where('user_id', Auth::id())->first();
        }

        return view('campaigns.show', compact(
            'campaign', 'totalEntrees', 'totalSorties',
            'solde', 'avgRating', 'userRating'
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

    public function update(Request $request, Campaign $campaign)
    {
        if ($campaign->association->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title'                => ['required', 'string', 'max:255'],
            'nature'               => ['required', 'string', 'max:255'],
            'description'          => ['required', 'string'],
            'affiche'              => ['nullable', 'image', 'max:2048'],
            'goal_amount'          => ['nullable', 'numeric', 'min:0'],
            'objectif_description' => ['nullable', 'string', 'max:255'],
            'date_debut'           => ['nullable', 'date'],
            'deadline'             => ['nullable', 'date'],
            'status'               => ['required', 'in:active,terminee,suspendue'],
            'compte_rendu'         => ['nullable', 'string'],
            'photos.*'             => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'title'                => $request->title,
            'nature'               => $request->nature,
            'description'          => $request->description,
            'goal_amount'          => $request->goal_amount,
            'objectif_description' => $request->objectif_description,
            'date_debut'           => $request->date_debut,
            'deadline'             => $request->deadline,
            'status'               => $request->status,
            'compte_rendu'         => $request->compte_rendu,
        ];

        // Nouvelle affiche
        if ($request->hasFile('affiche')) {
            if ($campaign->affiche) Storage::disk('public')->delete($campaign->affiche);
            $data['affiche'] = $request->file('affiche')->store('campaigns/affiches', 'public');
        }

        $campaign->update($data);

        // Nouvelles photos galerie
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
            ->with('success', 'Campagne mise à jour !');
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
}
