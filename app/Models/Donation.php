<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'campaign_id',
        'type',
        'amount',
        'category',
        'quantity',
        'pickup_address',
        'competence',
        'availability',
        'competence_desc',
        'message',
        'status',
    ];

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec Campaign
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
