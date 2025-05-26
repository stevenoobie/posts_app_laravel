<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    public function posts() {
        return $this->belongsToMany(Post::class)->withPivot('platform_status')->withTimestamps();
    }
    
    public function users(){
        return $this->belongsToMany(User::class);
    }

}
