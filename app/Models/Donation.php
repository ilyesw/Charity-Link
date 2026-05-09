<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'campaign_id',
        'type',
        'amount',
        'category',
        'quantity',
        'pickup_address',
        'competence',
        'availability',
        'competence_desc',
        'message',
        'status',
        // ✅ Nouveaux champs
        'type_don',
        'description_nature',
        'quantite',
        'valeur_estimee',
        'justificatif',
        'is_anonymous',
        'display_name',
    ];

    protected $casts = [
        'is_anonymous'  => 'boolean',
        'valeur_estimee' => 'decimal:2',
    ];

    // Nom affiché publiquement
    public function nomPublic()
    {
        if ($this->is_anonymous) return 'Anonyme';
        return $this->display_name ?? 'Anonyme';
    }

    public function user()     { return $this->belongsTo(User::class); }
    public function campaign() { return $this->belongsTo(Campaign::class); }
}
