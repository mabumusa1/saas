<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Install extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_id',
        'name',
        'type',
        'tech_contact_first_name',
        'tech_contact_last_name',
        'tech_contact_email',
        'tech_contact_phone',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'site_id' => 'integer',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
