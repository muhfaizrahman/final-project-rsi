<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'profile_id',
        'experience_title',
        'organization_name',
        'start_date',
        'end_date',
        'description'
    ];

    public function profile() {
        return $this->belongsTo(Profile::class);
    }
}