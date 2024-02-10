<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    private array $index, $unique;

    public function up(): void
    {
        $this->index = [
            "name",
            "profile_category_id",
            "id",
        ];

        $this->unique = [
            "name",
            "profile_category_id",
        ];

        Schema::create('sub_profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("profile_category_id")->unsigned();
            $table->string("name", 100);
            $table->index(
                $this->index
            );
            $table->unique(
                $this->unique
            );
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
