<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    public function booth()
    {
        return $this->belongsTo(Booth::class);
    }
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
