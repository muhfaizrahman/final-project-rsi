<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'job_id',
        'first_name',
        'last_name',
        'domicile',
        'applicant_email',
        'applicant_phone',
        'cv_url',
        'status'
    ];

    public function jobs() {
        return $this->belongsTo(Job::class);
    }
}
