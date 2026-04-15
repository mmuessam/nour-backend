<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'avatar', 'color',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cases()
    {
        return $this->hasMany(HelpCase::class, 'created_by');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'added_by');
    }

    public function updates()
    {
        return $this->hasMany(CaseUpdate::class, 'added_by');
    }

    public function userNotifications()
    {
        return $this->hasMany(Notification::class);
    }
}
