<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Transfer extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'install_id',
        'email',
        'code',
    ];

    /**
     * Get the account that owns the Transfer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the install that uses this trnasfer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function install(): BelongsTo
    {
        return $this->belongsTo(Install::class);
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
        ->setDescriptionForEvent(fn (string $eventName) =>  __('Transfer :Action', ['action' => $eventName]));
    }
}
