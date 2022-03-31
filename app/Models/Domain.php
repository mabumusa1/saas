<?php

namespace App\Models;

use App\Models\Install;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domain extends Model
{
    use HasFactory;

    /**
     * Get the install that owns the Domain.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function install(): BelongsTo
    {
        return $this->belongsTo(self::class);
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
                    ->setDescriptionForEvent(fn (string $eventName) =>  __(':email :Action as technical contact for :install', ['email' => $this->email, 'action' => $eventName, 'install' => $this->install->name]));
    }
}
