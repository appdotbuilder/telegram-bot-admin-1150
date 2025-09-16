<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\BotUser
 *
 * @property int $id
 * @property int $telegram_bot_id
 * @property string $telegram_id
 * @property string|null $username
 * @property string|null $first_name
 * @property string|null $last_name
 * @property bool $is_blocked
 * @property \Illuminate\Support\Carbon|null $last_interaction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\TelegramBot $telegramBot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatConversation> $conversations
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|BotUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BotUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BotUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|BotUser whereTelegramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotUser whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotUser whereIsBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotUser active()
 * @method static \Database\Factories\BotUserFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class BotUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'telegram_bot_id',
        'telegram_id',
        'username',
        'first_name',
        'last_name',
        'is_blocked',
        'last_interaction',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_blocked' => 'boolean',
        'last_interaction' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the telegram bot that owns the user.
     */
    public function telegramBot(): BelongsTo
    {
        return $this->belongsTo(TelegramBot::class);
    }

    /**
     * Get the chat conversations.
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(ChatConversation::class);
    }

    /**
     * Scope for active (non-blocked) users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_blocked', false);
    }

    /**
     * Get display name for the user.
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->first_name && $this->last_name) {
            return $this->first_name . ' ' . $this->last_name;
        }
        
        return $this->first_name ?? $this->username ?? "User {$this->telegram_id}";
    }
}