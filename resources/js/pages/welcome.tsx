import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="Welcome - TelegramBot Admin Dashboard">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col items-center bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 p-6 text-gray-900 lg:justify-center lg:p-8 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900 dark:text-gray-100">
                <header className="mb-6 w-full max-w-[335px] text-sm lg:max-w-6xl">
                    <nav className="flex items-center justify-end gap-4">
                        {auth.user ? (
                            <Link
                                href={route('dashboard')}
                                className="inline-block rounded-lg border border-indigo-200 bg-indigo-600 px-6 py-2.5 text-sm font-medium text-white transition-all hover:bg-indigo-700 hover:shadow-lg dark:border-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600"
                            >
                                Go to Dashboard
                            </Link>
                        ) : (
                            <>
                                <Link
                                    href={route('login')}
                                    className="inline-block rounded-lg border border-transparent px-6 py-2.5 text-sm font-medium text-gray-700 transition-all hover:bg-white/50 hover:shadow-md dark:text-gray-300 dark:hover:bg-gray-800/50"
                                >
                                    Log in
                                </Link>
                                <Link
                                    href={route('register')}
                                    className="inline-block rounded-lg border border-indigo-200 bg-indigo-600 px-6 py-2.5 text-sm font-medium text-white transition-all hover:bg-indigo-700 hover:shadow-lg dark:border-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600"
                                >
                                    Get Started
                                </Link>
                            </>
                        )}
                    </nav>
                </header>

                <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow">
                    <main className="flex w-full max-w-6xl flex-col">
                        {/* Hero Section */}
                        <div className="text-center mb-16">
                            <div className="inline-flex items-center gap-2 rounded-full bg-indigo-100 px-4 py-2 text-sm font-medium text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 mb-6">
                                🤖 Advanced Telegram Bot Management
                            </div>
                            <h1 className="mb-6 text-4xl font-bold leading-tight lg:text-6xl">
                                <span className="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 bg-clip-text text-transparent">
                                    TelegramBot
                                </span>
                                <br />
                                Admin Dashboard
                            </h1>
                            <p className="mb-8 text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto leading-relaxed">
                                Complete multi-user admin dashboard with role-based access control. 
                                Manage multiple Telegram bots, handle live chat conversations, 
                                track referrals, and control user permissions - all in one place.
                            </p>
                            
                            {!auth.user && (
                                <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                    <Link
                                        href={route('register')}
                                        className="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-8 py-4 text-lg font-semibold text-white transition-all hover:bg-indigo-700 hover:shadow-xl hover:scale-105 dark:bg-indigo-700 dark:hover:bg-indigo-600"
                                    >
                                        🚀 Start Managing Bots
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="inline-flex items-center gap-2 rounded-lg border-2 border-indigo-600 px-8 py-4 text-lg font-semibold text-indigo-600 transition-all hover:bg-indigo-50 hover:shadow-lg dark:border-indigo-400 dark:text-indigo-400 dark:hover:bg-indigo-900/20"
                                    >
                                        Sign In
                                    </Link>
                                </div>
                            )}
                        </div>

                        {/* Features Grid */}
                        <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3 mb-16">
                            <div className="rounded-xl bg-white/80 backdrop-blur-sm p-6 shadow-lg border border-white/20 dark:bg-gray-800/80 dark:border-gray-700/50">
                                <div className="mb-4 text-3xl">🤖</div>
                                <h3 className="mb-3 text-xl font-semibold">Multi-Bot Management</h3>
                                <p className="text-gray-600 dark:text-gray-400">
                                    Add and manage multiple Telegram bots with custom commands, keywords, 
                                    and automated responses. Each bot operates independently.
                                </p>
                            </div>

                            <div className="rounded-xl bg-white/80 backdrop-blur-sm p-6 shadow-lg border border-white/20 dark:bg-gray-800/80 dark:border-gray-700/50">
                                <div className="mb-4 text-3xl">👥</div>
                                <h3 className="mb-3 text-xl font-semibold">Role-Based Access</h3>
                                <p className="text-gray-600 dark:text-gray-400">
                                    Super Admin, Admin, and User roles with granular permissions. 
                                    Super Admins can lock specific functions for other user roles.
                                </p>
                            </div>

                            <div className="rounded-xl bg-white/80 backdrop-blur-sm p-6 shadow-lg border border-white/20 dark:bg-gray-800/80 dark:border-gray-700/50">
                                <div className="mb-4 text-3xl">💬</div>
                                <h3 className="mb-3 text-xl font-semibold">Live Chat Support</h3>
                                <p className="text-gray-600 dark:text-gray-400">
                                    Real-time chat interface allowing bot users to initiate conversations 
                                    and admins to respond directly from the dashboard.
                                </p>
                            </div>

                            <div className="rounded-xl bg-white/80 backdrop-blur-sm p-6 shadow-lg border border-white/20 dark:bg-gray-800/80 dark:border-gray-700/50">
                                <div className="mb-4 text-3xl">🎯</div>
                                <h3 className="mb-3 text-xl font-semibold">Smart Commands</h3>
                                <p className="text-gray-600 dark:text-gray-400">
                                    Create custom commands with text responses, images, and interactive 
                                    keyboards. Keyword-based auto-replies with priority matching.
                                </p>
                            </div>

                            <div className="rounded-xl bg-white/80 backdrop-blur-sm p-6 shadow-lg border border-white/20 dark:bg-gray-800/80 dark:border-gray-700/50">
                                <div className="mb-4 text-3xl">🔗</div>
                                <h3 className="mb-3 text-xl font-semibold">Referral System</h3>
                                <p className="text-gray-600 dark:text-gray-400">
                                    Built-in referral tracking with unique shareable codes for each user. 
                                    Monitor referral performance and growth metrics.
                                </p>
                            </div>

                            <div className="rounded-xl bg-white/80 backdrop-blur-sm p-6 shadow-lg border border-white/20 dark:bg-gray-800/80 dark:border-gray-700/50">
                                <div className="mb-4 text-3xl">📡</div>
                                <h3 className="mb-3 text-xl font-semibold">Broadcast Messages</h3>
                                <p className="text-gray-600 dark:text-gray-400">
                                    Send targeted messages to all users who have interacted with 
                                    specific bots. Support for text, images, and rich media.
                                </p>
                            </div>
                        </div>

                        {/* User Roles Section */}
                        <div className="rounded-2xl bg-white/90 backdrop-blur-sm p-8 shadow-xl border border-white/30 dark:bg-gray-800/90 dark:border-gray-700/50 mb-16">
                            <h2 className="text-3xl font-bold text-center mb-8">User Role System</h2>
                            <div className="grid gap-6 md:grid-cols-3">
                                <div className="text-center">
                                    <div className="mb-4 text-4xl">👑</div>
                                    <h3 className="text-xl font-semibold mb-2 text-purple-600 dark:text-purple-400">Super Admin</h3>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Full system access. Can lock functions, manage all users, 
                                        and control platform-wide settings.
                                    </p>
                                </div>
                                <div className="text-center">
                                    <div className="mb-4 text-4xl">🛡️</div>
                                    <h3 className="text-xl font-semibold mb-2 text-blue-600 dark:text-blue-400">Admin</h3>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Manage bots, view all conversations, handle user support, 
                                        and access analytics across the platform.
                                    </p>
                                </div>
                                <div className="text-center">
                                    <div className="mb-4 text-4xl">👤</div>
                                    <h3 className="text-xl font-semibold mb-2 text-green-600 dark:text-green-400">User</h3>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Create and manage their own bots, handle conversations, 
                                        and access personal analytics and referrals.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* CTA Section */}
                        <div className="text-center">
                            <h2 className="text-3xl font-bold mb-4">Ready to Get Started?</h2>
                            <p className="text-xl text-gray-600 dark:text-gray-400 mb-8 max-w-2xl mx-auto">
                                Join thousands of users who trust our platform to manage their 
                                Telegram bot operations efficiently and securely.
                            </p>
                            {!auth.user && (
                                <Link
                                    href={route('register')}
                                    className="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-4 text-lg font-semibold text-white transition-all hover:shadow-xl hover:scale-105"
                                >
                                    🎉 Create Your Account
                                </Link>
                            )}
                        </div>

                        <footer className="mt-16 text-center text-sm text-gray-500 dark:text-gray-400">
                            <p>
                                Built with 🚀 by{" "}
                                <a 
                                    href="https://app.build" 
                                    target="_blank" 
                                    className="font-medium text-indigo-600 hover:underline dark:text-indigo-400"
                                >
                                    app.build
                                </a>
                                {" "}- Secure, scalable, and enterprise-ready.
                            </p>
                        </footer>
                    </main>
                </div>
            </div>
        </>
    );
}