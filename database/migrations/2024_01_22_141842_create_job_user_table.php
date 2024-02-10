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
            "user_id",
            "job_id",
        ];
        $this->unique = [
            "user_id",
            "job_id",
        ];
        Schema::create('job_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->unique(
                $this->unique
            );
            $table->index(
                $this->index
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_user');
    }
};
