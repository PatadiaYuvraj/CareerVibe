<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'city',
        'state',
        'country',
        'pincode',
    ];

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_locations', 'locations_id', 'jobs_id')->with(['company', 'profile', 'qualifications', 'locations']);
    }
}
