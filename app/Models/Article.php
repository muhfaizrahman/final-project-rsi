<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'content', 
        'author', 'author_bio', 'image_thumbnail_url'
    ];
    
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
