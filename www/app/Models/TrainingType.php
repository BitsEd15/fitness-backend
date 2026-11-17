<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingType extends Model
{
    protected $fillable = [
        'name',
    ];
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }
}
