<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentAttempt extends Model
{
    protected $fillable = [
        'payment_id',
        'attempt_number',
        'gateway',
        'status',
        'transaction_id',
        'response_message',
        'payload',
        'gateway_response',
        'processed_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'gateway_response' => 'array',
        'processed_at' => 'datetime',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
