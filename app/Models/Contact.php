<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contact extends Model
{
    use HasFactory;

    /**
     * Get the Install associated with the Contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Install(): HasOne
    {
        return $this->hasOne(Install::class);
    }
}
