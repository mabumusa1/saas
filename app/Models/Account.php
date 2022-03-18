<?php

namespace App\Models;

use App\Models\AccountUser;
use App\Models\Cashier\Subscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Illuminate\Events\queueable;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Cashier;
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
    public function Users(): BelongsToMany
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
    public function Sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    /**
     * Get all of the subscriptions for the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Subscription>
     */
    public function Subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get all of the installs for the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function Installs(): HasManyThrough
    {
        return $this->hasManyThrough(Install::class, Site::class);
    }

    /**
     * Get all of the Groups for the Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::updated(queueable(function ($customer) {
            if ($customer->hasStripeId()) {
                $customer->syncStripeCustomerDetails();
            }
        }));
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

    public function stripeEmail()
    {
        return $this->email;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('account');
    }
}
