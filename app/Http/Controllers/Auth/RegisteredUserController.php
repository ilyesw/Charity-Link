<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:donateur,association,benevole'],
            'phone'    => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => $request->role,
            'phone'             => $request->phone,
            'language'          => $request->language ?? 'fr',
            'email_verified_at' => now(),
            'is_active'         => true,
        ]);

        event(new Registered($user));
        Auth::login($user);

        // Redirection selon le rôle
        return match($user->role) {
            'association' => redirect()->route('dashboard'),
            'benevole'    => redirect()->route('dashboard'),
            default       => redirect()->route('dashboard'),
        };
    }
}
