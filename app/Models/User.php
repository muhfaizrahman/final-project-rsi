<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function companyProfile() {
        return $this->hasOne(ProfileCompany::class);
    }

    public function bookmarks() {
        return $this->belongsToMany(Job::class, 'job_bookmarks', 'user_id', 'job_id')->withTimestamps();
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function isBookmarked($job): bool {
        return $this->bookmarks()->where('job_id', is_object($job) ? $job->id : $job)->exists();
    }
}
