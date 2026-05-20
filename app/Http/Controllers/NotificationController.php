<?php
namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('notifications.index', compact('notifications'));
    }

    public function count()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
        return response()->json(['count' => $count]);
    }

    // ── Marquer une seule comme lue + rediriger ──
    public function markRead(Notification $notification)
    {
        abort_if($notification->user_id !== Auth::id(), 403);
        $notification->update(['is_read' => true]);
        return redirect($notification->url ?? route('notifications.index'));
    }

    // ── Supprimer toutes ──
    public function destroyAll()
    {
        Notification::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Toutes les notifications ont été supprimées.');
    }
}
