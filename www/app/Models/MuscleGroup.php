<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MuscleGroup extends Model
{
    protected $fillable = [
        'name',
        'parent_id'
    ];
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }
    public function parent()
    {
        return $this->belongsTo(MuscleGroup::class,'parent_id');
    }
    public function children()
    {
        return $this->hasMany(MuscleGroup::class,'parent_id');
    }
}
