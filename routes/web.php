<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FunctionLockController;
use App\Http\Controllers\TelegramBotController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Telegram Bots Management
    Route::resource('telegram-bots', TelegramBotController::class);

    // Live Chat System
    Route::controller(ChatController::class)->group(function () {
        Route::get('/chat', 'index')->name('chat.index');
        Route::get('/chat/{conversation}', 'show')->name('chat.show');
        Route::post('/chat/{conversation}/messages', 'store')->name('chat.messages.store');
        Route::patch('/chat/{conversation}', 'update')->name('chat.update');
    });

    // Function Locks (Super Admin only)
    Route::middleware(['can:manage-function-locks'])->group(function () {
        Route::controller(FunctionLockController::class)->group(function () {
            Route::get('/function-locks', 'index')->name('function-locks.index');
            Route::post('/function-locks', 'store')->name('function-locks.store');
            Route::delete('/function-locks/{functionLock}', 'destroy')->name('function-locks.destroy');

        });
    });

    // User Management (Admin+)
    Route::middleware(['can:manage-users'])->group(function () {
        Route::get('/users', function () {
            return Inertia::render('users/index');
        })->name('users.index');
    });

    // Referral System
    Route::get('/referrals', function () {
        return Inertia::render('referrals/index');
    })->name('referrals.index');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';