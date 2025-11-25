<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    protected $table = "jobs";

    protected $fillable = [
        'title',
        'work_type_id',
        'work_method_id',
        'description',
        'requirements',
        'industry_id',
        'is_active',
        'company_id',
    ];

    public function company() {
        return $this->belongsTo(ProfileCompany::class);
    }

    public function workType() {
        return $this->belongsTo(WorkType::class);
    }

    public function workMethod() {
        return $this->belongsTo(WorkMethod::class);
    }

    public function applications() {
        return $this->hasMany(Application::class);
    }

    public function industry() {
        return $this->belongsTo(Industry::class);
    }

    public function bookmarkedByUsers() {
        return $this->belongsToMany(User::class, 'job_bookmarks', 'job_id', 'user_id')->withTimestamps();
    }
}
