<?php

namespace App\Actions\Payment;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;

class CreatePaymentAction
{
    public function execute(array $data): Payment
    {
        $data['status'] = PaymentStatusEnum::PENDING;

        return Payment::create($data);
    }
}
