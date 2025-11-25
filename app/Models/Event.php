<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'company_id', 'title', 'description', 'location', 
        'event_datetime', 'image_url', 'capacity'
    ];
    
    protected $casts = [
        'event_datetime' => 'datetime',
    ];

    public function company() {
        return $this->belongsTo(ProfileCompany::class);
    }
    
    public function registrations() {
        return $this->hasMany(EventRegistration::class);
    }
    
    public function isRegisteredBy(User $user) {
        return $this->registrations()->where('user_id', $user->id)->exists();
    }
}
