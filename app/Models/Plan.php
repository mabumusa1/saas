<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

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
        'id',
        'available',
        'stripe_product_id',
        'stripe_monthly_price_id',
        'stripe_yearly_price_id',
        'created_at',
        'updated_at',
        'archived',
        'options',
        'features',
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
            ->setDescriptionForEvent(fn (string $eventName) =>  __('Plan :Action', ['action' => $eventName]));
    }
}
