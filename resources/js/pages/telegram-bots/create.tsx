import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import React, { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Telegram Bots',
        href: '/telegram-bots',
    },
    {
        title: 'Create Bot',
        href: '/telegram-bots/create',
    },
];

export default function CreateTelegramBot() {
    const [isActive, setIsActive] = useState(true);
    
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        username: '',
        token: '',
        description: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('telegram-bots.store'), {
            onBefore: () => setData(prev => ({ ...prev, is_active: isActive }))
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Telegram Bot" />
            
            <div className="flex h-full flex-1 flex-col gap-6 p-6">
                <div>
                    <h1 className="text-2xl font-bold text-gray-900 dark:text-white">🤖 Create New Telegram Bot</h1>
                    <p className="text-gray-600 dark:text-gray-400">
                        Add a new Telegram bot to start managing commands and conversations
                    </p>
                </div>

                <div className="max-w-2xl">
                    <form onSubmit={handleSubmit} className="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div className="space-y-6">
                            <div>
                                <label htmlFor="name" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Bot Name *
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    placeholder="My Awesome Bot"
                                />
                                {errors.name && (
                                    <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.name}</p>
                                )}
                            </div>

                            <div>
                                <label htmlFor="username" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Bot Username *
                                </label>
                                <div className="relative">
                                    <div className="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span className="text-gray-500 dark:text-gray-400">@</span>
                                    </div>
                                    <input
                                        type="text"
                                        id="username"
                                        value={data.username}
                                        onChange={(e) => setData('username', e.target.value)}
                                        className="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                        placeholder="my_awesome_bot"
                                    />
                                </div>
                                {errors.username && (
                                    <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.username}</p>
                                )}
                            </div>

                            <div>
                                <label htmlFor="token" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Bot Token *
                                </label>
                                <input
                                    type="password"
                                    id="token"
                                    value={data.token}
                                    onChange={(e) => setData('token', e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    placeholder="123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZ"
                                />
                                {errors.token && (
                                    <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.token}</p>
                                )}
                                <p className="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Get your bot token from @BotFather on Telegram
                                </p>
                            </div>

                            <div>
                                <label htmlFor="description" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Description
                                </label>
                                <textarea
                                    id="description"
                                    rows={3}
                                    value={data.description}
                                    onChange={(e) => setData('description', e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    placeholder="Brief description of your bot's purpose..."
                                />
                                {errors.description && (
                                    <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.description}</p>
                                )}
                            </div>

                            <div className="flex items-center">
                                <input
                                    type="checkbox"
                                    id="is_active"
                                    checked={isActive}
                                    onChange={(e) => setIsActive(e.target.checked)}
                                    className="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                />
                                <label htmlFor="is_active" className="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    Bot is active and ready to receive messages
                                </label>
                            </div>
                        </div>

                        <div className="flex items-center gap-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                            <button
                                type="submit"
                                disabled={processing}
                                className="inline-flex items-center gap-2 px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            >
                                {processing ? '⏳ Creating...' : '🚀 Create Bot'}
                            </button>
                            <button
                                type="button"
                                onClick={() => window.history.back()}
                                className="px-6 py-2 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 transition-colors"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>

                {/* Help Section */}
                <div className="max-w-2xl mt-6">
                    <div className="rounded-xl border border-blue-200 bg-blue-50 p-6 dark:border-blue-800 dark:bg-blue-900/20">
                        <h3 className="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-3">
                            🤔 How to create a Telegram Bot
                        </h3>
                        <ol className="space-y-2 text-sm text-blue-700 dark:text-blue-300">
                            <li>1. Open Telegram and search for @BotFather</li>
                            <li>2. Send the command /newbot</li>
                            <li>3. Choose a name for your bot</li>
                            <li>4. Choose a username ending in "bot"</li>
                            <li>5. Copy the token and paste it above</li>
                            <li>6. Your bot is ready to go! 🎉</li>
                        </ol>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}