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
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->morphs('authorable');
            $table->string('title');
            $table->enum(
                'type',
                array_keys(Config::get('constants.post.type'))
            )->default('text');
            $table->text('content');
            $table->unique([
                'id', 'authorable_id', 'authorable_type'
            ]);
            $table->index([
                'id',
                'authorable_id',
                'authorable_type',
                'title',
                'type',
            ]);
            // $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
