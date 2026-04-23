<?php

namespace App\Http\Controllers;

use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot.index');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        $userMessage = $request->message;

        // Récupérer les associations validées
        $associations = Association::where('status', 'validee')
            ->get(['name', 'description', 'category', 'region'])
            ->map(fn($a) => "{$a->name} ({$a->category}) - {$a->region}: {$a->description}")
            ->join("\n");

        // Prompt système
        $systemPrompt = "Tu es l'assistant de Charity-Link, une plateforme humanitaire tunisienne.
Tu aides les donateurs à choisir les associations à soutenir.
Voici les associations disponibles sur la plateforme :

{$associations}

Réponds toujours en français de manière concise et utile.
Si l'utilisateur demande de l'aide pour choisir une association, recommande-lui
la plus adaptée selon sa demande.";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . env('GEMINI_API_KEY'), [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt . "\n\nUtilisateur: " . $userMessage]
                        ]
                    ]
                ]
            ]);

            $data = $response->json();
            $botResponse = $data['candidates'][0]['content']['parts'][0]['text']
                ?? 'Désolé, je n\'ai pas pu traiter votre demande.';

        } catch (\Exception $e) {
            $botResponse = 'Erreur de connexion au chatbot. Veuillez réessayer.';
        }

        return response()->json([
            'response' => $botResponse
        ]);
    }
}
