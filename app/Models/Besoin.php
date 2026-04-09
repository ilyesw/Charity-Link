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
    ];

    // Relation avec Association
    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    // Scopes
    public function scopeEnAttente($query)
    {
        return $query->where('status', 'en_attente');
    }
}
