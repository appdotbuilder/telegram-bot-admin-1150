<?php

namespace App\Http\Controllers;

use App\Models\BotUser;
use App\Models\ChatConversation;
use App\Models\TelegramBot;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get statistics based on user role
        $stats = [
            'total_bots' => $user->isAdmin() ? TelegramBot::count() : $user->telegramBots()->count(),
            'active_bots' => $user->isAdmin() ? TelegramBot::where('is_active', true)->count() : $user->telegramBots()->where('is_active', true)->count(),
            'total_users' => $user->isAdmin() ? BotUser::count() : BotUser::whereHas('telegramBot', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count(),
            'open_conversations' => $user->isAdmin() ? ChatConversation::open()->count() : ChatConversation::whereHas('telegramBot', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->open()->count(),
        ];

        // Get recent conversations
        $conversations = ChatConversation::with(['botUser', 'telegramBot', 'assignedUser'])
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                return $query->whereHas('telegramBot', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })
            ->latest('last_message_at')
            ->limit(10)
            ->get();

        // Get recent bots
        $bots = TelegramBot::with('user')
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->latest()
            ->limit(5)
            ->get();

        // Get referral stats for current user
        $referralStats = [
            'total_referrals' => $user->referrals()->count(),
            'referral_code' => $user->referral_code,
        ];

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'conversations' => $conversations,
            'bots' => $bots,
            'referralStats' => $referralStats,
        ]);
    }
}