<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile',
        'description'
    ];

    // job profile has many jobs


    public function jobs()
    {
        return $this->hasMany(Job::class, 'profile_id', 'id');
    }

    // count jobs

    public function count_jobs()
    {
        return $this->jobs()->count();
    }
}
