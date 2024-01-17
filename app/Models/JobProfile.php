<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobProfile extends Model
{
    use HasFactory;
    // $table, $primaryKey, $fillable, $guarded, $timestamp, $nullable, $required
    protected $table = "job_profiles";

    protected $primaryKey = "id";

    protected $fillable = [
        'profile',
    ];

    protected $guarded = [
        'id',
    ];

    protected $required = [
        'profile',
    ];

    protected $timestamp = true;

    public function jobs()
    {
        return $this->hasMany(Job::class, 'profile_id', 'id')->with(['company']);
    }
}
