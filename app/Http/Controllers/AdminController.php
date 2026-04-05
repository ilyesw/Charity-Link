<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard Admin
    public function index()
    {
        $stats = [
            'total_users'        => User::count(),
            'total_associations' => Association::count(),
            'en_attente'         => Association::where('status', 'en_attente')->count(),
            'validees'           => Association::where('status', 'validee')->count(),
        ];

        $associations_en_attente = Association::where('status', 'en_attente')
            ->with('user')
            ->latest()
            ->get();

        return view('admin.index', compact('stats', 'associations_en_attente'));
    }

    // Valider une association
    public function validerAssociation(Association $association)
    {
        $association->update(['status' => 'validee']);

        return redirect()->route('admin.index')
            ->with('success', 'Association validée avec succès !');
    }

    // Rejeter une association
    public function rejeterAssociation(Request $request, Association $association)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        $association->update([
            'status'           => 'rejetee',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.index')
            ->with('success', 'Association rejetée.');
    }
}
