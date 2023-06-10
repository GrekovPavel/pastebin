<?php

namespace App\Http\Controllers;

use App\Jobs\DeletePaste;
use App\Models\Paste;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class PasteController extends Controller
{

    public function index()
    {
        $dataTable = Paste::all();

        return View('paste', compact('dataTable'));
    }

    public function submit(Request $request)
    {
        $expirationTime = $request->input('expiration_time');
        $pasteTextarea = $request->input('pasteTextarea');

        $hash = Str::limit(hash('sha256', $pasteTextarea), 4, "") . Str::random(3);
        $link = $hash;

        $paste = $this->create($pasteTextarea, $link, $expirationTime);

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
        $dataTable = Paste::all();

        if ($data) {
            return View('myPaste', compact('data', 'dataTable'));
        }

        return abort(404);
    }

    public function create($pasteTextarea, $link, $expirationTime)
    {
        return Paste::create([
            "content"         => $pasteTextarea,
            'expiration_time' => $expirationTime,
            "link"            => $link,
            "visibility"      => "public"
        ]);
    }
}
