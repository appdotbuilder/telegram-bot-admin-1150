import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface ChatConversation {
    id: number;
    subject?: string;
    status: 'open' | 'closed' | 'pending';
    last_message_at?: string;
    created_at: string;
    bot_user: {
        id: number;
        display_name: string;
        telegram_id: string;
        username?: string;
    };
    telegram_bot: {
        id: number;
        name: string;
        username: string;
    };
    assigned_user?: {
        id: number;
        name: string;
    };
}

interface Props {
    conversations: {
        data: ChatConversation[];
        links: Record<string, unknown>;
        meta: Record<string, unknown>;
    };
    filters: {
        status?: string;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Live Chat',
        href: '/chat',
    },
];

const statusConfig = {
    open: { color: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200', emoji: '💬', label: 'Open' },
    pending: { color: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', emoji: '⏳', label: 'Pending' },
    closed: { color: 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200', emoji: '✅', label: 'Closed' },
};

export default function ChatIndex({ conversations, filters }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Live Chat" />
            
            <div className="flex h-full flex-1 flex-col gap-6 p-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900 dark:text-white">💬 Live Chat Conversations</h1>
                        <p className="text-gray-600 dark:text-gray-400">
                            Manage conversations from all your Telegram bots
                        </p>
                    </div>

                    {/* Filter Buttons */}
                    <div className="flex items-center gap-2">
                        <Link
                            href="/chat"
                            className={`px-3 py-1.5 text-sm font-medium rounded-lg transition-colors ${
                                !filters.status
                                    ? 'bg-indigo-600 text-white'
                                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600'
                            }`}
                        >
                            All
                        </Link>
                        <Link
                            href="/chat?status=open"
                            className={`px-3 py-1.5 text-sm font-medium rounded-lg transition-colors ${
                                filters.status === 'open'
                                    ? 'bg-green-600 text-white'
                                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600'
                            }`}
                        >
                            Open
                        </Link>
                        <Link
                            href="/chat?status=pending"
                            className={`px-3 py-1.5 text-sm font-medium rounded-lg transition-colors ${
                                filters.status === 'pending'
                                    ? 'bg-yellow-600 text-white'
                                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600'
                            }`}
                        >
                            Pending
                        </Link>
                        <Link
                            href="/chat?status=closed"
                            className={`px-3 py-1.5 text-sm font-medium rounded-lg transition-colors ${
                                filters.status === 'closed'
                                    ? 'bg-gray-600 text-white'
                                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600'
                            }`}
                        >
                            Closed
                        </Link>
                    </div>
                </div>

                <div className="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    {conversations.data.length > 0 ? (
                        <div className="divide-y divide-gray-200 dark:divide-gray-700">
                            {conversations.data.map((conversation) => {
                                const statusInfo = statusConfig[conversation.status];
                                return (
                                    <div key={conversation.id} className="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <div className="flex items-start justify-between">
                                            <div className="flex items-start gap-4 flex-1">
                                                <div className="text-3xl">👤</div>
                                                <div className="flex-1">
                                                    <div className="flex items-center gap-3 mb-2">
                                                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
                                                            {conversation.bot_user.display_name}
                                                        </h3>
                                                        <span className={`inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full ${statusInfo.color}`}>
                                                            {statusInfo.emoji} {statusInfo.label}
                                                        </span>
                                                    </div>
                                                    
                                                    <div className="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                                                        <div className="flex items-center gap-4">
                                                            <span>📱 Telegram ID: {conversation.bot_user.telegram_id}</span>
                                                            {conversation.bot_user.username && (
                                                                <span>🔗 @{conversation.bot_user.username}</span>
                                                            )}
                                                        </div>
                                                        <div className="flex items-center gap-4">
                                                            <span>🤖 Bot: {conversation.telegram_bot.name}</span>
                                                            <span>📅 Started: {new Date(conversation.created_at).toLocaleDateString()}</span>
                                                        </div>
                                                        {conversation.last_message_at && (
                                                            <div>
                                                                💬 Last message: {new Date(conversation.last_message_at).toLocaleString()}
                                                            </div>
                                                        )}
                                                        {conversation.assigned_user && (
                                                            <div>
                                                                👨‍💼 Assigned to: {conversation.assigned_user.name}
                                                            </div>
                                                        )}
                                                    </div>

                                                    {conversation.subject && (
                                                        <div className="mt-2 p-2 bg-blue-50 dark:bg-blue-900/20 rounded text-sm">
                                                            <strong>Subject:</strong> {conversation.subject}
                                                        </div>
                                                    )}
                                                </div>
                                            </div>

                                            <div className="flex flex-col items-end gap-2">
                                                <Link
                                                    href={`/chat/${conversation.id}`}
                                                    className="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors"
                                                >
                                                    💬 View Chat
                                                </Link>
                                                <div className="text-xs text-gray-500 dark:text-gray-400">
                                                    ID: #{conversation.id}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    ) : (
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">💬</div>
                            <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                No conversations yet
                            </h3>
                            <p className="text-gray-500 dark:text-gray-400 mb-6">
                                {filters.status 
                                    ? `No ${filters.status} conversations found`
                                    : "Conversations will appear here when users interact with your bots"
                                }
                            </p>
                            <div className="space-y-2">
                                <p className="text-sm text-gray-600 dark:text-gray-400">
                                    💡 <strong>Tip:</strong> Make sure your bots are active and have webhook configured
                                </p>
                                <Link
                                    href="/telegram-bots"
                                    className="inline-flex items-center gap-2 px-4 py-2 text-indigo-600 font-medium hover:text-indigo-500"
                                >
                                    🤖 Manage Your Bots
                                </Link>
                            </div>
                        </div>
                    )}
                </div>

                {/* Quick Stats */}
                <div className="grid gap-4 md:grid-cols-3">
                    <div className="p-4 rounded-lg bg-green-50 dark:bg-green-900/20">
                        <div className="flex items-center gap-3">
                            <div className="text-2xl">💬</div>
                            <div>
                                <p className="text-lg font-semibold text-green-700 dark:text-green-300">
                                    {conversations.data.filter(c => c.status === 'open').length} Open
                                </p>
                                <p className="text-sm text-green-600 dark:text-green-400">
                                    Active conversations
                                </p>
                            </div>
                        </div>
                    </div>

                    <div className="p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/20">
                        <div className="flex items-center gap-3">
                            <div className="text-2xl">⏳</div>
                            <div>
                                <p className="text-lg font-semibold text-yellow-700 dark:text-yellow-300">
                                    {conversations.data.filter(c => c.status === 'pending').length} Pending
                                </p>
                                <p className="text-sm text-yellow-600 dark:text-yellow-400">
                                    Awaiting response
                                </p>
                            </div>
                        </div>
                    </div>

                    <div className="p-4 rounded-lg bg-gray-50 dark:bg-gray-800">
                        <div className="flex items-center gap-3">
                            <div className="text-2xl">✅</div>
                            <div>
                                <p className="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                    {conversations.data.filter(c => c.status === 'closed').length} Closed
                                </p>
                                <p className="text-sm text-gray-600 dark:text-gray-400">
                                    Resolved conversations
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}