<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_profile', 100); // One to Many 
            $table->tinyInteger("vacancy")->nullable(); // no of vacancy of this job
            // $table->tinyInteger("applicant")->nullable(); // no of applicants of this job
            $table->tinyInteger("min_salary")->nullable();
            $table->tinyInteger("max_salary")->isEmployernullable();
            $table->text('description')->nullable();
            $table->text('responsibility')->nullable();
            $table->text('benifits_perks')->nullable();
            $table->text('other_benifits')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('keywords')->nullable();
            $table->enum('work_type', ['REMOTE', "WFO", "HYBRID"])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
