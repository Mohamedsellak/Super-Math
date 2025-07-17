<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditHistory extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'action',
        'description',

    ];

    protected $casts = [
        'amount' => 'integer',
    ];

    /**
     * Get the user that owns the credit history.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
