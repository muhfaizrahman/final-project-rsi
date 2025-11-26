<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileCompany extends Model
{

    protected $table = 'profile_companies'; 

    protected $fillable = [
        'user_id',
        'company_name',
        'city',
        'country',
        'about',
        'profile_photo_url',
        'background_photo_url',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function jobs() {
        return $this->hasMany(Job::class);
    }

    public function events() {
        return $this->hasMany(Event::class);
    }
}
