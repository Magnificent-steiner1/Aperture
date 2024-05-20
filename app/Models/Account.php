<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Account extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'dob', 'address', 'latitude', 'longitude', 'account_type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function isPhotographer()
    {
        return $this->account_type === 'photographer';
    }

    public function isClient()
    {
        return $this->account_type === 'client';
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function photographer(): HasOne
    {
        return $this->hasOne(Photographer::class);
    }
}
