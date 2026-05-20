<?php
namespace App\Http\Controllers;
use App\Models\Association;
use App\Models\Besoin;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
// export fichier
use App\Exports\DonsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'        => User::count(),
            'total_associations' => Association::count(),
            'en_attente'         => Association::where('status', 'en_attente')->count(),
            'validees'           => Association::where('status', 'validee')->count(),
            'besoins_en_attente' => Besoin::where('status', 'en_attente')->count(),
            'besoins_valides'    => Besoin::where('status', 'validee')->count(),
        ];

        // ── Graphique 1 : Dons par mois (6 derniers mois) ──
        $labels = [];
        $donsMois = [];
        $usersMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[]    = $date->translatedFormat('M Y');
            $donsMois[]  = \App\Models\Donation::whereYear('created_at', $date->year)
                                ->whereMonth('created_at', $date->month)->count();
            $usersMois[] = User::whereYear('created_at', $date->year)
                                ->whereMonth('created_at', $date->month)->count();
        }

        // ── Graphique 2 : Répartition par type de don ──
        $donsParType = \App\Models\Donation::selectRaw('COALESCE(type, "autre") as type_label, COUNT(*) as total')
                    ->groupBy('type_label')->pluck('total', 'type_label');

        // ── Graphique 3 : Statut associations ──
        $assocStatuts = [
            'Validées'   => Association::where('status', 'validee')->count(),
            'En attente' => Association::where('status', 'en_attente')->count(),
            'Rejetées'   => Association::where('status', 'rejetee')->count(),
        ];

        $associations_en_attente = Association::where('status', 'en_attente')
            ->with('user')->latest()->get();
        $besoins_en_attente = Besoin::where('status', 'en_attente')->latest()->get();

        return view('admin.index', compact(
            'stats', 'associations_en_attente', 'besoins_en_attente',
            'labels', 'donsMois', 'usersMois', 'donsParType', 'assocStatuts'
        ));
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

    public function validerBesoin(Besoin $besoin)
    {
        $besoin->update(['status' => 'validee']);
        return redirect()->route('admin.index')
            ->with('success', 'Besoin validé et maintenant visible publiquement !');
    }

    public function rejeterBesoin(Besoin $besoin)
    {
        if ($besoin->attachment) {
            Storage::disk('public')->delete($besoin->attachment);
        }
        $besoin->delete();
        return redirect()->route('admin.index')->with('success', 'Besoin rejeté et supprimé.');
    }

    // ── Gestion Utilisateurs ──────────────────────────────
    public function users()
    {
        $users = User::whereNot('role', 'admin')
            ->latest()
            ->paginate(15);

        return view('dashboard.admin-users', compact('users'));
    }

    public function bloquerUser(User $user)
    {
        if ($user->role === 'admin') abort(403);
        $user->update(['is_blocked' => true]);
        return back()->with('success', 'Utilisateur bloqué.');
    }

    public function debloquerUser(User $user)
    {
        $user->update(['is_blocked' => false]);
        return back()->with('success', 'Utilisateur débloqué.');
    }

    public function supprimerUser(User $user)
    {
        if ($user->role === 'admin') abort(403);
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }

    //  2 méthodes export fichier pdf ou excel  dans la classe :

    public function exportDonsExcel()
    {
        return Excel::download(new DonsExport, 'dons_charitylink_'.now()->format('Ymd').'.xlsx');
    }

    public function exportDonsPdf()
    {
        $dons = \App\Models\Donation::with(['user', 'campaign'])->latest()->get();
        $pdf  = Pdf::loadView('exports.dons_pdf', compact('dons'))
                ->setPaper('a4', 'landscape');
        return $pdf->download('dons_charitylink_'.now()->format('Ymd').'.pdf');
    }
}
