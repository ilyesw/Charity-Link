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
        'description',
        'goal_amount',
        'current_amount',
        'image',
        'status',
        'deadline',
    ];

    protected $casts = [
        'deadline'       => 'date',
        'goal_amount'    => 'decimal:2',
        'current_amount' => 'decimal:2',
    ];

    // Relation avec Association
    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    // Pourcentage de progression
    public function progressPercentage()
    {
        if ($this->goal_amount == 0) return 0;
        return min(100, round(($this->current_amount / $this->goal_amount) * 100));
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
