<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;

class DonationController extends Controller
{
    public function create(Campaign $campaign)
    {
        return view('donations.create', compact('campaign'));
    }

    public function store(Request $request, Campaign $campaign)
    {
        $request->validate(['type' => ['required', 'in:financier,nature,competences']]);

        $data = [
            'user_id'      => Auth::id(),
            'campaign_id'  => $campaign->id,
            'type'         => $request->type,
            'message'      => $request->message,
            'status'       => 'en_attente',
            'is_anonymous' => $request->boolean('is_anonymous'),
        ];

        if ($request->type === 'financier') {
            $request->validate(['amount' => ['required', 'numeric', 'min:1']]);
            $data['amount'] = $request->amount;
            $campaign->increment('current_amount', $request->amount);
        }

        if ($request->type === 'nature') {
            $request->validate([
                'category'       => ['required', 'in:vetements,nourriture,medicaments,scolaire,autre'],
                'quantity'       => ['required', 'integer', 'min:1'],
                'pickup_address' => ['required', 'string'],
            ]);
            $data['category']         = $request->category;
            $data['quantity']         = $request->quantity;
            $data['pickup_address']   = $request->pickup_address;
            $data['item_description'] = $request->item_description;
        }

        if ($request->type === 'competences') {
            $request->validate([
                'competence'      => ['required', 'string', 'max:255'],
                'availability'    => ['required', 'string', 'max:255'],
                'competence_desc' => ['nullable', 'string'],
            ]);
            $data['competence']      = $request->competence;
            $data['availability']    = $request->availability;
            $data['competence_desc'] = $request->competence_desc;
        }

        Donation::create($data);

        NotificationHelper::donEffectue(Auth::id(), $campaign->title, $request->type);

        $donorLabel = $data['is_anonymous'] ? 'Donateur anonyme' : Auth::user()->name;
        NotificationHelper::send(
            $campaign->association->user_id,
            '💝 Nouveau don reçu !',
            "{$donorLabel} a effectué un don ({$request->type}) pour \"{$campaign->title}\".",
            'don',
            '/dashboard'
        );

        $msg = $data['is_anonymous']
            ? 'Don anonyme enregistré ! Merci pour votre générosité 💝'
            : 'Don effectué avec succès ! Merci pour votre générosité !';

        return redirect()->route('campaigns.show', $campaign)->with('success', $msg);
    }

    public function historique()
    {
        $donations = Donation::where('user_id', Auth::id())
            ->with('campaign')
            ->latest()
            ->paginate(10);

        return view('donations.historique', compact('donations'));
    }

    // ✅ NOUVEAU — Valider un don (association uniquement)
    public function valider(Donation $donation)
    {
        // Vérifier que c'est bien l'association de cette campagne
        if ($donation->campaign->association->user_id !== Auth::id()) {
            abort(403);
        }

        $donation->update(['status' => 'confirme']);

        // Notifier le donateur
        $donorLabel = $donation->is_anonymous ? 'Votre don anonyme' : 'Votre don';
        NotificationHelper::send(
            $donation->user_id,
            '✅ Don confirmé !',
            "{$donorLabel} pour la campagne \"{$donation->campaign->title}\" a été validé par l'association.",
            'don',
            '/donations/historique'
        );

        return redirect()->back()->with('success', 'Don validé avec succès !');
    }

    // ✅ NOUVEAU — Refuser un don (association uniquement)
    public function refuser(Donation $donation)
    {
        // Vérifier que c'est bien l'association de cette campagne
        if ($donation->campaign->association->user_id !== Auth::id()) {
            abort(403);
        }

        // Si don financier → rembourser le montant à la campagne
        if ($donation->type === 'financier' && $donation->amount) {
            $donation->campaign->decrement('current_amount', $donation->amount);
        }

        $donation->update(['status' => 'annule']);

        // Notifier le donateur
        NotificationHelper::send(
            $donation->user_id,
            '❌ Don refusé',
            "Votre don pour la campagne \"{$donation->campaign->title}\" n'a pas pu être accepté par l'association.",
            'don',
            '/donations/historique'
        );

        return redirect()->back()->with('success', 'Don refusé.');
    }
}
