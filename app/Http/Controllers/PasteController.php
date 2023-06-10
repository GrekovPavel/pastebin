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

    public function index() {

        $dataTable = Paste::all();

        return View('paste', compact('dataTable'));
    }

    public function submit(Request $request) {

        $expirationTime = $request->input('expiration_time');

        $request = $request->input('pasteTextarea');
        $hash = Str::limit(hash('sha256', $request), 4, "") . Str::random(3);
        $link = $hash;
        $paste = $this->create($request, $link, $expirationTime);

        if ($expirationTime) {
            $this->expirationTimePaste($expirationTime, $paste);
        }

        $url = route('form.paste', ['hash' => $hash]);
        Cache::put($hash, $request);

        return Redirect::to($url);
    }

    public function expirationTimePaste($expirationTime, $paste)
    {
        if ($expirationTime === "10" || $expirationTime === "60" || $expirationTime === "180") {
            DeletePaste::dispatch($paste)->delay(now()->addMinutes($expirationTime));
        } elseif ($expirationTime === "1440") {
            DeletePaste::dispatch($paste)->delay(now()->addDay());
        } elseif ($expirationTime === "10080") {
            DeletePaste::dispatch($paste)->delay(now()->addWeek());
        } elseif ($expirationTime === "43800") {
            DeletePaste::dispatch($paste)->delay(now()->addMonth());
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

    public function create($request, $link, $expirationTime) {

       return Paste::create([
            "content" => $request,
            'expiration_time' => $expirationTime,
            "link" => $link,
            "visibility" => "public"
        ]);
    }
}
