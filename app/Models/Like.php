<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['likeable_id', 'likeable_type', 'authorable_id', 'authorable_type'];

    public function likeable()
    {
        return $this->morphTo(); // likeable_type (e.g. post, comment)
    }

    public function authorable()
    {
        return $this->morphTo(); // authorable_type (e.g. user, company)
    }
}
