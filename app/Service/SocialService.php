<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialService
{
    public function saveSocialData($user)
    {
        $email = $user->getEmail();
        $nickName = $user->getNickname();

        $password = Hash::make('12345678');

        $vkUser = User::firstOrCreate(
            [
                'email' => $email,
            ],
            [
                'email' => $email,
                'password' => $password,
                'name' => $nickName
            ]
        );

        Auth::login($vkUser);

        return $vkUser;
    }
}
