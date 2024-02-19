<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qualification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "qualifications";

    protected $primaryKey = "id";

    protected $fillable = [
        'name',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $required = [
        'name',
    ];

    protected $timestamp = true;

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_qualifications', 'qualifications_id', 'jobs_id');
    }
}
