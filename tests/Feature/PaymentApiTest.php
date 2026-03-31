<?php

namespace Tests\Feature;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_payment(): void
    {
        $payload = [
            'external_id' => 'pay_test_001',
            'customer_name' => 'Caique',
            'customer_email' => 'caique@email.com',
            'amount' => 150.50,
            'currency' => 'BRL',
            'payment_method' => 'pix',
            'description' => 'Test payment',
        ];

        $response = $this->postJson('/api/payments', $payload);

        $response->assertCreated()
            ->assertJsonPath('status', 'pending');

        $this->assertDatabaseHas('payments', [
            'external_id' => 'pay_test_001',
            'status' => 'pending',
        ]);
    }

    public function test_it_updates_payment_status(): void
    {
        $payment = Payment::factory()->create([
            'status' => PaymentStatusEnum::PENDING,
        ]);

        $response = $this->patchJson(
            "/api/payments/{$payment->id}/status",
            [
                'status' => 'paid',
                'reason' => 'Webhook confirmation',
                'metadata' => [
                    'gateway' => 'stripe',
                ],
            ]
        );

        $response->assertOk()
            ->assertJsonPath('status', 'paid');

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'paid',
        ]);

        $this->assertDatabaseHas('payment_status_histories', [
            'payment_id' => $payment->id,
            'to_status' => 'paid',
        ]);
    }

    public function test_it_lists_payments(): void
    {
        Payment::factory()->count(3)->create();

        $response = $this->getJson('/api/payments');

        $response->assertOk()
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function test_it_shows_a_payment(): void
    {
        $payment = Payment::factory()->create();

        $response = $this->getJson("/api/payments/{$payment->id}");

        $response->assertOk()
            ->assertJsonPath('id', $payment->id);
    }
}
