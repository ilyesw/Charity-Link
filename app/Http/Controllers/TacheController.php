<?php
namespace App\Http\Controllers;
use App\Models\Tache;
use App\Models\Association;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TacheController extends Controller
{
    public function index()
    {
        $taches = Tache::ouverte()
            ->with('association')
            ->latest()
            ->paginate(10);
        return view('taches.index', compact('taches'));
    }

    public function create()
    {
        $association = Association::where('user_id', Auth::id())
            ->where('status', 'validee')
            ->first();
        if (!$association) {
            return redirect()->route('dashboard')
                ->with('error', 'Votre association doit être validée.');
        }
        return view('taches.create', compact('association'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'              => ['required', 'string', 'max:255'],
            'description'        => ['required', 'string'],
            'competence_requise' => ['required', 'string', 'max:255'],
            'deadline'           => ['nullable', 'date', 'after:today'],
        ]);
        $association = Association::where('user_id', Auth::id())
            ->where('status', 'validee')
            ->firstOrFail();
        Tache::create([
            'association_id'     => $association->id,
            'title'              => $request->title,
            'description'        => $request->description,
            'competence_requise' => $request->competence_requise,
            'deadline'           => $request->deadline,
            'status'             => 'ouverte',
        ]);
        return redirect()->route('taches.index')
            ->with('success', 'Tâche créée avec succès !');
    }

    public function postuler(Tache $tache)
    {
        if ($tache->status !== 'ouverte') {
            return redirect()->back()
                ->with('error', 'Cette tâche n\'est plus disponible.');
        }
        $tache->update([
            'benevole_id' => Auth::id(),
            'status'      => 'en_cours',
        ]);
        NotificationHelper::tacheAssignee(Auth::id(), $tache->title);
        NotificationHelper::send(
            $tache->association->user_id,
            '🤝 Bénévole assigné !',
            "Un bénévole a accepté votre tâche \"{$tache->title}\".",
            'tache',
            '/dashboard'
        );
        return redirect()->route('taches.mes_taches')
            ->with('success', 'Vous avez accepté cette tâche !');
    }

    public function mes_taches()
    {
        $taches = Tache::where('benevole_id', Auth::id())
            ->with('association')
            ->latest()
            ->get();
        return view('taches.mes_taches', compact('taches'));
    }

    public function compte_rendu(Request $request, Tache $tache)
    {
        $request->validate([
            'compte_rendu' => ['required', 'string'],
            'feedback'     => ['nullable', 'string'],
        ]);
        $tache->update([
            'compte_rendu' => $request->compte_rendu,
            'feedback'     => $request->feedback,
            'status'       => 'validee',
        ]);
        return redirect()->route('taches.mes_taches')
            ->with('success', 'Compte rendu soumis avec succès !');
    }

    // ✅ NOUVEAU — Edit
    public function edit(Tache $tache)
    {
        if ($tache->association->user_id !== Auth::id()) {
            abort(403);
        }
        return view('taches.edit', compact('tache'));
    }

    // ✅ NOUVEAU — Update
    public function update(Request $request, Tache $tache)
    {
        if ($tache->association->user_id !== Auth::id()) {
            abort(403);
        }
        $request->validate([
            'title'              => ['required', 'string', 'max:255'],
            'description'        => ['required', 'string'],
            'competence_requise' => ['required', 'string', 'max:255'],
            'deadline'           => ['nullable', 'date'],
            'status'             => ['required', 'in:ouverte,en_cours,validee'],
        ]);
        $tache->update([
            'title'              => $request->title,
            'description'        => $request->description,
            'competence_requise' => $request->competence_requise,
            'deadline'           => $request->deadline,
            'status'             => $request->status,
        ]);
        return redirect()->route('taches.index')
            ->with('success', 'Tâche mise à jour !');
    }

    // ✅ NOUVEAU — Destroy
    public function destroy(Tache $tache)
    {
        if ($tache->association->user_id !== Auth::id()) {
            abort(403);
        }
        $tache->delete();
        return redirect()->route('taches.index')
            ->with('success', 'Tâche supprimée.');
    }
}
