<?php

namespace App\Actions\Payment;

use App\Models\Payment;
use App\Models\PaymentStatusHistory;
use App\Enums\PaymentStatusEnum;

class UpdatePaymentStatusAction
{
    public function execute(
        Payment $payment,
        PaymentStatusEnum $newStatus,
        ?string $reason = null,
        ?array $metadata = null
    ): Payment {
        PaymentStatusHistory::create([
            'payment_id' => $payment->id,
            'from_status' => $payment->status?->value,
            'to_status' => $newStatus->value,
            'reason' => $reason,
            'metadata' => $metadata,
        ]);

        $payment->update([
            'status' => $newStatus,
            'paid_at' => $newStatus === PaymentStatusEnum::PAID
                ? now()
                : $payment->paid_at,
        ]);

        return $payment->refresh();
    }
}
