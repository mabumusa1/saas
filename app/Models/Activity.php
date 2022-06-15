<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

/**
 * App\Models\Activity.
 *
 * @property int $id
 * @property string|null $log_name
 * @property string $description
 * @property string|null $subject_type
 * @property string|null $event
 * @property int|null $subject_id
 * @property string|null $causer_type
 * @property int|null $causer_id
 * @property int|null $account_id
 * @property \Illuminate\Support\Collection|null $properties
 * @property string|null $batch_uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Account|null $account
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $causer
 * @property-read \Illuminate\Support\Collection $changes
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $subject
 *
 * @method static Builder|Activity causedBy(\Illuminate\Database\Eloquent\Model $causer)
 * @method static \Database\Factories\ActivityFactory factory(...$parameters)
 * @method static Builder|Activity forBatch(string $batchUuid)
 * @method static Builder|Activity forEvent(string $event)
 * @method static Builder|Activity forSubject(\Illuminate\Database\Eloquent\Model $subject)
 * @method static Builder|Activity hasBatch()
 * @method static Builder|Activity inLog(...$logNames)
 * @method static Builder|Activity newModelQuery()
 * @method static Builder|Activity newQuery()
 * @method static Builder|Activity onAccount(int $accountId)
 * @method static Builder|Activity query()
 * @method static Builder|Activity whereAccountId($value)
 * @method static Builder|Activity whereBatchUuid($value)
 * @method static Builder|Activity whereCauserId($value)
 * @method static Builder|Activity whereCauserType($value)
 * @method static Builder|Activity whereCreatedAt($value)
 * @method static Builder|Activity whereDescription($value)
 * @method static Builder|Activity whereEvent($value)
 * @method static Builder|Activity whereId($value)
 * @method static Builder|Activity whereLogName($value)
 * @method static Builder|Activity whereProperties($value)
 * @method static Builder|Activity whereSubjectId($value)
 * @method static Builder|Activity whereSubjectType($value)
 * @method static Builder|Activity whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Activity extends SpatieActivity implements ActivityContract
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    /**
     * Get the account for this activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Scope a query to only include activity for a specific account.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @param  int  $accountId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnAccount(Builder $query, int $accountId): Builder
    {
        return $query->where('account_id', $accountId);
    }
}
