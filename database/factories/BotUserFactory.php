<?php

namespace Database\Factories;

use App\Models\TelegramBot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BotUser>
 */
class BotUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'telegram_bot_id' => TelegramBot::factory(),
            'telegram_id' => fake()->numerify('#########'),
            'username' => fake()->userName(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'is_blocked' => fake()->boolean(10), // 10% chance of being blocked
            'last_interaction' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Indicate that the user is blocked.
     */
    public function blocked(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_blocked' => true,
        ]);
    }

    /**
     * Indicate that the user is active (not blocked).
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_blocked' => false,
        ]);
    }
}