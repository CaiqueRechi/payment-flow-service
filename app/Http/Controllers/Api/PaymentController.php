<?php

namespace App\Http\Controllers\Api;

use App\Actions\Payment\CreatePaymentAction;
use App\Actions\Payment\UpdatePaymentStatusAction;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentStatusRequest;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $payments = Payment::query()
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return PaymentResource::collection($payments);
    }

    public function show(Payment $payment): JsonResponse
    {
        return response()->json($payment);
    }

    public function store(
        StorePaymentRequest $request,
        CreatePaymentAction $action
    ): JsonResponse {
        $payment = $action->execute($request->validated());

        return response()->json($payment, 201);
    }

    public function updateStatus(
        UpdatePaymentStatusRequest $request,
        Payment $payment,
        UpdatePaymentStatusAction $action
    ): JsonResponse {
        $payment = $action->execute(
            $payment,
            PaymentStatusEnum::from($request->validated('status')),
            $request->validated('reason'),
            $request->validated('metadata')
        );

        return response()->json($payment);
    }
}
