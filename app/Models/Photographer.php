<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photographer extends Model
{
    use HasFactory;

    protected $primaryKey = 'photographer_id';
    protected $table = 'photographer_info';
    protected $fillable = [
        'account_id',
        'profile_photo',
        'started_working',
        'about',
        'rating',
        'skill1',
        'skill2',
        'skill3',
        'number_of_jobs',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
