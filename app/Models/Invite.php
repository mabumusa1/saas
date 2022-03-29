<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Invite.
 *
 * @property int $id
 * @property string $role
 * @property string $email
 * @property string $token
 * @property int $account_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account $account
 * @method static \Database\Factories\InviteFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invite whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invite extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'token',
        'role',
    ];

    /**
     * Get the account that owns the invite.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * The the logs of this model.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('account')
        ->setDescriptionForEvent(fn (string $eventName) =>  __(':First :Last invite was :Action', ['action' => $eventName]));
    }
}
