<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    // $table, $primaryKey, $fillable, $guarded, $timestamp, $nullable, $required
    protected $table = "locations";

    protected $primaryKey = "id";

    protected $fillable = [
        'city',
        'state',
        'country',
        'pincode',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $required = [
        'city',
    ];

    protected $nullable = [
        'state',
        'country',
        'pincode',
    ];


    protected $timestamp = true;

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_locations', 'locations_id', 'jobs_id')->with(['company', 'profile', 'qualifications', 'locations']);
    }
}
