<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
