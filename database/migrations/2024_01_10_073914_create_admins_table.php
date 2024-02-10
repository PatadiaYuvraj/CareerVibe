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
            'name',
            'email',
            'id',
        ];
        $this->unique = [
            'email',
            'id',
        ];

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string("userType", 10)->default("ADMIN");
            $table->string('name', 20);
            $table->string('email', 100);
            $table->string('password', 100)->nullable();
            $table->text("profile_image_url")->nullable();
            $table->text("profile_image_public_id")->nullable();
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
        Schema::dropIfExists('admins');
    }
};
