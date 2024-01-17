<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // $table, $primaryKey, $fillable, $guarded, $timestamp, $nullable, $required
    protected $table = 'companies';
    protected $primaryKey = 'id';

    protected $fillable = [
        'is_verified',
        'name',
        'email',
        'password',
        'profile_image_url',
        'profile_image_public_id',
        'website',
        'address_line_1',
        'address_line_2',
        'linkedin_profile',
        'description',
    ];

    protected $required = [
        'name',
        'email',
        'password',
    ];

    protected $guarded = [
        'id',
        'userType',
        'created_at',
        'updated_at',
        'remember_token',
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

    public function jobs()
    {
        return $this->hasMany(Job::class, 'company_id', 'id');
    }
}
