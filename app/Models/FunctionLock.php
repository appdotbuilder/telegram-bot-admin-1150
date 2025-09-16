<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\FunctionLock
 *
 * @property int $id
 * @property string $function_name
 * @property string|null $locked_for_role
 * @property string|null $reason
 * @property bool $is_active
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $creator
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|FunctionLock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FunctionLock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FunctionLock query()
 * @method static \Illuminate\Database\Eloquent\Builder|FunctionLock whereFunctionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FunctionLock whereLockedForRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FunctionLock whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FunctionLock active()

 * 
 * @mixin \Eloquent
 */
class FunctionLock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'function_name',
        'locked_for_role',
        'reason',
        'is_active',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created the lock.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for active function locks.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}