import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface Props {
    stats: {
        total_bots: number;
        active_bots: number;
        total_users: number;
        open_conversations: number;
    };
    conversations: Array<{
        id: number;
        subject?: string;
        status: string;
        last_message_at?: string;
        bot_user: {
            id: number;
            display_name: string;
            telegram_id: string;
        };
        telegram_bot: {
            id: number;
            name: string;
        };
        assigned_user?: {
            id: number;
            name: string;
        };
    }>;
    bots: Array<{
        id: number;
        name: string;
        username: string;
        is_active: boolean;
        created_at: string;
        user?: {
            id: number;
            name: string;
        };
    }>;
    referralStats: {
        total_referrals: number;
        referral_code: string;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ stats, conversations, bots, referralStats }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            
            <div className="flex h-full flex-1 flex-col gap-6 p-6">
                {/* Welcome Section */}
                <div className="rounded-xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-6 text-white">
                    <h1 className="text-3xl font-bold mb-2">🚀 Welcome to your Dashboard</h1>
                    <p className="text-indigo-100">
                        Manage your Telegram bots, handle conversations, and track your referrals from one place.
                    </p>
                </div>

                {/* Stats Cards */}
                <div className="grid auto-rows-min gap-6 md:grid-cols-4">
                    <div className="relative overflow-hidden rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Bots</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.total_bots}</p>
                            </div>
                            <div className="text-3xl text-indigo-500">🤖</div>
                        </div>
                    </div>

                    <div className="relative overflow-hidden rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Active Bots</p>
                                <p className="text-3xl font-bold text-green-600 dark:text-green-400">{stats.active_bots}</p>
                            </div>
                            <div className="text-3xl text-green-500">✅</div>
                        </div>
                    </div>

                    <div className="relative overflow-hidden rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Bot Users</p>
                                <p className="text-3xl font-bold text-blue-600 dark:text-blue-400">{stats.total_users}</p>
                            </div>
                            <div className="text-3xl text-blue-500">👥</div>
                        </div>
                    </div>

                    <div className="relative overflow-hidden rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Open Chats</p>
                                <p className="text-3xl font-bold text-orange-600 dark:text-orange-400">{stats.open_conversations}</p>
                            </div>
                            <div className="text-3xl text-orange-500">💬</div>
                        </div>
                    </div>
                </div>

                {/* Main Content Grid */}
                <div className="grid gap-6 lg:grid-cols-2">
                    {/* Recent Conversations */}
                    <div className="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div className="flex items-center justify-between mb-4">
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">💬 Recent Conversations</h2>
                            <Link 
                                href="/chat" 
                                className="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400"
                            >
                                View All
                            </Link>
                        </div>
                        <div className="space-y-3">
                            {conversations.length > 0 ? conversations.map(conversation => (
                                <div key={conversation.id} className="flex items-start justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                                    <div className="flex-1 min-w-0">
                                        <div className="flex items-center gap-2 mb-1">
                                            <span className="text-sm font-medium text-gray-900 dark:text-white">
                                                {conversation.bot_user.display_name}
                                            </span>
                                            <span className={`px-2 py-1 text-xs rounded-full ${
                                                conversation.status === 'open' 
                                                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                    : conversation.status === 'pending'
                                                    ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
                                                    : 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200'
                                            }`}>
                                                {conversation.status}
                                            </span>
                                        </div>
                                        <p className="text-xs text-gray-600 dark:text-gray-400">
                                            Bot: {conversation.telegram_bot.name}
                                        </p>
                                        {conversation.last_message_at && (
                                            <p className="text-xs text-gray-500 dark:text-gray-500">
                                                {new Date(conversation.last_message_at).toLocaleDateString()}
                                            </p>
                                        )}
                                    </div>
                                    <Link
                                        href={`/chat/${conversation.id}`}
                                        className="text-xs text-indigo-600 hover:text-indigo-500 dark:text-indigo-400"
                                    >
                                        View
                                    </Link>
                                </div>
                            )) : (
                                <p className="text-gray-500 dark:text-gray-400 text-center py-4">
                                    No conversations yet
                                </p>
                            )}
                        </div>
                    </div>

                    {/* Recent Bots */}
                    <div className="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div className="flex items-center justify-between mb-4">
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">🤖 Your Bots</h2>
                            <Link 
                                href="/telegram-bots" 
                                className="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400"
                            >
                                Manage Bots
                            </Link>
                        </div>
                        <div className="space-y-3">
                            {bots.length > 0 ? bots.map(bot => (
                                <div key={bot.id} className="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                                    <div className="flex items-center gap-3">
                                        <div className={`w-3 h-3 rounded-full ${bot.is_active ? 'bg-green-500' : 'bg-gray-400'}`}></div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-900 dark:text-white">{bot.name}</p>
                                            <p className="text-xs text-gray-600 dark:text-gray-400">@{bot.username}</p>
                                            {bot.user && (
                                                <p className="text-xs text-gray-500 dark:text-gray-500">by {bot.user.name}</p>
                                            )}
                                        </div>
                                    </div>
                                    <Link
                                        href={`/telegram-bots/${bot.id}`}
                                        className="text-xs text-indigo-600 hover:text-indigo-500 dark:text-indigo-400"
                                    >
                                        View
                                    </Link>
                                </div>
                            )) : (
                                <div className="text-center py-6">
                                    <p className="text-gray-500 dark:text-gray-400 mb-3">No bots created yet</p>
                                    <Link
                                        href="/telegram-bots/create"
                                        className="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700"
                                    >
                                        🤖 Create Your First Bot
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                {/* Referral Section */}
                <div className="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h2 className="text-xl font-semibold text-gray-900 dark:text-white mb-4">🔗 Your Referral Program</h2>
                    <div className="grid gap-4 md:grid-cols-2">
                        <div className="p-4 rounded-lg bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20">
                            <div className="flex items-center gap-3">
                                <div className="text-2xl">👥</div>
                                <div>
                                    <p className="text-lg font-semibold text-green-700 dark:text-green-300">
                                        {referralStats.total_referrals} Referrals
                                    </p>
                                    <p className="text-sm text-green-600 dark:text-green-400">
                                        People you've referred
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="p-4 rounded-lg bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
                            <div>
                                <p className="text-sm font-medium text-blue-700 dark:text-blue-300 mb-2">Your Referral Code:</p>
                                <div className="flex items-center gap-2">
                                    <code className="px-3 py-1 bg-white dark:bg-gray-700 rounded border text-lg font-mono text-blue-700 dark:text-blue-300">
                                        {referralStats.referral_code}
                                    </code>
                                    <button 
                                        onClick={() => navigator.clipboard?.writeText(referralStats.referral_code)}
                                        className="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700"
                                    >
                                        Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Quick Actions */}
                <div className="grid gap-4 md:grid-cols-3">
                    <Link
                        href="/telegram-bots/create"
                        className="flex items-center gap-3 p-4 rounded-xl border-2 border-dashed border-indigo-300 text-indigo-600 hover:border-indigo-400 hover:bg-indigo-50 dark:border-indigo-600 dark:text-indigo-400 dark:hover:bg-indigo-900/20"
                    >
                        <div className="text-2xl">🤖</div>
                        <div>
                            <p className="font-semibold">Create New Bot</p>
                            <p className="text-sm opacity-75">Add a new Telegram bot</p>
                        </div>
                    </Link>

                    <Link
                        href="/chat"
                        className="flex items-center gap-3 p-4 rounded-xl border-2 border-dashed border-purple-300 text-purple-600 hover:border-purple-400 hover:bg-purple-50 dark:border-purple-600 dark:text-purple-400 dark:hover:bg-purple-900/20"
                    >
                        <div className="text-2xl">💬</div>
                        <div>
                            <p className="font-semibold">Live Chat</p>
                            <p className="text-sm opacity-75">View all conversations</p>
                        </div>
                    </Link>

                    <div className="flex items-center gap-3 p-4 rounded-xl border-2 border-dashed border-green-300 text-green-600 dark:border-green-600 dark:text-green-400">
                        <div className="text-2xl">📊</div>
                        <div>
                            <p className="font-semibold">Analytics</p>
                            <p className="text-sm opacity-75">Coming soon...</p>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}