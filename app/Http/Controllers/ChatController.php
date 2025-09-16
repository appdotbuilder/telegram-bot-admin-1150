<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatMessageRequest;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    /**
     * Display a listing of conversations.
     */
    public function index(Request $request)
    {
        if (!$request->user()->canAccessFunction('live_chat')) {
            abort(403, 'Access denied to Live Chat.');
        }

        $conversations = ChatConversation::with(['botUser', 'telegramBot', 'assignedUser'])
            ->when(!$request->user()->isAdmin(), function ($query) use ($request) {
                return $query->whereHas('telegramBot', function ($q) use ($request) {
                    $q->where('user_id', $request->user()->id);
                });
            })
            ->when($request->status, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->latest('last_message_at')
            ->paginate(20);

        return Inertia::render('chat/index', [
            'conversations' => $conversations,
            'filters' => $request->only(['status'])
        ]);
    }

    /**
     * Display the specified conversation.
     */
    public function show(ChatConversation $conversation, Request $request)
    {
        if (!$request->user()->canAccessFunction('live_chat')) {
            abort(403, 'Access denied to Live Chat.');
        }

        if (!$request->user()->isAdmin() && $conversation->telegramBot->user_id !== $request->user()->id) {
            abort(403, 'You can only view conversations from your own bots.');
        }

        $conversation->load(['botUser', 'telegramBot', 'assignedUser']);
        
        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        // Mark messages as read
        $conversation->messages()
            ->where('sender_type', 'bot_user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return Inertia::render('chat/show', [
            'conversation' => $conversation,
            'messages' => $messages
        ]);
    }

    /**
     * Store a new message in the conversation.
     */
    public function store(StoreChatMessageRequest $request, ChatConversation $conversation)
    {
        if (!$request->user()->canAccessFunction('live_chat')) {
            abort(403, 'Access denied to Live Chat.');
        }

        if (!$request->user()->isAdmin() && $conversation->telegramBot->user_id !== $request->user()->id) {
            abort(403, 'You can only reply to conversations from your own bots.');
        }

        $message = $conversation->messages()->create([
            'message' => $request->validated()['message'],
            'sender_type' => 'admin',
            'sender_id' => $request->user()->id,
            'message_type' => 'text',
            'is_read' => true,
        ]);

        // Update conversation
        $conversation->update([
            'last_message_at' => now(),
            'status' => 'open'
        ]);

        // TODO: Send message to Telegram bot user
        
        return back()->with('success', 'Message sent successfully.');
    }

    /**
     * Update conversation status or assignment.
     */
    public function update(Request $request, ChatConversation $conversation)
    {
        if (!$request->user()->canAccessFunction('live_chat')) {
            abort(403, 'Access denied to Live Chat.');
        }

        if (!$request->user()->isAdmin() && $conversation->telegramBot->user_id !== $request->user()->id) {
            abort(403, 'You can only manage conversations from your own bots.');
        }

        $validated = $request->validate([
            'status' => 'sometimes|in:open,closed,pending',
            'assigned_to' => 'sometimes|nullable|exists:users,id'
        ]);

        $conversation->update($validated);

        return back()->with('success', 'Conversation updated successfully.');
    }
}