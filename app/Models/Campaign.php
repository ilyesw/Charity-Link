<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'association_id',
        'title',
        'nature',
        'affiche',
        'description',
        'goal_amount',
        'current_amount',
        'objectif_description',
        'image',
        'status',
        'date_debut',
        'deadline',
        'compte_rendu',
    ];

    protected $casts = [
        'date_debut'     => 'date',
        'deadline'       => 'date',
        'goal_amount'    => 'decimal:2',
        'current_amount' => 'decimal:2',
    ];

    // Relations
    public function association()   { return $this->belongsTo(Association::class); }
    public function donations()     { return $this->hasMany(Donation::class); }
    public function photos()        { return $this->hasMany(CampaignPhoto::class); }
    public function transactions()  { return $this->hasMany(CampaignTransaction::class); }
    public function ratings()       { return $this->hasMany(CampaignRating::class); }
    public function taches()        { return $this->hasMany(Tache::class); }

    // Moyenne des notes
    public function averageRating()
    {
        return round($this->ratings()->avg('note'), 1);
    }

    // Total entrées (argent)
    public function totalEntrees()
    {
        return $this->transactions()->where('type', 'entree')->sum('montant');
    }

    // Total sorties (dépenses)
    public function totalSorties()
    {
        return $this->transactions()->where('type', 'sortie')->sum('montant');
    }

    // Solde
    public function solde()
    {
        return $this->totalEntrees() - $this->totalSorties();
    }

    // Pourcentage progression (si campagne monétaire)
    public function progressPercentage()
    {
        if (!$this->goal_amount || $this->goal_amount == 0) return 0;
        return min(100, round(($this->current_amount / $this->goal_amount) * 100));
    }

    public function scopeActive($query) { return $query->where('status', 'active'); }
}
