<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = "jobs";

    protected $primaryKey = "id";

    protected $required = [
        'company_id',
        'sub_profile_id',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'company_id',
        'sub_profile_id',
        'vacancy',
        'min_salary',
        'max_salary',
        'description',
        'responsibility',
        'benifits_perks',
        'other_benifits',
        'keywords',
        'is_verified',
        'is_featured',
        'is_active',
        'work_type',
        "job_type",
        "experience_level",
        "experience_type"
    ];

    protected $nullable = [
        'vacancy',
        'min_salary',
        'max_salary',
        'description',
        'responsibility',
        'benifits_perks',
        'other_benifits',
        'keywords',
        'is_verified',
        'is_featured',
        'is_active',
        'work_type',
        "job_type",
        "experience_level",
        "experience_type"
    ];

    protected $timestamp = true;

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function qualifications()
    {
        return $this->belongsToMany(Qualification::class, 'job_qualifications', 'jobs_id', 'qualifications_id');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'job_locations', 'jobs_id', 'locations_id');
    }

    public function subProfile()
    {
        return $this->belongsTo(SubProfile::class, 'sub_profile_id', 'id');
    }

    public function profileCategory()
    {
        return $this->hasOneThrough(ProfileCategory::class, SubProfile::class, 'id', 'id', 'sub_profile_id', 'profile_category_id');
    }
}
