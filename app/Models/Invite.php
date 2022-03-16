<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'token',
        'role',
    ];

    /**
     * Get the account that owns the invite.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo<Account>
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
