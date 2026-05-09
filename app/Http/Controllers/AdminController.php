<?php
namespace App\Http\Controllers;
use App\Models\Association;
use App\Models\Besoin;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Storage;
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
            // ✅ Stats besoins
            'besoins_en_attente' => Besoin::where('status', 'en_attente')->count(),
            'besoins_valides'    => Besoin::where('status', 'validee')->count(),
        ];

        $associations_en_attente = Association::where('status', 'en_attente')
            ->with('user')
            ->latest()
            ->get();

        // ✅ Feature 1 : Besoins en attente de validation
        $besoins_en_attente = Besoin::where('status', 'en_attente')
            ->latest()
            ->get();

        return view('admin.index', compact('stats', 'associations_en_attente', 'besoins_en_attente'));
    }

    public function validerAssociation(Association $association)
    {
        $association->update(['status' => 'validee']);
        NotificationHelper::associationValidee($association->user_id, $association->name);
        return redirect()->route('admin.index')->with('success', 'Association validée avec succès !');
    }

    public function rejeterAssociation(Request $request, Association $association)
    {
        $request->validate(['rejection_reason' => ['required', 'string', 'max:500']]);
        $association->update(['status' => 'rejetee', 'rejection_reason' => $request->rejection_reason]);
        NotificationHelper::associationRejetee($association->user_id, $association->name);
        return redirect()->route('admin.index')->with('success', 'Association rejetée.');
    }

    // ✅ Feature 1 : Valider un besoin
    public function validerBesoin(Besoin $besoin)
    {
        $besoin->update(['status' => 'validee']);
        return redirect()->route('admin.index')
            ->with('success', 'Besoin validé et maintenant visible publiquement !');
    }

    // ✅ Feature 1 : Rejeter (supprimer) un besoin
    public function rejeterBesoin(Besoin $besoin)
    {
        if ($besoin->attachment) {
            Storage::disk('public')->delete($besoin->attachment);
        }
        $besoin->delete();
        return redirect()->route('admin.index')->with('success', 'Besoin rejeté et supprimé.');
    }
}
