<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\AccountUser.
 *
 * @property int $id
 * @property int $account_id
 * @property int $user_id
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Activity> $activities
 * @property-read int|null $activities_count
 *
 * @method static \Database\Factories\AccountUserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountUser whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountUser whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountUser whereUserId($value)
 *
 * @mixin \Eloquent
 */
class AccountUser extends Pivot
{
    use LogsActivity, HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The the logs of this model.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('account')
            ->setDescriptionForEvent(function (string $eventName) {
                switch ($eventName) {
                        case 'created':
                            /* @phpstan-ignore-next-line */
                            return __(':User associated with :Account', ['user' => $this->user->fullName, 'account' => $this->account->name]);
                        case 'updated':
                            /* @phpstan-ignore-next-line */
                            return __(':User changed role to :Role with :Account', ['user' => $this->user->fullName, 'role' => roles()[$this->role], 'account' => $this->account->name]);
                        case 'deleted':
                            /* @phpstan-ignore-next-line */
                            return __(':User removed from :Account', ['user' => $this->user->fullName, 'account' => $this->account->name]);
                    }
            });
    }

    /**
     * Get the user that owns the AccountUser.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the account that owns the AccountUser.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
