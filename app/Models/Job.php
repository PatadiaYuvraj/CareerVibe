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
        'job_profile',
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

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'job_locations', 'job_id', 'location_id');
    }

    public function qualifications()
    {
        return $this->belongsToMany(Qualification::class, 'job_qualifications', 'job_id', 'qualification_id');
    }
}
