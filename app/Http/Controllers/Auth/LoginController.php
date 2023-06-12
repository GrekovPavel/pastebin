<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     *
     * Рендер шаблона для авторизации
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     *
     * Валидиция данных для входа.
     * При успешной валидации, делает редирект на страницу пользователя
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Логин или пароль введен не правильно'
                ]);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     *
     * "Выходит" из авторизации
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('paste');
    }
}
