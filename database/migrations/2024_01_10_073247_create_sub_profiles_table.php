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
        Schema::create('sub_profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("profile_category_id")->unsigned()->index();
            $table->string("name", 50);
            $table->index(['name', 'id']);
            $table->foreign('profile_category_id')->references('id')->on('profile_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_profiles');
    }
};
