<?php

namespace App\Helpers;

use App\Models\Notification;

class NotificationHelper
{
    // Envoyer une notification
    public static function send(
        int $userId,
        string $title,
        string $message,
        string $type = 'systeme',
        string $url = null
    ) {
        Notification::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'url'     => $url,
            'is_read' => false,
        ]);
    }

    // Notification don effectué
    public static function donEffectue(int $userId, string $campaignTitle, string $type)
    {
        self::send(
            $userId,
            '✅ Don confirmé !',
            "Votre don ({$type}) pour la campagne \"{$campaignTitle}\" a été confirmé.",
            'don',
            '/donations/historique'
        );
    }

    // Notification association validée
    public static function associationValidee(int $userId, string $associationName)
    {
        self::send(
            $userId,
            '🎉 Association validée !',
            "Votre association \"{$associationName}\" a été validée par l'administrateur.",
            'validation',
            '/associations'
        );
    }

    // Notification association rejetée
    public static function associationRejetee(int $userId, string $associationName)
    {
        self::send(
            $userId,
            '❌ Association rejetée',
            "Votre association \"{$associationName}\" a été rejetée. Consultez le motif.",
            'validation',
            '/dashboard'
        );
    }

    // Notification tâche assignée
    public static function tacheAssignee(int $userId, string $tacheTitle)
    {
        self::send(
            $userId,
            '🤝 Nouvelle tâche !',
            "Vous avez accepté la tâche \"{$tacheTitle}\".",
            'tache',
            '/taches/mes-taches'
        );
    }

    // Notification besoin reçu (admin)
    public static function besoinRecu(int $adminId, string $nom)
    {
        self::send(
            $adminId,
            '🆘 Nouveau besoin déclaré !',
            "{$nom} a déclaré un besoin d'aide. Vérifiez le panel admin.",
            'besoin',
            '/admin'
        );
    }
}
