<?php
// ===== app/Models/CampaignPhoto.php =====
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CampaignPhoto extends Model
{
    protected $fillable = ['campaign_id', 'path', 'caption'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}

