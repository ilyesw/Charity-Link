<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class AdminController extends Controller
{
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

    public function validerAssociation(Association $association)
    {
        $association->update(['status' => 'validee']);

        // Notifier l'association
        NotificationHelper::associationValidee(
            $association->user_id,
            $association->name
        );

        return redirect()->route('admin.index')
            ->with('success', 'Association validée avec succès !');
    }

    public function rejeterAssociation(Request $request, Association $association)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        $association->update([
            'status'           => 'rejetee',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Notifier l'association
        NotificationHelper::associationRejetee(
            $association->user_id,
            $association->name
        );

        return redirect()->route('admin.index')
            ->with('success', 'Association rejetée.');
    }
}
