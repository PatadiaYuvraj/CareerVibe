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

    private array $index, $unique, $type;
    public function up(): void
    {
        $this->index = [
            'id',
            'authorable_id',
            'authorable_type',
            'title',
            'type',
        ];
        $this->unique = [
            'id',
            'authorable_id',
            'authorable_type',
        ];
        $this->type = array_keys(Config::get('constants.post.type'));
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->morphs('authorable');
            $table->string('title');
            $table->enum(
                'type',
                $this->type
            )->default('text');
            $table->text('content');
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
        Schema::dropIfExists('posts');
    }
};
