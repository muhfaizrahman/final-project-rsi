<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'profile_photo_url',
        'background_photo_url',
        'city',
        'country',
        'biography'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function skills() {
        return $this->hasMany(Skill::class);
    }

    public function educations() {
        return $this->hasMany(Education::class);
    }
}
