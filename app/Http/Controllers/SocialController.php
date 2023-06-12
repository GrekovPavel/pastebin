<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Service\SocialService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    /**
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function index()
    {
        return Socialite::driver('vkontakte')->redirect();
    }

    /**
     * @return RedirectResponse
     */
    public function callback()
    {
        $user = Socialite::driver('vkontakte')->user();

        $objSocial = new SocialService();

        if ($objSocial->saveSocialData($user)) {

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return back();
    }
}
