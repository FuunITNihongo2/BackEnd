<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'imageable_id',
        'imageable_type',
        'link',
        'updated_at',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'imageable_type',
        'imageable_id',
    ];


    public function Imageable()
    {
        return $this->morphTo();
    }
}
