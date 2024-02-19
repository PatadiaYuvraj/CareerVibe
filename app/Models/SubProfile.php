<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sub_profiles";

    protected $primaryKey = "id";

    protected $fillable = [
        'profile_category_id',
        'name',
    ];

    protected $timestamp = true;

    public function profileCategory()
    {
        return $this->belongsTo(ProfileCategory::class, "profile_category_id", "id");
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, "sub_profile_id", "id");
    }
}
