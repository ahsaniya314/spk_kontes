<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get all criteria for this category.
     */
    public function criteria(): HasMany
    {
        return $this->hasMany(Criterion::class);
    }
}
