<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'avatar',
        'language',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Vérification des rôles
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDonateur(): bool
    {
        return $this->role === 'donateur';
    }

    public function isAssociation(): bool
    {
        return $this->role === 'association';
    }

    public function isBenevole(): bool
    {
        return $this->role === 'benevole';
    }
}