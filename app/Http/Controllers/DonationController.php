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

        if ($request->type === 'financier') {
            $request->validate([
                'amount' => ['required', 'numeric', 'min:1'],
            ]);
            $data['amount'] = $request->amount;
            $campaign->increment('current_amount', $request->amount);
        }

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

        // Notifier le donateur
        NotificationHelper::donEffectue(
            Auth::id(),
            $campaign->title,
            $request->type
        );

        // Notifier l'association
        $association = $campaign->association;
        NotificationHelper::send(
            $association->user_id,
            '💰 Nouveau don reçu !',
            "Vous avez reçu un don ({$request->type}) pour votre campagne \"{$campaign->title}\".",
            'don',
            '/dashboard'
        );

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Don effectué avec succès ! Merci pour votre générosité !');
    }

    public function historique()
    {
        $donations = Donation::where('user_id', Auth::id())
            ->with('campaign')
            ->latest()
            ->paginate(10);

        return view('donations.historique', compact('donations'));
    }
}
