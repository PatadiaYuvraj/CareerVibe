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
            "followable_id",
            "followable_type",
            "user_id",
        ];
        $this->unique = [
            "user_id",
            "followable_id",
            "followable_type",
        ];
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('followable_id');
            $table->string('followable_type');
            $table->unique(
                $this->unique
            );
            $table->index(
                $this->index
            );
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
