<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alternative extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * Get all ratings for this alternative.
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
