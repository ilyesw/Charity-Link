<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Association extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'category',
        'region',
        'logo',
        'document_justif',
        'status',
        'rejection_reason',
        'website',
        'facebook',
    ];

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeValidees($query)
    {
        return $query->where('status', 'validee');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('status', 'en_attente');
    }
}
