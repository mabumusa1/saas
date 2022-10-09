<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Backup.
 *
 * @property int $id
 * @property int $install_id
 * @property string $type
 * @property string $status
 * @property string|null $description
 * @property string|null $s3_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Install $install
 * @method static \Database\Factories\BackupFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Backup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Backup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Backup query()
 * @method static \Illuminate\Database\Eloquent\Builder|Backup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Backup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Backup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Backup whereInstallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Backup whereS3Url($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Backup whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Backup whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Backup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Backup extends Model
{
    use HasFactory;

    protected $fillable = ['s3_url', 'description'];

    /**
     * Get the install that owns the Backup.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function install(): BelongsTo
    {
        return $this->belongsTo(Install::class);
    }

    public function restore(): void
    {
        $this->fireModelEvent('restored');
    }
}
