<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    
    // Relación Many To One / Muchos a Uno
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // Relación Many To One / Muchos a Uno
    public function image() {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
