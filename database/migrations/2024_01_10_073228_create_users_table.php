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


    private array $index = [
        "name",
        "email",
        "id",
        "is_active",
    ];

    private array $unique = [
        "email",
    ];

    public function up(): void
    {



        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("name", 25);
            $table->string("email", 50)->unique()->index();
            $table->string("password", 100);
            $table->string("userType", 10)->default("USER");
            $table->text("profile_image_url")->nullable();
            $table->text("profile_image_public_id")->nullable();
            $table->text("resume_pdf_url")->nullable();
            $table->text("resume_pdf_public_id")->nullable();
            $table->string("contact", 15)->nullable();
            $table->enum(
                "gender",
                array_keys(Config::get('constants.gender'))
            )->nullable();
            $table->boolean('is_active')->default(true);
            $table->string("headline", 200)->nullable();
            $table->string("education", 200)->nullable();
            $table->string("interest", 100)->nullable();
            $table->string("hobby", 100)->nullable();
            $table->string("city", 30)->nullable();
            $table->text("about")->nullable();
            $table->string("experience", 200)->nullable();
            $table->boolean('is_email_verified')->default(false);
            $table->string(
                "email_verification_token",
                100
            )->nullable();
            $table->timestamp("email_verified_at")->nullable();
            $table->string(
                "password_reset_token",
                100
            )->nullable();
            $table->timestamp("password_reset_at")->nullable();
            $table->string(
                "password_change_token",
                100
            )->nullable();
            $table->timestamp("password_change_at")->nullable();
            $table->string(
                "email_change_token",
                100
            )->nullable();
            $table->timestamp("email_change_at")->nullable();
            $table->timestamp("last_login_at")->nullable();
            $table->rememberToken();
            $table->index(
                $this->index
            );
            $table->unique(
                $this->unique
            );
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
