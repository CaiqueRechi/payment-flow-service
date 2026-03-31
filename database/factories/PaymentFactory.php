<?php

namespace Database\Factories;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'external_id' => (string) Str::uuid(),
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'amount' => fake()->randomFloat(2, 10, 1000),
            'currency' => 'BRL',
            'status' => PaymentStatusEnum::PENDING,
            'payment_method' => fake()->randomElement(['pix', 'credit_card', 'boleto']),
            'description' => fake()->sentence(),
            'paid_at' => null,
        ];
    }
}
