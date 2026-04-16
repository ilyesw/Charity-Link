<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'association_id',
        'benevole_id',
        'title',
        'description',
        'competence_requise',
        'deadline',
        'status',
        'feedback',
        'compte_rendu',
        'note_association',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    // Relation avec Association
    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    // Relation avec Bénévole (User)
    public function benevole()
    {
        return $this->belongsTo(User::class, 'benevole_id');
    }

    // Scopes
    public function scopeOuverte($query)
    {
        return $query->where('status', 'ouverte');
    }
}
