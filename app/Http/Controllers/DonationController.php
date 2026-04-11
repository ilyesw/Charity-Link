<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    // Formulaire don
    public function create(Campaign $campaign)
    {
        return view('donations.create', compact('campaign'));
    }

    // Sauvegarder le don
    public function store(Request $request, Campaign $campaign)
    {
        $request->validate([
            'type' => ['required', 'in:financier,nature,competences'],
        ]);

        $data = [
            'user_id'     => Auth::id(),
            'campaign_id' => $campaign->id,
            'type'        => $request->type,
            'message'     => $request->message,
            'status'      => 'confirme',
        ];

        // Don financier
        if ($request->type === 'financier') {
            $request->validate([
                'amount' => ['required', 'numeric', 'min:1'],
            ]);
            $data['amount'] = $request->amount;

            // Mise à jour progression campagne
            $campaign->increment('current_amount', $request->amount);
        }

        // Don en nature
        if ($request->type === 'nature') {
            $request->validate([
                'category'       => ['required', 'in:vetements,nourriture,medicaments,scolaire'],
                'quantity'       => ['required', 'integer', 'min:1'],
                'pickup_address' => ['required', 'string'],
            ]);
            $data['category']       = $request->category;
            $data['quantity']       = $request->quantity;
            $data['pickup_address'] = $request->pickup_address;
        }

        // Don de compétences
        if ($request->type === 'competences') {
            $request->validate([
                'competence'      => ['required', 'string', 'max:255'],
                'availability'    => ['required', 'string', 'max:255'],
                'competence_desc' => ['required', 'string'],
            ]);
            $data['competence']      = $request->competence;
            $data['availability']    = $request->availability;
            $data['competence_desc'] = $request->competence_desc;
        }

        Donation::create($data);

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Don effectué avec succès ! Merci pour votre générosité !');
    }

    // Historique des dons
    public function historique()
    {
        $donations = Donation::where('user_id', Auth::id())
            ->with('campaign')
            ->latest()
            ->paginate(10);

        return view('donations.historique', compact('donations'));
    }
}
