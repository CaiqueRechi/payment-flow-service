<?php

namespace App\Actions\Payment;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use App\Models\PaymentStatusHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UpdatePaymentStatusAction
{
    public function execute(
        Payment $payment,
        PaymentStatusEnum $newStatus,
        ?string $reason = null,
        ?array $metadata = null
    ): Payment {
        $currentStatus = $payment->status;

        if ($currentStatus === $newStatus) {
            return $payment->refresh();
        }

        if (! $currentStatus->canTransitionTo($newStatus)) {
            throw ValidationException::withMessages([
                'status' => sprintf(
                    'Payment status cannot transition from %s to %s.',
                    $currentStatus->value,
                    $newStatus->value,
                ),
            ]);
        }

        return DB::transaction(function () use (
            $payment,
            $currentStatus,
            $newStatus,
            $reason,
            $metadata
        ): Payment {
            $payment->update([
                'status' => $newStatus,
                'paid_at' => $newStatus === PaymentStatusEnum::PAID
                    ? now()
                    : $payment->paid_at,
            ]);

            PaymentStatusHistory::create([
                'payment_id' => $payment->id,
                'from_status' => $currentStatus->value,
                'to_status' => $newStatus->value,
                'reason' => $reason,
                'metadata' => $metadata,
            ]);

            return $payment->refresh();
        });
    }
}
