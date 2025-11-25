<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'job_id',
        'applicant_email',
        'applicant_phone',
        'cv_url'
    ];

    public function jobs() {
        return $this->belongsTo(Job::class);
    }
}
