<?php

namespace App\Models;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Site.
 *
 * @property int $id
 * @property int $account_id
 * @property int|null $subscription_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Account $account
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Install> $installs
 * @property-read int|null $installs_count
 * @property-read Subscription|null $subscription
 * @method static \Database\Factories\SiteFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site newQuery()
 * @method static \Illuminate\Database\Query\Builder|Site onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Site query()
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Site withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Site withoutTrashed()
 * @mixin \Eloquent
 * @property bool $transferable
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereTransferable($value)
 */
class Site extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'subscription_id',
        'account_id',
        'transferable',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transferable' => 'boolean',
    ];

    /**
     * Get the Account that owns the Site.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get all of the Installs for the Site.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function installs(): HasMany
    {
        return $this->hasMany(Install::class);
    }

    /**
     * Get all of the Groups for the Site.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    /**
     * Get the Subscription for the Site.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class, 'id', 'subscription_id');
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
            ->setDescriptionForEvent(fn (string $eventName) => __('Site :Action', ['action' => $eventName]));
    }

    public function hasInstallType(string $type): bool
    {
        return $this->installs()->where('type', $type)->count() >= 1;
    }
}
