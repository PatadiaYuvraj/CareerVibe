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
            "id",
        ];

        $this->unique = [
            "name",
        ];

        Schema::create('profile_categories', function (Blueprint $table) {
            $table->id();
            $table->string("name", 100);
            $table->index($this->index);
            $table->unique($this->unique);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_categories');
    }
};
