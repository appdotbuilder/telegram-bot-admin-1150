<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\TelegramBot
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $username
 * @property string $token
 * @property string|null $description
 * @property bool $is_active
 * @property array|null $settings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BotCommand> $commands
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BotKeyword> $keywords
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BotUser> $botUsers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatConversation> $conversations
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramBot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramBot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramBot query()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramBot whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramBot whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramBot whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramBot active()
 * @method static \Database\Factories\TelegramBotFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class TelegramBot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'username',
        'token',
        'description',
        'is_active',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the bot.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the commands for the bot.
     */
    public function commands(): HasMany
    {
        return $this->hasMany(BotCommand::class);
    }

    /**
     * Get the keywords for the bot.
     */
    public function keywords(): HasMany
    {
        return $this->hasMany(BotKeyword::class);
    }

    /**
     * Get the bot users.
     */
    public function botUsers(): HasMany
    {
        return $this->hasMany(BotUser::class);
    }

    /**
     * Get the chat conversations.
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(ChatConversation::class);
    }

    /**
     * Scope for active bots.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}