<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criterion extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'weight',
        'type',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    /**
     * Get the category that owns this criterion.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all ratings for this criterion.
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
