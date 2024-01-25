<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;


    /*
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->morphs('postable'); // User or Company
        $table->string('title');
        $table->text('content');
        $table->timestamps();
    });

    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->morphs('postable');
        $table->foreignId('post_id')->constrained()->onDelete('cascade');
        $table->text('content');
        $table->timestamps();
    });

    Schema::create('likes', function (Blueprint $table) {
        $table->id();
        $table->morphs('postable');
        $table->foreignId('post_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
    */

    public function postable()
    {
        return $this->morphTo();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'postable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'postable');
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
