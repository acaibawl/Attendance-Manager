<?php

namespace App\Models;

use App\Casts\User\Role;
use App\Models\Attendance\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * ユーザー
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property integer $role
 * @property string $password
 *
 * @property \Illuminate\Database\Eloquent\Collection<Schedule> $schedules
 *
 * @property string[] $monthsHasSchedule
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => Role::class,              // バリューオブジェクトのRole Castクラスを指定
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany('App\Models\Attendance\Schedule');
    }

    public function getMonthsHasScheduleAttribute(): Collection
    {
        return $this->schedules->map(function($item, $key) {
            return $item->date->year . "/" . $item->date->month;
        })->unique();
    }
}
