<?php

namespace App\UseCases\Attendance\Schedule;

use App\Models\User;
use App\UseCases\Attendance\Schedule\Exceptions\NonScheduleException;
use Illuminate\Support\Carbon;

class IndexAction
{
    public function __invoke(User $user, Carbon $dt)
    {
        $schedules = $user->schedules()
                        ->whereYear('date', $dt->year)
                        ->whereMonth('date', $dt->month)
                        ->get();
        if($schedules->isEmpty()) {
            throw new NonScheduleException("スケジュールがありません。");
        }

        return $schedules;
    }
}
