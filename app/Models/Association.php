<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Association extends Model
{
    use HasFactory;

    // app/Models/Association.php
    protected $fillable = [
        'user_id', 'name', 'description', 'category', 'region',
        'phone_mobile', 'phone_fix', 'email',
        'logo', 'doc_rne', 'doc_fiscal',
        'website', 'facebook', 'status', 'rejection_reason',
    ];

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec Campaigns
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
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
