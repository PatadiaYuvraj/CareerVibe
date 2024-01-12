<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = "jobs";

    protected $fillable = [
        'company_id',
        'job_profile',
        'vacancy',
        'min_salary',
        'max_salary',
        'description',
        'responsibility',
        'benifits_perks',
        'other_benifits',
        'is_verified',
        'is_featured',
        'is_active',
        'keywords',
        'work_type',
    ];

    // job has one company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /*
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned();
            $table->string('job_profile', 100); // One to Many 
            $table->tinyInteger("vacancy")->nullable(); // no of vacancy of this job
            $table->mediumInteger("min_salary")->nullable();
            $table->mediumInteger("max_salary")->nullable();
            $table->text('description')->nullable();
            $table->text('responsibility')->nullable();
            $table->text('benifits_perks')->nullable();
            $table->text('other_benifits')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('keywords')->nullable();
            $table->enum('work_type', ['REMOTE', "WFO", "HYBRID"])->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->timestamps();
        });
    */

    /*
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->string('qualification', 100);
            $table->timestamps();
        });
    */

    /*
        Schema::create('job_qualifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("jobs_id")->unsigned();
            $table->bigInteger("qualifications_id")->unsigned();
            $table->foreign('jobs_id')->references('id')->on('jobs');
            $table->foreign('qualifications_id')->references('id')->on('qualifications');
            $table->unique(['jobs_id', 'qualifications_id']);
            $table->timestamps();
        });
    */

    // job has many qualifications
    public function qualifications()
    {
        return $this->belongsToMany(Qualification::class, 'job_qualifications', 'jobs_id', 'qualifications_id');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'job_locations', 'jobs_id', 'locations_id');
    }

    // job has one profile
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }
}
