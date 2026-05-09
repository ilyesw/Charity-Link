<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Besoin extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'phone',
        'categorie',
        'description',
        'region',
        'urgence',
        'status',
        'association_id',
        'admin_note',
        'is_anonymous',   // ✅ Feature 2
        'attachment',     // ✅ Feature 3
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
    ];

    // Relation avec Association
    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    // ✅ Nom affiché publiquement (anonyme ou réel)
    public function getNomPublicAttribute(): string
    {
        return $this->is_anonymous ? 'Anonyme' : $this->nom;
    }

    // Scopes
    public function scopeEnAttente($query)
    {
        return $query->where('status', 'en_attente');
    }

    // ✅ Feature 1 : Scope — visible publiquement (validées seulement)
    public function scopeValides($query)
    {
        return $query->whereIn('status', ['validee', 'pris_en_charge', 'resolu']);
    }
}
