<?php

namespace Database\Factories;

use App\Models\BotUser;
use App\Models\TelegramBot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChatConversation>
 */
class ChatConversationFactory extends Factory
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
            'bot_user_id' => BotUser::factory(),
            'subject' => fake()->boolean(60) ? fake()->sentence() : null,
            'status' => fake()->randomElement(['open', 'closed', 'pending']),
            'assigned_to' => fake()->boolean(50) ? User::factory() : null,
            'last_message_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ];
    }

    /**
     * Indicate that the conversation is open.
     */
    public function open(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'open',
        ]);
    }

    /**
     * Indicate that the conversation is closed.
     */
    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'closed',
        ]);
    }

    /**
     * Indicate that the conversation is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }
}