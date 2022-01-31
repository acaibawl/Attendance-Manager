<?php

namespace App\Models;

use App\Casts\User\Role;
use App\Models\Attendance\Schedule;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rules\Unique;
use Laravel\Sanctum\HasApiTokens;

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

    public function getMonthsHasScheduleAttribute()
    {
        return $this->schedules->map(function($item, $key) {
            return $item->date->year . "/" . $item->date->month;
        })->unique();
    }
}
