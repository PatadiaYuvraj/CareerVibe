<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image_url',
        'profile_image_public_id',
        'resume_pdf_url',
        'resume_pdf_public_id',
        'contact',
        'gender',
        'is_active',
        'headline',
        'education',
        'interest',
        'hobby',
        'city',
        'about',
        'experience',
    ];

    protected $requireds = [
        'name',
        'email',
        'password',
    ];

    protected $guarded = [
        'id',
        'userType',
        'created_at',
        'updated_at',
    ];

    protected $nullable = [
        'profile_image_url',
        'profile_image_public_id',
        'resume_pdf_url',
        'contact',
        'gender',
        'is_active',
        'headline',
        'education',
        'interest',
        'hobby',
        'city',
        'about',
        'experience',
    ];

    protected $timestamp = true;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function appliedJobs()
    {
        return $this->belongsToMany(Job::class, 'job_user')->withTimestamps();
    }

    public function savedJobs()
    {
        return $this->belongsToMany(Job::class, 'saved_jobs')->withTimestamps();
    }

    public function getIsAppliedAttribute()
    {
        return $this->applyByUsers()->where('user_id', auth()->user()->id)->exists();
    }

    public function getIsSavedAttribute()
    {
        return $this->savedByUsers()->where('user_id', auth()->user()->id)->exists();
    }
}
