<?php

namespace App\Services\AuthService\Actions;

use App\Models\User;
use App\Services\AuthService\Data\CreateUserData;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUserAction
{
    use AsAction;

    public function handle(CreateUserData $data): User
    {
        return  User::create([
            'email' => $data->email,
            'name' => $data->name,
            'password' => Hash::make($data->password)
        ]);
    }
}
