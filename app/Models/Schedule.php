<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Schedule
 * @package App\Models
 *
 * @property string  $id
 * @property string  $title
 * @property string  $description
 * @property integer $duration
 * @property string  $user_id
 * @property Carbon  $date_start
 * @property Carbon  $date_end
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read User|null $user
 */
class Schedule extends Model
{
    use HasUUID;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'user_id',
        'date_start',
        'date_end'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param Builder $query
     * @param $dateStart
     * @return Builder
     */
    public function scopeDateStart(Builder $query, $dateStart): Builder
    {
        return $query->where('date_start', '>=', $dateStart);
    }

    /**
     * @param Builder $query
     * @param $dateEnd
     * @return Builder
     */
    public function scopeDateEnd(Builder $query, $dateEnd): Builder
    {
        return $query->where('date_end', '<=', $dateEnd);
    }
}
