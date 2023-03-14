<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $float = $this->faker->numberBetween(1, 20000);
        $transcation_status = $this->faker->numberBetween(0, 1);
        $s_noti = $this->faker->numberBetween(0, 1);
        $r_noti = $this->faker->numberBetween(0, 1);
        $s_previous_amount = $this->faker->numberBetween(1, 50000);
        $r_previous_amount = $this->faker->numberBetween(1, 50000);
        $s_new_amount = $s_previous_amount - $float;
        $r_new_amount = $r_previous_amount - $float;
        $fee = round($float*0.01, 2);
        $vat = round($float*0.75, 2);
        return [
            'sender_id' => $this->faker->md5(),
            'receiver_id' => $this->faker->md5(),
            'transaction_type' => 'payment',
            'transaction_reference' => $this->faker->regexify('[A-Z]{4}[1-9]{5}'), // password
            'transaction_amount' => $float,
            'transaction_date' => now(),
            'transaction_fee' => $fee,
            'VAT' => $vat,
            'corporate_fee' => '1',
            'sender_notification' => $s_noti,
            'receiver_notification' => $r_noti,
            'sender_previous_amount' => $s_previous_amount,
            'sender_new_amount' => $s_new_amount,
            'receiver_previous_amount' => $r_previous_amount,
            'receiver_new_amount' => $r_new_amount,
            'transaction_status' => $transcation_status,
        ];
    }
}
