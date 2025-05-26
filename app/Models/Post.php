<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',      
        'image_url',
        'scheduled_time',
        'status',
    ];
    protected $casts = [
        'scheduled_time' => 'datetime',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function platforms() {
        return $this->belongsToMany(Platform::class)->withPivot('platform_status')->withTimestamps();
    }
    
}
