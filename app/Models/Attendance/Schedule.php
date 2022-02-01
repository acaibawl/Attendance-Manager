<?php

namespace App\Models\Attendance;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * スケジュール
 *
 * @property integer $id
 * @property integer $user_id
 * @property bool $is_over_next_day
 * @property \Illuminate\Support\Carbon $date
 * @property string $start
 * @property string $end
 *
 * @property User $user
 */
class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'is_over_next_day',
        'date',
        'start',
        'end',
    ];

        /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
