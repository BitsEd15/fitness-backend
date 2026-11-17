<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'text',
        'image_path',
        'is_active',
    ];
    protected $casts = [ // разницу между типом в базе данных и типом в PHP.
        'is_active'=>'boolean',
    ];
}
