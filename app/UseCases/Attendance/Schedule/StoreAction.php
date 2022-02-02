<?php

namespace App\UseCases\Attendance\Schedule;

use App\Models\Attendance\Schedule;
use App\Models\User;
use App\UseCases\Attendance\Schedule\Exceptions\StoreScheduleException;
use Illuminate\Support\Carbon;

class StoreAction
{
    public function __invoke(User $user, Carbon $dt)
    {
        if($user->hasSchedule($dt)) {
            throw new StoreScheduleException("既にスケジュールが作成されている月です");
        }

        $schedules = [];
        $endOfMonthNum = $dt->copy()->endOfMonth()->day;
        for($i = 1; $i <= $endOfMonthNum; $i++) {
            $newSchedule = new Schedule([
                'is_over_next_day' => false,
                'date' => $dt->copy()->day($i),
                'start' => '09:00:00',
                'end' => '18:00:00'
            ]);
            array_push($schedules, $newSchedule);
        }

        $user->schedules()->saveMany($schedules);
        return $schedules;
    }
}
