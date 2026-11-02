<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicePrice extends Model
{
    protected $fillable = [
        'label',
        'sessions_count',
        'price'
    ];

    protected $casts = [
        'sessions_count' => 'integer',
        'price' => 'integer'
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
