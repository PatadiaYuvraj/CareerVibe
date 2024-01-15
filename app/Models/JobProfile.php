<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class, 'profile_id', 'id')->with(['company']);
    }
}
