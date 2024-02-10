<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $index, $unique;
    public function up(): void
    {

        $this->index = [
            "jobs_id",
            "locations_id",
        ];
        $this->unique = [
            "jobs_id",
            "locations_id",
        ];

        Schema::create('job_locations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("jobs_id")->unsigned();
            $table->bigInteger("locations_id")->unsigned();
            $table->foreign('jobs_id')->references('id')->on('jobs');
            $table->foreign('locations_id')->references('id')->on('locations');
            $table->unique(
                $this->unique
            );
            $table->index(
                $this->index
            );
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
