<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * Get User Full Name.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ucfirst("{$this->first_name} {$this->last_name}"),
        );
    }
}
