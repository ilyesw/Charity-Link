<?php
// ===== app/Models/CampaignRating.php =====
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CampaignRating extends Model
{
    protected $fillable = ['campaign_id', 'user_id', 'note'];

    public function campaign() { return $this->belongsTo(Campaign::class); }
    public function user()     { return $this->belongsTo(User::class); }
}
