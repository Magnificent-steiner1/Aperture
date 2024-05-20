<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs_info';
    protected $primaryKey = 'job_id';

    protected $fillable = [
        'client_id',
        'photographer_id',
        'type',
        'description',
        'date',
        'duration',
        'salary',
        'status',
        'job_rating',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    public function photographer()
    {
        return $this->belongsTo(Photographer::class, 'photographer_id', 'photographer_id');
    }

    public function isExpired()
    {
        return $this->date < Carbon::now() && $this->status !== 'ended';
    }

    // Method to accept a job and expire other offers
    public function accept()
    {
        $this->status = 'accepted';
        $this->save();
        
        self::where('client_id', $this->client_id)
            ->where('date', $this->date)
            ->where('job_id', '!=', $this->job_id)
            ->update(['status' => 'expired']);
    }

    public function complete($rating)
    {
        $this->status = 'ended';
        $this->job_rating = $rating;
        $this->save();
    }
    public static function updateExpiredJobs()
    {
        $jobs = self::where('status', '!=', 'ended')
                    ->where('date', '<', Carbon::now())
                    ->get();

        foreach ($jobs as $job) {
            $job->status = 'expired';
            $job->save();
        }
    }
}
