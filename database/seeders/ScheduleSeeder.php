<?php

namespace Database\Seeders;

use App\Models\Attendance\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schedule::factory()->count(10)->create();
    }
}
