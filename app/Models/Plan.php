<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Plan.
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $short_description
 * @property string|null $stripe_product_id
 * @property string|null $stripe_monthly_price_id
 * @property string|null $stripe_yearly_price_id
 * @property string|null $monthly_price
 * @property string|null $yearly_price
 * @property int|null $contacts
 * @property array|null $features
 * @property array|null $options
 * @property int $archived
 * @property int $available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Activity> $activities
 * @property-read int|null $activities_count
 *
 * @method static \Database\Factories\PlanFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereArchived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereMonthlyPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereStripeMonthlyPriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereStripeProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereStripeYearlyPriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereYearlyPrice($value)
 *
 * @mixin \Eloquent
 */
class Plan extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'short_description',
        'stripe_product_id',
        'stripe_monthly_price_id',
        'stripe_yearly_price_id',
        'monthly_price',
        'yearly_price',
        'features',
        'contacts',
        'options',
        'available',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'features' => 'array',
        'options' => 'array',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'available',
        'stripe_product_id',
        'stripe_monthly_price_id',
        'stripe_yearly_price_id',
        'created_at',
        'updated_at',
        'archived',
        'options',
    ];

    /**
     * The the logs of this model.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('system')
            ->setDescriptionForEvent(fn (string $eventName) => __('Plan :Action', ['action' => $eventName]));
    }

    /**
     * Get the plan contacts number.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function contacts(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0),
        );
    }

    /**
     * Get the plan monthly price.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function monthlyPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0),
        );
    }

    /**
     * Get the plan annual price.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function yearlyPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0),
        );
    }
}
