<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'association_id',
        'campaign_id',      // ✅ NOUVEAU
        'benevole_id',
        'title',
        'description',
        'competence_requise',
        'deadline',
        'status',
        'feedback',
        'compte_rendu',
        'note_association',
        'is_archived',
    ];

    protected $casts = [
        'deadline'    => 'date',
        'is_archived' => 'boolean',
    ];

    public function association() { return $this->belongsTo(Association::class); }
    public function benevole()    { return $this->belongsTo(User::class, 'benevole_id'); }
    public function campaign()    { return $this->belongsTo(Campaign::class); }  // ✅ NOUVEAU

    public function scopeOuverte($query)
    {
        return $query->where('status', 'ouverte');
    }
}
