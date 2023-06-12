<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Service\SocialService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class DashboardController extends Controller
{
    /**
     *
     * Рендерит шаблон страницы пользователя
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $myPastes = [];

        if (Auth::check()) {
            $myPastes = Paste::where('user_id', Auth::id())->paginate(5);
        }
        return View('dashboard', compact('myPastes'));
    }
}
