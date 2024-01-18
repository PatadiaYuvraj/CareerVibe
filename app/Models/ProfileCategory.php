<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileCategory extends Model
{
    use HasFactory;

    protected $table = "profile_categories";

    protected $primaryKey = "id";

    protected $fillable = ['name'];

    protected $timestamp = true;

    public function subProfiles()
    {
        return $this->hasMany(SubProfile::class, "profile_category_id", "id");
    }

    public function jobs()
    {
        return $this->hasManyThrough(Job::class, SubProfile::class, "profile_category_id", "sub_profile_id", "id", "id");
    }

    // get sub profiles with jobs
    public function subProfilesWithJobs()
    {
        return $this->hasMany(SubProfile::class, "profile_category_id", "id")->with('jobs');
    }
}
