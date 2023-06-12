<?php

namespace App\Http\Controllers;

use App\Jobs\DeletePaste;
use App\Models\Paste;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class PasteController extends Controller
{

    /**
     *
     * Рендерит шаблон страницы с "пастами"
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $dataTable = Paste::orderBy('created_at', 'desc')->where('access_paste', 'public')->take(10)->get();

        $myPastes = [];

        if (Auth::check()) {
            $myPastes = Paste::orderBy('created_at', 'desc')->where('user_id', Auth::id())->take(10)->get();
        }

        return View('paste', compact('dataTable', 'myPastes'));
    }

    /**
     *
     * Обработчик формы при создании "пасты"
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function submit(Request $request)
    {
        $expirationTime = $request->input('expiration_time');
        $pasteTextarea = $request->input('pasteTextarea');
        $access_paste = $request->input('access_paste');
        $user_id = null;

        if (Auth::check()) {
            $user_id = Auth::id();
        }

        $hash = Str::limit(hash('sha256', $pasteTextarea), 4, "") . Str::random(3);
        $link = $hash;

        $paste = $this->create($pasteTextarea, $link, $expirationTime, $access_paste, $user_id);

        if ($expirationTime) {
            $this->expirationTimePaste($expirationTime, $paste);
        }

        $url = route('form.paste', ['hash' => $hash]);
        Cache::put($hash, $pasteTextarea);

        return Redirect::to($url);
    }

    /**
     *
     * Обработчик времени жизни "пасты"
     *
     * @param int $expirationTime
     * @param object $paste
     * @return void
     */
    public function expirationTimePaste(int $expirationTime, object $paste)
    {
        switch ($expirationTime) {
            case "10" or
                "60" or
                "180":
                DeletePaste::dispatch($paste)->delay(now()->addMinutes($expirationTime));
                break;
            case "1440":
                DeletePaste::dispatch($paste)->delay(now()->addDay());
                break;
            case "10080":
                DeletePaste::dispatch($paste)->delay(now()->addWeek());
                break;
            case "43800":
                DeletePaste::dispatch($paste)->delay(now()->addMonth());
                break;
        }
    }

    /**
     *
     * Собирает хешированную ссылку и рендерит шаблон с конкретной "пасто"
     *
     * @param string $hash
     * @return Application|Factory|View|never
     */
    public function paste(string $hash)
    {
        $data = Cache::get($hash);
        $dataTable = Paste::orderBy('created_at', 'desc')->where('access_paste', 'public')->take(10)->get();

        $myPastes = [];

        if (Auth::check()) {
            $myPastes = Paste::orderBy('created_at', 'desc')->where('user_id', Auth::id())->take(10)->get();
        }

        $isCacheLink = false;

        $paste = Paste::where('link', $hash)->first();

        if ($paste) {
            if ($paste->link === $hash) {
                $isCacheLink = true;
            }
        }

        if ($isCacheLink) {
            return View('myPaste', compact('data', 'dataTable', 'myPastes'));
        }

        return abort(404);
    }

    /**
     *
     * Создает "пасту"
     *
     * @param string $pasteTextarea
     * @param string $link
     * @param int $expirationTime
     * @param string $access_paste
     * @param int $user_id
     * @return mixed
     */
    public function create(string $pasteTextarea, string $link, int $expirationTime, string $access_paste, int $user_id = null)
    {
        return Paste::create([
            "content" => $pasteTextarea,
            'expiration_time' => $expirationTime,
            "link" => $link,
            "access_paste" => $access_paste,
            "user_id" => $user_id
        ]);
    }
}
