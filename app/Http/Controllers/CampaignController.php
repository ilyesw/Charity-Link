<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    // Liste des campagnes
    public function index()
    {
        $campaigns = Campaign::active()
            ->with('association')
            ->latest()
            ->paginate(12);

        return view('campaigns.index', compact('campaigns'));
    }

    // Détail d'une campagne
    public function show(Campaign $campaign)
    {
        return view('campaigns.show', compact('campaign'));
    }

    // Formulaire création campagne
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

    // Sauvegarder la campagne
    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'goal_amount' => ['required', 'numeric', 'min:1'],
            'deadline'    => ['nullable', 'date', 'after:today'],
        ]);

        $association = Association::where('user_id', Auth::id())
            ->where('status', 'validee')
            ->firstOrFail();

        Campaign::create([
            'association_id' => $association->id,
            'title'          => $request->title,
            'description'    => $request->description,
            'goal_amount'    => $request->goal_amount,
            'deadline'       => $request->deadline,
            'status'         => 'active',
        ]);

        return redirect()->route('campaigns.index')
            ->with('success', 'Campagne publiée avec succès !');
    }
}
