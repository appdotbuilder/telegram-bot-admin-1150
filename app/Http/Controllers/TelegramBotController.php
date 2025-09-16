<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTelegramBotRequest;
use App\Http\Requests\UpdateTelegramBotRequest;
use App\Models\TelegramBot;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TelegramBotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!$request->user()->canAccessFunction('telegram_bots')) {
            abort(403, 'Access denied to Telegram Bot management.');
        }

        $bots = TelegramBot::with('user')
            ->when(!$request->user()->isAdmin(), function ($query) use ($request) {
                return $query->where('user_id', $request->user()->id);
            })
            ->latest()
            ->paginate(10);

        return Inertia::render('telegram-bots/index', [
            'bots' => $bots
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (!$request->user()->canAccessFunction('telegram_bots')) {
            abort(403, 'Access denied to Telegram Bot management.');
        }

        return Inertia::render('telegram-bots/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTelegramBotRequest $request)
    {
        if (!$request->user()->canAccessFunction('telegram_bots')) {
            abort(403, 'Access denied to Telegram Bot management.');
        }

        $bot = $request->user()->telegramBots()->create($request->validated());

        return redirect()->route('telegram-bots.show', $bot)
            ->with('success', 'Telegram bot created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TelegramBot $telegramBot, Request $request)
    {
        if (!$request->user()->canAccessFunction('telegram_bots')) {
            abort(403, 'Access denied to Telegram Bot management.');
        }

        if (!$request->user()->isAdmin() && $telegramBot->user_id !== $request->user()->id) {
            abort(403, 'You can only view your own bots.');
        }

        $telegramBot->load(['commands', 'keywords', 'botUsers', 'conversations.botUser']);

        return Inertia::render('telegram-bots/show', [
            'bot' => $telegramBot
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TelegramBot $telegramBot, Request $request)
    {
        if (!$request->user()->canAccessFunction('telegram_bots')) {
            abort(403, 'Access denied to Telegram Bot management.');
        }

        if (!$request->user()->isAdmin() && $telegramBot->user_id !== $request->user()->id) {
            abort(403, 'You can only edit your own bots.');
        }

        return Inertia::render('telegram-bots/edit', [
            'bot' => $telegramBot
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTelegramBotRequest $request, TelegramBot $telegramBot)
    {
        if (!$request->user()->canAccessFunction('telegram_bots')) {
            abort(403, 'Access denied to Telegram Bot management.');
        }

        if (!$request->user()->isAdmin() && $telegramBot->user_id !== $request->user()->id) {
            abort(403, 'You can only edit your own bots.');
        }

        $telegramBot->update($request->validated());

        return redirect()->route('telegram-bots.show', $telegramBot)
            ->with('success', 'Telegram bot updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TelegramBot $telegramBot, Request $request)
    {
        if (!$request->user()->canAccessFunction('telegram_bots')) {
            abort(403, 'Access denied to Telegram Bot management.');
        }

        if (!$request->user()->isAdmin() && $telegramBot->user_id !== $request->user()->id) {
            abort(403, 'You can only delete your own bots.');
        }

        $telegramBot->delete();

        return redirect()->route('telegram-bots.index')
            ->with('success', 'Telegram bot deleted successfully.');
    }
}