<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFunctionLockRequest;
use App\Models\FunctionLock;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FunctionLockController extends Controller
{
    /**
     * Display a listing of function locks.
     */
    public function index(Request $request)
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Only Super Admins can manage function locks.');
        }

        $locks = FunctionLock::with('creator')
            ->latest()
            ->paginate(15);

        $availableFunctions = [
            'telegram_bots' => 'Telegram Bot Management',
            'live_chat' => 'Live Chat',
            'user_management' => 'User Management',
            'referral_system' => 'Referral System',
            'broadcast_messages' => 'Broadcast Messages',
            'bot_commands' => 'Bot Commands',
            'bot_keywords' => 'Bot Keywords',
            'analytics' => 'Analytics & Reports',
        ];

        return Inertia::render('function-locks/index', [
            'locks' => $locks,
            'availableFunctions' => $availableFunctions
        ]);
    }

    /**
     * Store a newly created function lock.
     */
    public function store(StoreFunctionLockRequest $request)
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Only Super Admins can manage function locks.');
        }

        $lock = FunctionLock::create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('function-locks.index')
            ->with('success', 'Function lock created successfully.');
    }

    /**
     * Remove the specified function lock.
     */
    public function destroy(FunctionLock $functionLock, Request $request)
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Only Super Admins can manage function locks.');
        }

        $functionLock->delete();

        return redirect()->route('function-locks.index')
            ->with('success', 'Function lock removed successfully.');
    }


}