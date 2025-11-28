<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'full_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->optional()->phoneNumber,
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
            'type' => $this->faker->randomElement(['technical_issues', 'account_billing', 'product_service', 'general_inquiry', 'feedback']),
            'contact_method' => $this->faker->randomElement(['email', 'phone', 'either', 'none']),
            'status' => $this->faker->randomElement(['open', 'noted', 'closed']),
            'notes' => null,
        ];
    }
}
