<?php
namespace App\Http\Controllers;
use App\Models\Besoin;
use App\Models\Association;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class BesoinController extends Controller
{
    // ✅ Liste publique des besoins
    public function index()
    {
        $besoins = Besoin::with('association')
            ->latest()
            ->paginate(12);
        return view('besoins.index', compact('besoins'));
    }

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
            ->with('success', 'Votre demande a été soumise !');
    }

    // Page confirmation
    public function confirmation()
    {
        return view('besoins.confirmation');
    }

    // ✅ Association prend en charge un besoin
    public function prendreEnCharge(Besoin $besoin)
    {
        // Vérifier que c'est une association validée
        $association = Association::where('user_id', auth()->id())
            ->where('status', 'validee')
            ->first();

        if (!$association) {
            return redirect()->back()
                ->with('error', 'Votre association doit être validée.');
        }

        // Vérifier que le besoin est encore en attente
        if ($besoin->status !== 'en_attente') {
            return redirect()->back()
                ->with('error', 'Ce besoin est déjà pris en charge.');
        }

        $besoin->update([
            'association_id' => $association->id,
            'status'         => 'pris_en_charge',
        ]);

        // Notifier l'admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                '🆘 Besoin pris en charge',
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
