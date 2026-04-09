<?php

namespace App\Http\Controllers;

use App\Models\Besoin;
use Illuminate\Http\Request;

class BesoinController extends Controller
{
    // Formulaire déclaration besoin
    public function create()
    {
        return view('besoins.create');
    }

    // Sauvegarder le besoin
    public function store(Request $request)
    {
        $request->validate([
            'nom'         => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'categorie'   => ['required', 'in:alimentation,sante,education,logement,autre'],
            'description' => ['required', 'string'],
            'region'      => ['required', 'string'],
            'urgence'     => ['required', 'in:normale,urgente,critique'],
        ]);

        Besoin::create([
            'nom'         => $request->nom,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'categorie'   => $request->categorie,
            'description' => $request->description,
            'region'      => $request->region,
            'urgence'     => $request->urgence,
            'status'      => 'en_attente',
        ]);

        return redirect()->route('besoins.confirmation')
            ->with('success', 'Votre demande a été soumise avec succès !');
    }

    // Page confirmation
    public function confirmation()
    {
        return view('besoins.confirmation');
    }
}
