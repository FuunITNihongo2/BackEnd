<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function menus()
    {
        return $this->hasOne(Menu::class);
    }
}
