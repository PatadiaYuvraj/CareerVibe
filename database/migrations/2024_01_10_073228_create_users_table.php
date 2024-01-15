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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("name", 25);
            $table->string("email", 50)->unique()->index();
            $table->string("password", 100);
            $table->string("userType", 10)->default("USER");
            $table->string('profileImage')->nullable();
            $table->string("resume_pdf_url", 100)->nullable();
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
