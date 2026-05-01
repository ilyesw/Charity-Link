<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::active()
            ->with('association')
            ->latest()
            ->paginate(12);

        return view('campaigns.index', compact('campaigns'));
    }

    public function show(Campaign $campaign)
    {
        return view('campaigns.show', compact('campaign'));
    }

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

    // ✅ NOUVEAU — Edit
    public function edit(Campaign $campaign)
    {
        if ($campaign->association->user_id !== Auth::id()) {
            abort(403);
        }
        return view('campaigns.edit', compact('campaign'));
    }

    // ✅ NOUVEAU — Update
    public function update(Request $request, Campaign $campaign)
    {
        if ($campaign->association->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'goal_amount' => ['required', 'numeric', 'min:1'],
            'deadline'    => ['nullable', 'date'],
            'status'      => ['required', 'in:active,terminee,suspendue'],
        ]);

        $campaign->update([
            'title'       => $request->title,
            'description' => $request->description,
            'goal_amount' => $request->goal_amount,
            'deadline'    => $request->deadline,
            'status'      => $request->status,
        ]);

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Campagne mise à jour !');
    }

    // ✅ NOUVEAU — Destroy
    public function destroy(Campaign $campaign)
    {
        if ($campaign->association->user_id !== Auth::id()) {
            abort(403);
        }

        $campaign->delete();

        return redirect()->route('campaigns.index')
            ->with('success', 'Campagne supprimée.');
    }
}
