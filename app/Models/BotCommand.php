<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\BotCommand
 *
 * @property int $id
 * @property int $telegram_bot_id
 * @property string $command
 * @property string $response
 * @property string $type
 * @property array|null $options
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\TelegramBot $telegramBot
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|BotCommand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BotCommand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BotCommand query()
 * @method static \Illuminate\Database\Eloquent\Builder|BotCommand whereCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotCommand whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotCommand whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotCommand active()

 * 
 * @mixin \Eloquent
 */
class BotCommand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'telegram_bot_id',
        'command',
        'response',
        'type',
        'options',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'options' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the telegram bot that owns the command.
     */
    public function telegramBot(): BelongsTo
    {
        return $this->belongsTo(TelegramBot::class);
    }

    /**
     * Scope for active commands.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}