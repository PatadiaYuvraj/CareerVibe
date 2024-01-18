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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_verified')->default(false);
            $table->string("userType", 10)->default("COMPANY");
            $table->string('name', 60);
            $table->string('email', 100)->unique();
            $table->string('password', 100)->nullable();
            $table->text("profile_image_url")->nullable();
            $table->text("profile_image_public_id")->nullable();
            $table->string('website', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('linkedin', 100)->nullable();
            $table->text('description')->nullable();
            $table->index(['name', 'email', 'id']);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
