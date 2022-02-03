<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use App\Models\ValueObjects\User\RoleVO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private $failResponseStructure;

    public function setUp(): void
    {
        parent::setUp();

        $this->failResponseStructure = [
            'message'
        ];
    }

    /** @test */
    public function store_success()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email' =>'test@test.co.jp',
            'role' => new RoleVO(10),
        ]);

        $params = [
            'name' => 'testName',
            'email' => 'user@test.co.jp',
            'role' => '10',
            'password' => 'testtest',
        ];

        $response = $this->actingAs($user)->postJson(
            route('user'),
            $params
        );

        $response->assertStatus(201);
    }

    /** @test */
    public function store_fail_caused_by_user_role()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email' =>'test@test.co.jp',
            'role' => new RoleVO(9),
        ]);

        $params = [
            'name' => 'testName',
            'email' => 'user@test.co.jp',
            'role' => '10',
            'password' => 'testtest',
        ];

        $response = $this->actingAs($user)->postJson(
            route('user'),
            $params,
        );

        $response->assertForbidden();
    }

    /** @test */
    public function store_fail_caused_by_mail_is_already_exists_()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email' =>'test@test.co.jp',
            'role' => new RoleVO(10),
        ]);

        $params = [
            'name' => 'testName',
            'email' => 'test@test.co.jp',
            'role' => '10',
            'password' => 'testtest',
        ];

        $response = $this->actingAs($user)->postJson(
            route('user'),
            $params,
        );

        $response->assertStatus(422)
                 ->assertInvalid('email', 'emailは既に登録されています。')
                 ->assertJsonStructure($this->failResponseStructure);
    }
}
