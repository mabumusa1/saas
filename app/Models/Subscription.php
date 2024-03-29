<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Cashier\Subscription as CashierSubscription;

/**
 * App\Models\Subscription.
 *
 * @property int $id
 * @property int $account_id
 * @property string $name
 * @property string $stripe_id
 * @property string $stripe_status
 * @property string|null $stripe_price
 * @property int|null $quantity
 * @property \Illuminate\Support\Carbon|null $trial_ends_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\Laravel\Cashier\SubscriptionItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Account $owner
 * @property-read Plan|null $plan
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Site> $sites
 * @property-read int|null $sites_count
 * @property-read \App\Models\Account $user
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription active()
 * @method static Builder|Subscription available()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription canceled()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription cancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription ended()
 * @method static \Laravel\Cashier\Database\Factories\SubscriptionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription incomplete()
 * @method static Builder|Subscription newModelQuery()
 * @method static Builder|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription notCanceled()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription notCancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription notOnGracePeriod()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription notOnTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription onGracePeriod()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription onTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription pastDue()
 * @method static Builder|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription recurring()
 * @method static Builder|Subscription whereAccountId($value)
 * @method static Builder|Subscription whereCreatedAt($value)
 * @method static Builder|Subscription whereEndsAt($value)
 * @method static Builder|Subscription whereId($value)
 * @method static Builder|Subscription whereName($value)
 * @method static Builder|Subscription whereQuantity($value)
 * @method static Builder|Subscription whereStripeId($value)
 * @method static Builder|Subscription whereStripePrice($value)
 * @method static Builder|Subscription whereStripeStatus($value)
 * @method static Builder|Subscription whereTrialEndsAt($value)
 * @method static Builder|Subscription whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $site_id
 * @property-read Site|null $site
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription expiredTrial()
 * @method static Builder|Subscription whereSiteId($value)
 */
class Subscription extends CashierSubscription
{
    use HasFactory;

    /**
     * Get the site that belongs to this Subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the plan that owns the Subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'name', 'name');
    }

    /**
     * Get Plan Period.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function period(): Attribute
    {
        return new Attribute(
            get: function () {
                $plan = $this->plan;
                if ($plan->stripe_yearly_price_id === $this->stripe_price) {
                    return 'yearly';
                }
                if ($plan->stripe_monthly_price_id === $this->stripe_price) {
                    return 'monthly';
                }

                return null;
            }
        );
    }

    /**
     * Get Plan Display Name.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function displayName(): Attribute
    {
        $plan = Plan::where('name', $this->name)->first();

        return new Attribute(
            get: fn () => $plan->display_name,
        );
    }
}
