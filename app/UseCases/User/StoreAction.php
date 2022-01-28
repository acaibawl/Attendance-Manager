<?php

namespace App\UseCases\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StoreAction
{
    public function __invoke(User $user): User
    {
        $user->password = Hash::make($user['password']);
        $user->save();
        return $user;
    }
}
