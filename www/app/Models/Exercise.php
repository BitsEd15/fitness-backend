<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $fillable = [
        'name',
        'short_description',
        'full_description',
        'video_url',
        'image_path',
    ];

    public function trainingTypes()
    {
        return $this->belongsToMany(TrainingType::class);
    }
    public function muscleGroups()
    {
        return $this->belongsToMany(MuscleGroup::class);
    }
}
