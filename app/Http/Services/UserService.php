<?php

namespace App\Http\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class UserService
{
    private ?User $user = null;

    public function __construct()
    {
        return $this;
    }

    public function login(array $parameters)
    {

        $user = User::where('email', $parameters['userEmail'])->first();

        if ($user === null)
            throw new \Exception(Lang::get('services.userservice.wrongmail'));

        if (!Hash::check($parameters['userPassword'], $user->password))
            throw new \Exception(Lang::get('services.userservice.wrongpassword'));

        $this->user = $user;
        auth()->login($user);

        return $user;
    }


}

