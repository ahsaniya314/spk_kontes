<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $fillable = [
        'criterion_id',
        'alternative_id',
        'user_id',
        'value',
    ];

    protected $casts = [
        'value' => 'decimal:2',
    ];

    /**
     * Get the criterion that owns this rating.
     */
    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }

    /**
     * Get the alternative that owns this rating.
     */
    public function alternative(): BelongsTo
    {
        return $this->belongsTo(Alternative::class);
    }

    /**
     * Get the user (juri) that owns this rating.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
