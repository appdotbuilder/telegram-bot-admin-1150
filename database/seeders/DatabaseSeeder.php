<?php

namespace Database\Seeders;

use App\Models\BotUser;
use App\Models\ChatConversation;
use App\Models\TelegramBot;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => 'super_admin',
        ]);

        // Create Admins
        $admin1 = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $admin2 = User::factory()->create([
            'name' => 'John Admin',
            'email' => 'john@example.com',
            'role' => 'admin',
        ]);

        // Create regular users with referral relationships
        $user1 = User::factory()->create([
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'role' => 'user',
            'referred_by' => $admin1->referral_code,
        ]);

        $user2 = User::factory()->create([
            'name' => 'Bob Smith',
            'email' => 'bob@example.com',
            'role' => 'user',
            'referred_by' => $user1->referral_code,
        ]);

        $user3 = User::factory()->create([
            'name' => 'Carol Brown',
            'email' => 'carol@example.com',
            'role' => 'user',
        ]);

        // Create more regular users
        User::factory(15)->create([
            'role' => 'user',
        ]);

        // Create Telegram bots for different users
        $bot1 = TelegramBot::factory()->create([
            'user_id' => $admin1->id,
            'name' => 'Customer Support Bot',
            'username' => 'customer_support_bot',
            'description' => 'Handles customer inquiries and support requests',
            'is_active' => true,
        ]);

        $bot2 = TelegramBot::factory()->create([
            'user_id' => $user1->id,
            'name' => 'Sales Bot',
            'username' => 'sales_assistant_bot',
            'description' => 'Helps with sales inquiries and product information',
            'is_active' => true,
        ]);

        $bot3 = TelegramBot::factory()->create([
            'user_id' => $user2->id,
            'name' => 'News Bot',
            'username' => 'daily_news_bot',
            'description' => 'Provides daily news updates and alerts',
            'is_active' => false,
        ]);

        // Create more bots
        TelegramBot::factory(10)->create();

        // Create bot users (people who interact with the bots)
        $botUsers = BotUser::factory(50)->create();

        // Create conversations
        ChatConversation::factory(30)
            ->recycle($botUsers)
            ->recycle(TelegramBot::all())
            ->create();

        // Create some specific open conversations for testing
        ChatConversation::factory(10)
            ->open()
            ->recycle($botUsers)
            ->recycle(TelegramBot::all())
            ->create([
                'assigned_to' => fake()->randomElement([$admin1->id, $admin2->id, null]),
            ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Super Admin: superadmin@example.com');
        $this->command->info('Admin: admin@example.com');
        $this->command->info('User: alice@example.com');
        $this->command->info('Password for all: password');
    }
}