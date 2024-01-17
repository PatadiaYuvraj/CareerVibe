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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    /*
        $table->id();
        $table->string("name", 25);
        $table->string("email", 50)->unique()->index();
        $table->string("password", 100);
        $table->string("userType", 10)->default("USER");
        $table->text("profile_image_url")->nullable();
        $table->text("profile_image_public_id")->nullable();
        $table->text("resume_pdf_url")->nullable();
        $table->string("contact", 15)->nullable();
        $table->enum("gender", ["MALE", "FEMALE", "OTHER"])->nullable();
        $table->boolean('is_active')->default(true);
        $table->string("headline", 200)->nullable();
        $table->string("education", 200)->nullable();
        $table->string("interest", 100)->nullable();
        $table->string("hobby", 100)->nullable();
        $table->string("city", 30)->nullable();
        $table->text("about")->nullable();
        $table->string("experience", 200)->nullable();
        $table->rememberToken();
        $table->index(['name', 'email', 'id']);
        $table->timestamps();
    */
    // $table, $primaryKey, $fillable, $guarded, $timestamp, $nullable, $required

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
}
