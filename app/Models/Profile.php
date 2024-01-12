<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile',
    ];

    // job profile has many jobs


    public function jobs()
    {
        return $this->hasMany(JobProfile::class, "profiles_id", "jobs_id");
    }
}
