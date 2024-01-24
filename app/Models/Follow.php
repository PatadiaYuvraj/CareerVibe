<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Follow extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'follows';

    protected $timestamp = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function followable()
    {
        return $this->morphTo();
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'followable_id');
    }
}
