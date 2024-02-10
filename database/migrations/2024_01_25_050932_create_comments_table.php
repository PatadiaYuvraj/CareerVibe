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
            "id",
            "authorable_id",
            "authorable_type",
            "post_id",
        ];
        $this->unique = [
            "id",
            "authorable_id",
            "authorable_type",
            "post_id",
        ];
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->morphs('authorable');
            $table->text('content');
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
        Schema::dropIfExists('comments');
    }
};
