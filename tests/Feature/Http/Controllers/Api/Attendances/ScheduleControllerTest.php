<?php

namespace Tests\Feature\Http\Controllers\Api\Attendances;

use App\Models\Attendance\Schedule;
use App\Models\User;
use App\Models\ValueObjects\User\RoleVO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    private $successResponseStructure;
    private $failResponseStructure;

    public function setUp(): void
    {
        parent::setUp();
        $this->successResponseStructure = [
            '*' => [
                'id',
                'is_over_next_day',
                'date',
                'start',
                'end',
            ]
        ];

        $this->failResponseStructure = [
            'message'
        ];
    }

    /** @test */
    public function index_count_is_2()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $includeDt1 = new Carbon('2022-02-01 00:00:00');
        $includeDt2 = new Carbon('2022-02-02 00:00:00');
        $excludeDt = new Carbon('2022-03-01 00:00:00');

        $user->schedules()->saveMany([
            Schedule::factory()->create(['date' => $includeDt1]),
            Schedule::factory()->create(['date' => $includeDt2]),
            Schedule::factory()->create(['date' => $excludeDt]),
        ]);

        $response = $this->actingAs($user)->json(
            'GET',
            route('user.attendance.schedule', ['user' => $user->id]),
            ['year' => 2022, 'month' => 2]
        );

        $response->assertOK()
            ->assertJsonCount(2)
            ->assertJsonFragment([
                'date' => $includeDt1->jsonSerialize(),
                'date' => $includeDt2->jsonSerialize(),
            ])
            ->assertJsonMissing([
                'date' => $excludeDt->jsonSerialize()
            ])
            ->assertJsonStructure($this->successResponseStructure);
    }

    /** @test */
    public function index_count_is_0()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->schedules()->saveMany([
            Schedule::factory()->create(['date' => new Carbon('2022-02-01 00:00:00')]),
            Schedule::factory()->create(['date' => new Carbon('2022-02-02 00:00:00')]),
            Schedule::factory()->create(['date' => new Carbon('2022-03-01 00:00:00')]),
        ]);

        $params = ['year' => 2023, 'month' => 2];

        $response = $this->actingAs($user)->json(
            'GET',
            route('user.attendance.schedule', ['user' => $user->id]),
            $params
        );

        $response->assertUnprocessable()
                 ->assertJsonFragment([
                    'message' => 'スケジュールがありません。',
                 ])
                ->assertJsonStructure($this->failResponseStructure);
    }

    /** @test */
    public function store_success()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'role' => new RoleVO(10),
        ]);

        $params = ['date' => '2022-02-01'];

        $response = $this->actingAs($user)->postJson(
            route('user.attendance.schedule', ['user' => $user->id]),
            $params
        );

        $response->assertStatus(201)
                 ->assertJsonStructure($this->successResponseStructure);
    }

    /** @test */
    public function store_fail_caused_by_user_role()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'role' => new RoleVO(9),
        ]);

        $user->schedules()->save(Schedule::factory()->create([
            'date' => new Carbon('2022-02-01 00:00:00'),
        ]));

        $params = ['date' => new Carbon('2022-01-01')];

        $response = $this->actingAs($user)->postJson(
            route('user.attendance.schedule', ['user' => $user->id]),
            $params
        );

        $response->assertForbidden();
    }

    /** @test */
    public function store_fail_caused_by_already_exists(Type $var = null)
    {
        /** @var User $user */
        $user = User::factory()->create([
            'role' => new RoleVO(10),
        ]);

        $user->schedules()->save(Schedule::factory()->create([
                'date' => new Carbon('2022-01-01 00:00:00'),
        ]));

        $params = ['date' => new Carbon('2022-01-01')];

        $response = $this->actingAs($user)->postJson(
            route('user.attendance.schedule', ['user' => $user->id]),
            $params
        );

        $response->assertUnprocessable()
                 ->assertJsonFragment([
                     'message' => '既にスケジュールが作成されている月です',
                 ])
                 ->assertJsonStructure($this->failResponseStructure);
    }
}
