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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string("userType", 10)->default("ADMIN");
            $table->string('name', 60);
            $table->string('email', 100)->unique();
            $table->string('password', 100)->nullable();
            $table->text("profile_image_url")->nullable();
            $table->text("profile_image_public_id")->nullable();
            $table->rememberToken();
            $table->index(['name', 'email', 'id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
