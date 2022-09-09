<?php

namespace App\Models;

use App\Events\AccountUpdatedEvent;
use App\Models\Cashier\Subscription;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Account.
 *
 * @property int $id
 * @property int $data_center_id
 * @property string $name
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\DataCenter $dataCenter
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Install> $installs
 * @property-read int|null $installs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Invite> $invites
 * @property-read int|null $invites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Site> $sites
 * @property-read int|null $sites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\User> $users
 * @property-read int|null $users_count
 *
 * @method static \Database\Factories\AccountFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Query\Builder|Account onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereDataCenterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Account withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Account withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Account extends Model
{
    use HasFactory, SoftDeletes, Billable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'quota',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'updated' => AccountUpdatedEvent::class,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>
     */
    protected $guarded = [
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
    ];

    /**
     * Get the Data Center that owns the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataCenter(): BelongsTo
    {
        return $this->belongsTo(DataCenter::class);
    }

    /**
     * The Users that belong to the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(AccountUser::class)->withPivot('role');
    }

    /**
     * The invites that belong to the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Invite>
     */
    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class);
    }

    /**
     * Get all of the sites for the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    /**
     * Get all of the subscriptions for the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Subscription>
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get all of the installs for the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function installs(): HasManyThrough
    {
        return $this->hasManyThrough(Install::class, Site::class);
    }

    /**
     * Get all of the Groups for the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    /**
     * Get the customer name that should be synced to Stripe.
     *
     * @return string|null
     */
    public function stripeName()
    {
        return $this->name;
    }

    /**
     * Get the customer email that should be synced to Stripe.
     *
     * @return string|null
     */
    public function stripeEmail()
    {
        return $this->email;
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
            ->setDescriptionForEvent(fn (string $eventName) => __(':Name :Action', ['name' => $this->name, 'action' => $eventName]));
    }

    /**
     * Get avaialbeQouta for transferable sites.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function availableQuota(): Attribute
    {
        return new Attribute(
            get: function () {
                if ($this->quota === 0) {
                    return $this->quota;
                }

                return $this->quota - $this->installs()->where(['owner', 'transferable'])->count();
            }
        );
    }

    /**
     * Get avaialbeQouta for transferable sites.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function activeSubscriptions(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->subscriptions()->active()->available()->withCount('sites')->get();
            }
        );
    }

    /**
     * Get totalActiveSubscriptions for transferable sites.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function totalActiveSubscriptions(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->subscriptions()->active()->sum('quantity');
            }
        );
    }

    /**
     * Get availableSubscriptions for transferable sites.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function availableSubscriptions(): Attribute
    {
        return new Attribute(
            get: function () {
                /* @phpstan-ignore-next-line */
                return $this->activeSubscriptions->sum('quantity') - $this->activeSubscriptions->sum('sites_count');
            }
        );
    }
}
