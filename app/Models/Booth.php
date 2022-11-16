<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsTo(User::class,'id', 'owner_id');
    }
    public function menus()
    {
        return $this->hasOne(Menu::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
