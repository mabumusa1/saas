<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallBackup extends Model
{
    use HasFactory;

    protected $fillable = ['s3_url'];
}
