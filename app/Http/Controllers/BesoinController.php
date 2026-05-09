<?php

namespace App\Http\Controllers;

use App\Models\Besoin;
use App\Models\Association;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BesoinController extends Controller
{
    // ✅ Liste publique — Feature 1 : seulement les besoins validés
    public function index()
    {
        $besoins = Besoin::with('association')
            ->valides()   // ← uniquement status: validee, pris_en_charge, resolu
            ->latest()
            ->paginate(12);

        return view('besoins.index', compact('besoins'));
    }

    // Formulaire déclaration besoin
    public function create()
    {
        return view('besoins.create');
    }

    // ✅ Sauvegarder le besoin (Features 2 + 3)
    public function store(Request $request)
    {
        $request->validate([
            'nom'          => ['required', 'string', 'max:255'],
            'email'        => ['nullable', 'email', 'max:255'],          // ← optionnel
            'phone'        => ['required', 'string', 'max:20'],          // ← obligatoire
            'categorie'    => ['required', 'in:alimentation,sante,education,logement,autre'],
            'description'  => ['required', 'string'],
            'region'       => ['required', 'string'],
            'urgence'      => ['required', 'in:normale,urgente,critique'],
            'is_anonymous' => ['nullable', 'boolean'],
            // ✅ Feature 3 : pièce jointe obligatoire
            'attachment'   => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
        ]);

        // ✅ Feature 3 : upload fichier
        $attachmentPath = $request->file('attachment')
            ->store('besoins/attachments', 'public');

        Besoin::create([
            'nom'          => $request->nom,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'categorie'    => $request->categorie,
            'description'  => $request->description,
            'region'       => $request->region,
            'urgence'      => $request->urgence,
            'is_anonymous' => $request->boolean('is_anonymous'), // ✅ Feature 2
            'attachment'   => $attachmentPath,                   // ✅ Feature 3
            'status'       => 'en_attente',                      // ✅ Feature 1 : en attente de validation
        ]);

        // Notifier les admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                '🔔 Nouveau besoin à valider',
                "Un internaute a soumis un nouveau besoin. En attente de validation.",
                'besoin',
                '/admin'
            );
        }

        return redirect()->route('besoins.confirmation')
            ->with('success', 'Votre demande a été soumise ! Elle sera visible après validation.');
    }

    // Page confirmation
    public function confirmation()
    {
        return view('besoins.confirmation');
    }

    // ✅ Feature 1 : Admin valide un besoin
    public function valider(Besoin $besoin)
    {
        if ($besoin->status !== 'en_attente') {
            return redirect()->back()->with('error', 'Ce besoin a déjà été traité.');
        }

        $besoin->update(['status' => 'validee']);

        return redirect()->back()
            ->with('success', 'Besoin validé et maintenant visible publiquement !');
    }

    // ✅ Feature 1 : Admin rejette un besoin
    public function rejeter(Request $request, Besoin $besoin)
    {
        // Supprimer l'attachment si existe
        if ($besoin->attachment) {
            Storage::disk('public')->delete($besoin->attachment);
        }

        $besoin->delete();

        return redirect()->back()
            ->with('success', 'Besoin rejeté et supprimé.');
    }

    // ✅ Association prend en charge un besoin
    public function prendreEnCharge(Besoin $besoin)
    {
        $association = Association::where('user_id', auth()->id())
            ->where('status', 'validee')
            ->first();

        if (!$association) {
            return redirect()->back()
                ->with('error', 'Votre association doit être validée.');
        }

        if (!in_array($besoin->status, ['en_attente', 'validee'])) {
            return redirect()->back()
                ->with('error', 'Ce besoin est déjà pris en charge.');
        }

        $besoin->update([
            'association_id' => $association->id,
            'status'         => 'pris_en_charge',
        ]);

        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                '✅ Besoin pris en charge',
                "L'association {$association->name} a pris en charge le besoin de {$besoin->nom}.",
                'besoin',
                '/admin'
            );
        }

        return redirect()->route('besoins.index')
            ->with('success', 'Vous avez pris en charge ce besoin !');
    }

    // ✅ Admin assigne un besoin à une association
    public function assigner(Request $request, Besoin $besoin)
    {
        $request->validate([
            'association_id' => ['required', 'exists:associations,id'],
            'admin_note'     => ['nullable', 'string'],
        ]);

        $besoin->update([
            'association_id' => $request->association_id,
            'admin_note'     => $request->admin_note,
            'status'         => 'pris_en_charge',
        ]);

        return redirect()->route('admin.index')
            ->with('success', 'Besoin assigné avec succès !');
    }
}
