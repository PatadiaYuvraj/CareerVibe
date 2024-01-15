<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'qualification',
    ];

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_qualifications', 'qualifications_id', 'jobs_id')->with(['company', 'profile', 'qualifications', 'locations']);
    }
}
