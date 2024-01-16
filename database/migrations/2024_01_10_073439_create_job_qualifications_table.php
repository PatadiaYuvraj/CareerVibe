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
        Schema::create('job_qualifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("jobs_id")->unsigned();
            $table->bigInteger("qualifications_id")->unsigned();
            $table->foreign('jobs_id')->references('id')->on('jobs');
            $table->foreign('qualifications_id')->references('id')->on('qualifications');
            $table->unique(['jobs_id', 'qualifications_id']);
            $table->index(['jobs_id', 'qualifications_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_qualifications');
    }
};
