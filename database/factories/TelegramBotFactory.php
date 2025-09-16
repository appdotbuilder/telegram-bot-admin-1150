<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TelegramBot>
 */
class TelegramBotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->company() . ' Bot',
            'username' => fake()->userName() . '_bot',
            'token' => fake()->numerify('#########') . ':' . fake()->lexify(str_repeat('?', 35)),
            'description' => fake()->sentence(),
            'is_active' => fake()->boolean(80),
            'settings' => [
                'auto_reply' => fake()->boolean(),
                'welcome_message' => fake()->sentence(),
            ],
        ];
    }

    /**
     * Indicate that the bot is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the bot is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}