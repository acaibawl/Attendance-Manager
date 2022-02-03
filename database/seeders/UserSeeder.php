<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ValueObjects\User\RoleVO;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(['role' => new RoleVO(30)])->count(1)->hasSchedules(1)->create();
    }
}
