<?php

namespace App\Models;

use App\Events\AccountUpdatedEvent;
use App\Models\Cashier\Subscription;
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
     * The Sites that belong to the Account.
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
            ->useLogName('account');
    }
}
