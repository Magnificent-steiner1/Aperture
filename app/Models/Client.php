<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'client_id';
    protected $table = 'client_info';

    protected $fillable = [
        'account_id',
        'profile_photo',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
