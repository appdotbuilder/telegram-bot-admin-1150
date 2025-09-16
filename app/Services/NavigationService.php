<?php

namespace App\Services;

use App\Models\User;

class NavigationService
{
    /**
     * Get navigation items based on user role and permissions.
     */
    public static function getNavigationItems(User $user): array
    {
        $items = [];

        // Dashboard (always available)
        $items[] = [
            'title' => 'Dashboard',
            'icon' => '📊',
            'url' => '/dashboard',
            'active' => request()->routeIs('dashboard'),
        ];

        // Telegram Bots Management
        if ($user->canAccessFunction('telegram_bots')) {
            $items[] = [
                'title' => 'Telegram Bots',
                'icon' => '🤖',
                'url' => '/telegram-bots',
                'active' => request()->routeIs('telegram-bots.*'),
            ];
        }

        // Live Chat
        if ($user->canAccessFunction('live_chat')) {
            $items[] = [
                'title' => 'Live Chat',
                'icon' => '💬',
                'url' => '/chat',
                'active' => request()->routeIs('chat.*'),
            ];
        }

        // User Management (Admin+)
        if (AuthorizationService::canManageUsers($user)) {
            $items[] = [
                'title' => 'Users',
                'icon' => '👥',
                'url' => '/users',
                'active' => request()->routeIs('users.*'),
            ];
        }

        // Referral System
        if ($user->canAccessFunction('referral_system')) {
            $items[] = [
                'title' => 'Referrals',
                'icon' => '🔗',
                'url' => '/referrals',
                'active' => request()->routeIs('referrals.*'),
            ];
        }

        // Function Locks (Super Admin only)
        if (AuthorizationService::canManageFunctionLocks($user)) {
            $items[] = [
                'title' => 'Function Locks',
                'icon' => '🔒',
                'url' => '/function-locks',
                'active' => request()->routeIs('function-locks.*'),
            ];
        }

        // Analytics (if available)
        if ($user->canAccessFunction('analytics')) {
            $items[] = [
                'title' => 'Analytics',
                'icon' => '📈',
                'url' => '/analytics',
                'active' => request()->routeIs('analytics.*'),
            ];
        }

        return $items;
    }

    /**
     * Get user role badge information.
     */
    public static function getUserRoleBadge(User $user): array
    {
        $roleConfig = [
            'super_admin' => [
                'label' => 'Super Admin',
                'color' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                'icon' => '👑',
            ],
            'admin' => [
                'label' => 'Admin',
                'color' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                'icon' => '🛡️',
            ],
            'user' => [
                'label' => 'User',
                'color' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                'icon' => '👤',
            ],
        ];

        return $roleConfig[$user->role] ?? $roleConfig['user'];
    }

    /**
     * Get quick actions based on user permissions.
     */
    public static function getQuickActions(User $user): array
    {
        $actions = [];

        if ($user->canAccessFunction('telegram_bots')) {
            $actions[] = [
                'title' => 'Create Bot',
                'description' => 'Add a new Telegram bot',
                'icon' => '🤖',
                'url' => '/telegram-bots/create',
                'color' => 'indigo',
            ];
        }

        if ($user->canAccessFunction('live_chat')) {
            $actions[] = [
                'title' => 'View Chats',
                'description' => 'Check live conversations',
                'icon' => '💬',
                'url' => '/chat',
                'color' => 'purple',
            ];
        }

        if (AuthorizationService::canManageUsers($user)) {
            $actions[] = [
                'title' => 'Manage Users',
                'description' => 'User administration',
                'icon' => '👥',
                'url' => '/users',
                'color' => 'blue',
            ];
        }

        if ($user->canAccessFunction('referral_system')) {
            $actions[] = [
                'title' => 'My Referrals',
                'description' => 'Track your referrals',
                'icon' => '🔗',
                'url' => '/referrals',
                'color' => 'green',
            ];
        }

        return $actions;
    }
}