<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case PAID = 'paid';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';

    public function canTransitionTo(self $status): bool
    {
        if ($this === $status) {
            return true;
        }

        return match ($this) {
            self::PENDING => in_array($status, [
                self::PROCESSING,
                self::PAID,
                self::FAILED,
                self::CANCELLED,
            ], true),
            self::PROCESSING => in_array($status, [
                self::PAID,
                self::FAILED,
                self::CANCELLED,
            ], true),
            self::PAID => $status === self::REFUNDED,
            self::FAILED, self::CANCELLED, self::REFUNDED => false,
        };
    }
}
