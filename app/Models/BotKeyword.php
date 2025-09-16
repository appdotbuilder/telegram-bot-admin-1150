<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\BotKeyword
 *
 * @property int $id
 * @property int $telegram_bot_id
 * @property string $keyword
 * @property string $response
 * @property string $match_type
 * @property bool $is_active
 * @property int $priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\TelegramBot $telegramBot
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|BotKeyword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BotKeyword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BotKeyword query()
 * @method static \Illuminate\Database\Eloquent\Builder|BotKeyword whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotKeyword whereMatchType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotKeyword whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotKeyword wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotKeyword active()

 * 
 * @mixin \Eloquent
 */
class BotKeyword extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'telegram_bot_id',
        'keyword',
        'response',
        'match_type',
        'is_active',
        'priority',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'priority' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the telegram bot that owns the keyword.
     */
    public function telegramBot(): BelongsTo
    {
        return $this->belongsTo(TelegramBot::class);
    }

    /**
     * Scope for active keywords.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}