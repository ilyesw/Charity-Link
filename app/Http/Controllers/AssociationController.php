<?php

namespace App\Http\Controllers;

use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category'    => ['required', 'in:enfants,education,sante,alimentation,environnement,autre'],
            'region'      => ['required', 'string', 'max:100'],
            'website'     => ['nullable', 'url'],
            'facebook'    => ['nullable', 'url'],
        ]);

        Association::create([
            'user_id'     => Auth::id(),
            'name'        => $request->name,
            'description' => $request->description,
            'category'    => $request->category,
            'region'      => $request->region,
            'website'     => $request->website,
            'facebook'    => $request->facebook,
            'status'      => 'en_attente',
        ]);

        return redirect()->route('associations.index')
            ->with('success', 'Votre profil association a été soumis pour validation !');
    }
}
