<?php

namespace App\Http\Controllers;

use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;

class AssociationController extends Controller
{
    // Liste des associations validées
    public function index()
    {
        $associations = Association::validees()
            ->with('user')
            ->paginate(12);

        return view('associations.index', compact('associations'));
    }

    // Profil d'une association
    public function show(Association $association)
    {
        return view('associations.show', compact('association'));
    }

    // Formulaire création profil association
    public function create()
    {
        return view('associations.create');
    }

    // Sauvegarder le profil association
    public function store(Request $request)
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'category'     => ['required', 'in:enfants,education,sante,alimentation,environnement,autre'],
            'region'       => ['required', 'string', 'max:100'],
            'phone_mobile' => ['required', 'string', 'max:20'],
            'phone_fix'    => ['nullable', 'string', 'max:20'],
            'email'        => ['required', 'email', 'max:255'],
            'logo'         => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'doc_rne'      => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'doc_fiscal'   => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'website'      => ['nullable', 'url'],
            'facebook'     => ['nullable', 'url'],
        ]);

        $logoPath    = $request->file('logo')->store('associations/logos', 'public');
        $docRnePath  = $request->file('doc_rne')->store('associations/documents', 'public');
        $docFiscPath = $request->file('doc_fiscal')->store('associations/documents', 'public');

        Association::create([
            'user_id'      => Auth::id(),
            'name'         => $request->name,
            'description'  => $request->description,
            'category'     => $request->category,
            'region'       => $request->region,
            'phone_mobile' => $request->phone_mobile,
            'phone_fix'    => $request->phone_fix,
            'email'        => $request->email,
            'logo'         => $logoPath,
            'doc_rne'      => $docRnePath,
            'doc_fiscal'   => $docFiscPath,
            'website'      => $request->website,
            'facebook'     => $request->facebook,
            'status'       => 'en_attente',
        ]);
        NotificationHelper::associationSoumise(1, $request->name);

        return redirect()->route('associations.index')
            ->with('success', 'Votre profil association a été soumis pour validation !');
    }

    // Formulaire modification
    public function edit(Association $association)
    {
        if ($association->user_id !== Auth::id()) {
            abort(403);
        }
        return view('associations.edit', compact('association'));
    }

    // Sauvegarder modification
    public function update(Request $request, Association $association)
    {
        if ($association->user_id !== Auth::id()) abort(403);

        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'category'     => ['required', 'in:enfants,education,sante,alimentation,environnement,autre'],
            'region'       => ['required', 'string'],
            'phone_mobile' => ['required', 'string', 'max:20'],
            'phone_fix'    => ['nullable', 'string', 'max:20'],
            'email'        => ['required', 'email', 'max:255'],
            'logo'         => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'doc_rne'      => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'doc_fiscal'   => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'website'      => ['nullable', 'url'],
            'facebook'     => ['nullable', 'url'],
        ]);

        $data = [
            'name'         => $request->name,
            'description'  => $request->description,
            'category'     => $request->category,
            'region'       => $request->region,
            'phone_mobile' => $request->phone_mobile,
            'phone_fix'    => $request->phone_fix,
            'email'        => $request->email,
            'website'      => $request->website,
            'facebook'     => $request->facebook,
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('associations/logos', 'public');
        }
        if ($request->hasFile('doc_rne')) {
            $data['doc_rne'] = $request->file('doc_rne')->store('associations/documents', 'public');
        }
        if ($request->hasFile('doc_fiscal')) {
            $data['doc_fiscal'] = $request->file('doc_fiscal')->store('associations/documents', 'public');
        }

        $association->update($data);

        return redirect()->route('associations.show', $association)
            ->with('success', 'Association mise à jour avec succès !');
    }

    // Supprimer association
    public function destroy(Association $association)
    {
        if ($association->user_id !== Auth::id()) {
            abort(403);
        }

        $association->delete();

        return redirect()->route('associations.index')
            ->with('success', 'Association supprimée.');
    }
}
