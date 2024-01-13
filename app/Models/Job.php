<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = "jobs";

    protected $fillable = [
        'company_id',
        'profile_id',
        'vacancy',
        'min_salary',
        'max_salary',
        'description',
        'responsibility',
        'benifits_perks',
        'other_benifits',
        'is_verified',
        'is_featured',
        'is_active',
        'keywords',
        'work_type',
    ];

    // job has one company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    // job has many qualifications
    public function qualifications()
    {
        return $this->belongsToMany(Qualification::class, 'job_qualifications', 'jobs_id', 'qualifications_id');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'job_locations', 'jobs_id', 'locations_id');
    }

    // job has one profile
    public function profile()
    {
        return $this->belongsTo(JobProfile::class, 'profile_id', 'id');
    }
}
