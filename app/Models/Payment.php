<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\PaymentStatusEnum;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'customer_name',
        'customer_email',
        'amount',
        'currency',
        'status',
        'payment_method',
        'description',
        'paid_at',
    ];

    protected $casts = [
        'status' => PaymentStatusEnum::class,
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function attempts(): HasMany
    {
        return $this->hasMany(PaymentAttempt::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(PaymentStatusHistory::class);
    }

    public function webhookEvents(): HasMany
    {
        return $this->hasMany(WebhookEvent::class);
    }
}
