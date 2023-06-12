<?php

namespace App\Http\Controllers;

use App\Jobs\DeletePaste;
use App\Models\Paste;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class PasteController extends Controller
{

    public function index()
    {
        $dataTable = Paste::orderBy('created_at', 'desc')->where('access_paste', 'public')->take(10)->get();

        $myPastes = [];

        if (Auth::check()) {
            $myPastes = Paste::orderBy('created_at', 'desc')->where('user_id', Auth::id())->take(10)->get();
        }
        return View('paste', compact('dataTable', 'myPastes'));
    }

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

    public function expirationTimePaste($expirationTime, $paste)
    {
        switch ($expirationTime) {
            case "10" OR
                 "60" OR
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

    public function paste($hash)
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

    public function create($pasteTextarea, $link, $expirationTime, $access_paste, $user_id)
    {
        return Paste::create([
            "content"         => $pasteTextarea,
            'expiration_time' => $expirationTime,
            "link"            => $link,
            "access_paste"    => $access_paste,
            "user_id"         => $user_id
        ]);
    }
}
