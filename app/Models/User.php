<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    public const STATUS_NEW = 'new';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_BANNED = 'banned';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'discord_id',
        'minecraft_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'whitelisted_at' => 'datetime'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    protected function whitelisted(): Attribute
    {
        return Attribute::make(
            fn ($value, $attributes) => !empty($attributes['whitelisted_at']),
            fn ($value) => [
                'whitelisted_at' => $value ? now() : null,
                'status' => $value ? self::STATUS_ACTIVE : self::STATUS_INACTIVE
            ]
        );
    }

    protected function banned(): Attribute
    {
        return Attribute::make(
            fn ($value, $attributes) => $attributes['status'] === self::STATUS_BANNED,
            fn ($value) => [
                'whitelisted_at' => $value ? null : now(),
                'status' => $value ? self::STATUS_BANNED : self::STATUS_ACTIVE
            ]
        );
    }

    /**
     * check if a user is an administrator
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->role->slug === Role::ADMIN;
    }

    /**
     * check if a user is a staff member
     *
     * @return boolean
     */
    public function isStaff(): bool
    {
        return in_array($this->role->slug, [Role::ADMIN, Role::STAFF]);
    }
}
