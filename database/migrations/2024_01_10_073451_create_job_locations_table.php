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
        Schema::create('job_locations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("jobs_id")->unsigned();
            $table->bigInteger("locations_id")->unsigned();
            $table->foreign('jobs_id')->references('id')->on('jobs');
            $table->foreign('locations_id')->references('id')->on('locations');
            $table->unique(['jobs_id', 'locations_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_locations');
    }
};
