<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
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
            $table->bigInteger('company_id')->unsigned();
            $table->bigInteger('sub_profile_id')->unsigned();
            $table->tinyInteger("vacancy")->nullable();
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
            $table->enum(
                'work_type',
                array_keys(Config::get('constants.job.work_type'))
            )->nullable();
            $table->enum(
                'job_type',
                array_keys(Config::get('constants.job.job_type'))
            )->nullable();
            $table->enum(
                'experience_level',
                array_keys(Config::get('constants.job.experience_level'))
            )->nullable();
            $table->enum(
                'experience_type',
                array_keys(Config::get('constants.job.experience_type'))
            )->nullable();
            $table->index([
                'keywords',
                'id',
                'company_id',
                'sub_profile_id',
            ]);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('sub_profile_id')->references('id')->on('sub_profiles')->onDelete('cascade');
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
