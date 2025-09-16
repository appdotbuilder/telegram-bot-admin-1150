<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ChatConversation
 *
 * @property int $id
 * @property int $telegram_bot_id
 * @property int $bot_user_id
 * @property string|null $subject
 * @property string $status
 * @property int|null $assigned_to
 * @property \Illuminate\Support\Carbon|null $last_message_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\TelegramBot $telegramBot
 * @property-read \App\Models\BotUser $botUser
 * @property-read \App\Models\User|null $assignedUser
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatMessage> $messages
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation open()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation closed()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation pending()
 * @method static \Database\Factories\ChatConversationFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ChatConversation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'telegram_bot_id',
        'bot_user_id',
        'subject',
        'status',
        'assigned_to',
        'last_message_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_message_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the telegram bot that owns the conversation.
     */
    public function telegramBot(): BelongsTo
    {
        return $this->belongsTo(TelegramBot::class);
    }

    /**
     * Get the bot user that owns the conversation.
     */
    public function botUser(): BelongsTo
    {
        return $this->belongsTo(BotUser::class);
    }

    /**
     * Get the assigned user.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the messages for the conversation.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * Scope for open conversations.
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope for closed conversations.
     */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Scope for pending conversations.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}