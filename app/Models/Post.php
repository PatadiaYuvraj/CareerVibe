<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'postable_id',
        'postable_type',
        'title',
        'content'
    ];

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
