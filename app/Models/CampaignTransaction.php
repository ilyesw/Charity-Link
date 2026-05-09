<?php
// ===== app/Models/CampaignTransaction.php =====
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CampaignTransaction extends Model
{
    protected $fillable = [
        'campaign_id',
        'type',           // entree | sortie
        'description',
        'montant',
        'justificatif',
        'date_transaction',
    ];

    protected $casts = [
        'date_transaction' => 'date',
        'montant'          => 'decimal:2',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}

