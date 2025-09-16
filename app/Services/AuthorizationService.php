<?php

namespace App\Services;

use App\Models\FunctionLock;
use App\Models\User;

class AuthorizationService
{
    /**
     * Check if a user can manage function locks.
     */
    public static function canManageFunctionLocks(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Check if a user can view all bots.
     */
    public static function canViewAllBots(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Check if a user can view all conversations.
     */
    public static function canViewAllConversations(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Check if a user can manage all users.
     */
    public static function canManageAllUsers(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Check if a user can manage users (admin level).
     */
    public static function canManageUsers(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Check if a function is locked for a specific role.
     */
    public static function isFunctionLocked(string $functionName, string $role): bool
    {
        return FunctionLock::where('function_name', $functionName)
            ->where('locked_for_role', $role)
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Get all available functions that can be locked.
     */
    public static function getAvailableFunctions(): array
    {
        return [
            'telegram_bots' => 'Telegram Bot Management',
            'live_chat' => 'Live Chat',
            'user_management' => 'User Management',
            'referral_system' => 'Referral System',
            'broadcast_messages' => 'Broadcast Messages',
            'bot_commands' => 'Bot Commands',
            'bot_keywords' => 'Bot Keywords',
            'analytics' => 'Analytics & Reports',
        ];
    }

    /**
     * Check if a user has specific permission based on their role and function locks.
     */
    public static function hasPermission(User $user, string $permission): bool
    {
        // Super admins always have all permissions
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Check if the function is locked for this user's role
        if (!$user->canAccessFunction($permission)) {
            return false;
        }

        // Role-specific permissions
        switch ($permission) {
            case 'manage_function_locks':
                return $user->isSuperAdmin();
                
            case 'view_all_bots':
            case 'view_all_conversations':
            case 'manage_users':
                return $user->isAdmin();
                
            case 'telegram_bots':
            case 'live_chat':
            case 'referral_system':
                return true; // All users can access these unless locked
                
            default:
                return false;
        }
    }
}