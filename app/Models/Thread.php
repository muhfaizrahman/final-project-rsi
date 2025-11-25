<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['user_id', 'job_id', 'company_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function job() {
        return $this->belongsTo(Job::class);
    }

    public function company() {
        return $this->belongsTo(ProfileCompany::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
