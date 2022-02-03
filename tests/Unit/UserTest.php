<?php

namespace Tests\Unit;

use App\Models\Attendance\Schedule;
use App\Models\User;
use App\Models\ValueObjects\User\RoleVO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function monthsHasScheduleIsEmpty()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'John',
            'role' => new RoleVO(30),
        ]);

        $result = $user->months_has_schedule;
        $this->assertTrue($result->isEmpty());
    }

    /** @test */
    public function monthsHasScheduleIs1()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'John',
            'role' => new RoleVO(30),
        ]);

        $user->schedules()->save(Schedule::factory()->create());

        $result = $user->months_has_schedule;
        $this->assertEquals($result->count(), 1);
    }

    /** @test */
    public function monthsHasScheduleIs3()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'John',
            'role' => new RoleVO(30),
        ]);

        $user->schedules()->saveMany([
            Schedule::factory()->create(),
            Schedule::factory()->create(),
            Schedule::factory()->create(),
        ]);

        $result = $user->months_has_schedule;
        $this->assertEquals($result->count(), 3);
    }

        /** @test */
        public function hasScheduleIsTrue()
        {
            /** @var User $user */
            $user = User::factory()->create([
                'name' => 'John',
                'role' => new RoleVO(30),
            ]);

            $user->schedules()->saveMany([
                Schedule::factory()->create([
                    'date' => new Carbon('2022-02-01'),
                ]),
            ]);

            $this->assertTrue($user->hasSchedule(new Carbon('2022-02-01')));
        }

        /** @test */
        public function hasScheduleIsFalse()
        {
            /** @var User $user */
            $user = User::factory()->create([
                'name' => 'John',
                'role' => new RoleVO(30),
            ]);

            $user->schedules()->saveMany([
                Schedule::factory()->create([
                    'date' => new Carbon('2022-02-01'),
                ]),
            ]);

            $this->assertFalse($user->hasSchedule(new Carbon('2022-03-01')));
        }

}
